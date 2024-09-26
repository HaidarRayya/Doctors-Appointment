<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppointmentController extends Controller
{

    public function addAppointment(Request $request)
    {
        $doctor = User::find($request->doctor_id);
        $startdate = Carbon::create($request->appointmentDate);
        $n = Carbon::create($request->appointmentDate);
        $enddate = $n->addMinutes($doctor->treatmentDuration);
        $fromFailds = [
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointmentDate' => $request->appointmentDate,
            'appointmentEndDate' => $enddate
        ];
        $dd = Carbon::create($request->appointmentDate);
        $year = $dd->year;
        $month = $dd->month;
        $day = $dd->day;
        $x = $day + 1;
        $d1 = Carbon::create($year, $month, $day, 0, 0, 0);
        $d2 = Carbon::create($year, $month, $x, 0, 0, 0);
        if ($doctor->points >= 10) {
            $appointments = Appointment::getDailyAppointments($request->patient_id, $d1, $d2);
            if ($appointments->isEmpty()) {
                Appointment::create($fromFailds);
                $doctor->update([
                    'points' => $doctor->points - 10
                ]);
                return   redirect()->back()->with('message', "تم حجز الوعد بنجاح");
            } else {
                foreach ($appointments as $appointment) {
                    $date1 = Carbon::create($appointment->appointmentDate);
                    $date2 = Carbon::create($appointment->appointmentEndDate);
                    if ($startdate->lessThan($date1)) {
                        if ($enddate->lessThanOrEqualTo($date1)) {
                            continue;
                        } else {
                            return   redirect()->back()->with('message', "الموعد الذي اخترته يتعارض مع مواعيدك يرجى اختيار موعد اخر");
                        }
                    } else {
                        if ($startdate->greaterThanOrEqualTo($date2))
                            continue;
                        else
                            return   redirect()->back()->with('message', "الموعد الذي اخترته يتعارض مع مواعيدك يرجى اختيار موعد اخر");
                    }
                }
                Appointment::create($fromFailds);
                $doctor->update([
                    'points' => $doctor->points - 10
                ]);
                return   redirect()->back()->with('message', "تم حجز الوعد بنجاح");
            }
        } else {
            $msgForDoctor = [
                'subject' => "لا يتوفر رصيد كافي للحجز",
                "body" => "  مرحبا دكتور " . "  " .  $doctor->fullname . "   "
                    . "لا يتوفر رصيد في حسابك للقيام بعمليات الحجز يرجى اعادة تعبئة الحساب "
            ];
            MailController::deleteAppointemt($msgForDoctor, $doctor->email);
            return   redirect()->back()->with('message', "لا يمكن حجز الموعد حاليا يرجى اعادة المحاولة لاحقا");
        }
    }

    public function doctorDddAppointment(Request $request)
    {
        $fromFailds = $request->validate([
            'fullname' => 'required',
            'email' => ['required', 'email'],
            'time' => 'required'
        ]);
        $d = Carbon::now();
        if ($d->day > $request->day) {
            return   redirect()->back()->with('message', "لا يمكن الحجز قمت باختيار يوم خاطئ ");
        }
        $p = User::findPatient($fromFailds['email']);
        $pa = User::find($p[0]->id);

        if ($fromFailds['fullname'] != $pa->fullname) {
            return   redirect()->back()->with('message', "الاسم الذي ادخلته لا يطابق الحساب يرجى التأكد من المعلومات واعادة المحاولة");
        }
        $hour = intval(substr($fromFailds['time'], 0, 2));
        $minute = intval(substr($fromFailds['time'], 3, 2));
        $date = Carbon::create($request->year, $request->month, $request->day, $hour, $minute);
        $doctor_id = Auth::user()->id;
        $doctor = User::find($doctor_id);
        if ($doctor->points >= 10) {
            $dates = UserController::getDailyDates($doctor, $request->year, $request->month, $request->day);
            $appointments = Appointment::doctorAppointments($doctor_id);
            $availableAppointment = [];
            $m = false;
            if ($appointments->isEmpty()) {
                foreach ($dates as $d) {
                    array_push($availableAppointment, $d[2]);
                }
            }
            foreach ($dates as $d) {
                foreach ($appointments as $a) {
                    $x = Carbon::create($a->appointmentDate);
                    if ($d[2] === $x->format('h:i:s A')) {
                        $m = false;
                        break;
                    } else {
                        $m = true;
                    }
                }
                if ($m) {
                    array_push($availableAppointment, $d[2]);
                }
            }
            $m = false;
            foreach ($availableAppointment as $i) {
                if ($i === $date->format('h:i:s A')) {
                    $m = true;
                }
            }
            if ($m) {
                $patient_id = $p[0]->id;
                $startdate = Carbon::create($request->year, $request->month, $request->day, $hour, $minute);;
                $enddate = $date->addMinutes($doctor->treatmentDuration);

                $year = $request->year;
                $month = $request->month;
                $day = $request->day;
                $x = $day + 1;
                $d1 = Carbon::create($year, $month, $day, 0, 0, 0);
                $d2 = Carbon::create($year, $month, $x, 0, 0, 0);

                $data = [
                    'doctor_id' => $doctor_id,
                    'patient_id' => $patient_id,
                    'appointmentDate' => $startdate,
                    'appointmentEndDate' => $enddate
                ];
                $appointments = Appointment::getDailyAppointments($patient_id, $d1, $d2);
                if ($appointments->isEmpty()) {
                    Appointment::create($data);
                    $doctor->update([
                        'points' => $doctor->points - 10
                    ]);
                    return   redirect()->back()->with('message', "تم حجز الوعد بنجاح");
                } else {
                    foreach ($appointments as $appointment) {
                        $date1 = Carbon::create($appointment->appointmentDate);
                        $date2 = Carbon::create($appointment->appointmentEndDate);

                        if ($startdate->lessThan($date1)) {
                            if ($enddate->lessThanOrEqualTo($date1)) {
                                continue;
                            } else {
                                return   redirect()->back()->with('message', "الموعد الذي اخترته يتعارض مع مواعيدك يرجى اختيار موعد اخر");
                            }
                        } else {
                            if ($startdate->greaterThanOrEqualTo($date2))
                                continue;
                            else
                                return   redirect()->back()->with('message', "الموعد الذي اخترته يتعارض مع مواعيدك يرجى اختيار موعد اخر");
                        }
                    }
                    Appointment::create($data);
                    $doctor->update([
                        'points' => $doctor->points - 10
                    ]);
                    return  redirect()->back()->with('message', "تم حجز الوعد بنجاح");
                }
            } else {
                return   redirect()->back()->with('message', "الموعد الذي قمت باختيار غير صحيح  يرجى التاكد من مواعيد واعادة المحاولة");
            }
        } else {
            return  redirect()->back()->with('message', "لا يتوفر رصيد كافي للقيام بعملية الحجز يرجى اعادة التعبئة والمحاولة من جديد");
        }
    }
    public function unavailableAppointment(Request $request)
    {

        $doctor = User::find($request->doctor_id);
        $startdate = Carbon::create($request->appointmentDate);
        $enddate = $startdate->addMinutes($doctor->treatmentDuration);
        $fromFailds = [
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointmentDate' => $request->appointmentDate,
            'appointmentEndDate' => $enddate
        ];
        Appointment::create($fromFailds);
        return back();
    }


    public function deleteAppointment($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment->patient_id != $appointment->doctor_id) {
            $patent = User::find($appointment->patient_id);
            $doctor = User::find($appointment->doctor_id);
            if (Auth::user()->role === "doctor") {

                $msgForPatient = [
                    'subject' => "الغاء حجز موعد",
                    "body" => "مرحبا" . "  " .  $patent->fullname . "   "
                        . "تم الغاء موعد" . "  " . $appointment->appointmentDate . "عند الدكتور " . "  " .  $doctor->fullname
                ];
                MailController::deleteAppointemt($msgForPatient, $patent->email);
            } elseif (Auth::user()->role === "patient") {
                $msgForDoctor = [
                    'subject' => "الغاء حجز موعد",
                    "body" => "  مرحبا دكتور " . "  " .  $doctor->fullname . "   "
                        . "قام المريض" . "  " .  $doctor->fullname . " " . " بالغاء الموعد " . $appointment->appointmentDate
                ];

                MailController::deleteAppointemt($msgForDoctor, $doctor->email);
                $doctor->update([
                    'points' => $doctor->points + 10
                ]);
            }
            $appointment->delete();
            return back();
        } else {
            $appointment->delete();
            return back();
        }
    }

    public function showDailyDatesPatient($id)
    {
        $a = Appointment::getPatientAppointments($id);
        $appointments = [];
        foreach ($a as $i) {
            $date = Carbon::create($i->appointmentDate);
            $dayName = $date->dayName;

            if ($dayName === "Sunday") {
                $dayName = "ألاحد";
            } elseif ($dayName === "Monday") {
                $dayName = "الاثنين";
            } elseif ($dayName === "Tuesday") {
                $dayName = "الثلاثاء";
            } elseif ($dayName === "Wednesday") {
                $dayName = "الاربعاء";
            } elseif ($dayName === "Thursday") {
                $dayName = "الخميس";
            } elseif ($dayName === "Friday") {
                $dayName = "الجمعة";
            } elseif ($dayName === "Saturday") {
                $dayName = "السبت";
            }
            $periodStartTime = "";
            $sd = $date->format('h:i:s A');
            $startdate = $date->format('h:i');
            if ((substr($sd, 9, 2)) === "AM") {
                $periodStartTime = 'صباحا';
            } else {
                $periodStartTime = 'مساء';
            }
            $edate = Carbon::create($i->appointmentEndDate);
            $ed = $edate->format('h:i:s A');
            $endDate = $edate->format('h:i');
            $periodEndTime = '';
            if ((substr($ed, 9, 2)) === "AM") {
                $periodEndTime = 'صباحا';
            } else {
                $periodEndTime = 'مساء';
            }


            $doctor = User::find($i->doctor_id);
            $doctorName = $doctor->fullname;
            $doctorLocation = $doctor->location;

            array_push($appointments, [
                'date' => $date->format('Y-m-d'),
                'dayName' => $dayName,
                'startdate' =>  $startdate,
                'periodStartTime' => $periodStartTime,
                'endDate' => $endDate,
                'periodEndTime' => $periodEndTime,
                'doctorName' => $doctorName,
                'doctorLocation' =>  $doctorLocation,
                'doctor_id' => $i->doctor_id,
                'appointment_id' => $i->id
            ]);
        }


        return view('dailyDatesPatient', [
            'appointments' => $appointments
        ]);
    }
}
