<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $doctorid = 0;
        $patientid = 0;
        $appointmentsDoctorWithName = [];
        $appointmentsPatientWithName = [];

        if (Auth::user()) {
            if (Auth::user()->role === 'doctor') {
                $doctorid = Auth::user()->id;
                $appointmentsDoctor = Appointment::getDoctorAppointments($doctorid);
                $date = Carbon::now()->format('Y-m-d');
                $x = "";
                $periodTime = '';
                foreach ($appointmentsDoctor as $i) {
                    $x = User::find($i->patient_id);
                    if ($x->role === "patient") {
                        $dailyDate = Carbon::create($i->appointmentDate);
                        if ($dailyDate->format('Y-m-d') === $date) {
                            $p = User::find($i->patient_id);
                            $x = $dailyDate->format('h:i:s A');
                            if ((substr($x, 9, 2)) === "AM") {
                                $periodTime = 'صباحا';
                            } else {
                                $periodTime = 'مساء';
                            }
                            array_push($appointmentsDoctorWithName, [$dailyDate->format('h:i'), $p->fullname, $periodTime]);
                        }
                    }
                }
            } elseif (Auth::user()->role === 'patient') {
                $patientid = Auth::user()->id;
                $appointmentsPatient = Appointment::getPatientAppointments($patientid);
                $date = Carbon::now()->format('Y-m-d');
                $x = "";
                $periodTime = '';

                foreach ($appointmentsPatient as $i) {
                    $dailyDate = Carbon::create($i->appointmentDate);
                    if ($dailyDate->format('Y-m-d') === $date) {
                        $d = User::find($i->doctor_id);
                        $x = $dailyDate->format('h:i:s A');
                        if ((substr($x, 9, 2)) === "AM") {
                            $periodTime = 'صباحا';
                        } else {
                            $periodTime = 'مساء';
                        }
                        array_push($appointmentsPatientWithName, [$dailyDate->format('h:i'), $d->fullname, $periodTime]);
                    }
                }
            }
        }

        $doctor = [];

        if (is_null($request->search)) {
            $doctor = User::doctors();
        } else {
            $doctor = User::searchDoctor($request->search);
        }
        return view('index', [
            'doctors' =>  $doctor,
            'appointmentsPatientWithName' => $appointmentsPatientWithName,
            'appointmentsDoctorWithName' => $appointmentsDoctorWithName
        ]);
    }


    public function showlogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $formFileds = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($formFileds)) {
            if (Auth::user()->role === "manager") {
                $request->session()->regenerate();
                return redirect('/MainDoctor');
            } elseif (Auth::user()->role === "admin") {
                $request->session()->regenerate();
                return redirect('/admin');
            } elseif (Auth::user()->role === "seller") {
                $request->session()->regenerate();
                return redirect('/seller');
            } elseif (Auth::user()->role === "doctor" && Auth::user()->state === "accept") {
                $request->session()->regenerate();
                return redirect('/');
            }
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return  view('login', ["message" => 'يرجى التأكد من البيانات المدخلة']);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            if (Auth::user()->role === "seller") {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login');
            } elseif (Auth::user()->role === "admin") {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/');
            } else {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/');
            }
        }
    }


    public function showsignup()
    {
        return view('signup', [
            "message" => ''
        ]);
    }
    public function updateAccountDoctor()
    {
        return view('updates.updateAccountDoctor', ['message' => '']);
    }
    public function updateAccountPatient()
    {
        return view('updates.updateAccountPatient');
    }
    public function updateAccountSeller()
    {
        return view('updates.updateAccountSeller');
    }
    public function contactUs()
    {
        return view('contactUs');
    }
    public function MainDoctor()
    {
        return view('MainDoctor', [
            'doctorRequests' => User::doctorRequests()
        ]);
    }
    public function showDoctorDetail($id)
    {
        return view('showDoctorDetail', [
            'doctor' => User::find($id)
        ]);
    }
    public function updateDoctorDetail(Request $request, $id)
    {
        if ($request->state === "قبول") {
            $doctor = User::find($id);
            $data = [
                'subject' => " قبول طلب التسجيل في الموقع",
                "body" => "مرحبا دكتور" . " " . $doctor->fullname . " " .  " تم قبول طلب التسجيل في الموقع يرجى تعبئة نقاط في حسابك لكي يتم اظهاره للمستخدمين للحجز"
            ];
            MailController::accept($data, $doctor->email);
            $doctor->update([
                'state' => "accept"
            ]);
            return back();
        } else {
            $doctor = User::find($id);
            $data = [
                'subject' => " رفض طلب التسجيل في الموقع",
                "body" =>  "مرحبا دكتور" . " " . $doctor->fullname . " " .  " تم رفض طلب التسجيل في الموقع"
            ];
            MailController::reject($data, $doctor->email);
            User::find($id)->delete();
            return back();
        }
    }

    public function doctorSignup(Request $request)
    {
        $formFileds = $request->validate([
            'fullname' => ['required', Rule::unique('users', 'fullname')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'genre' => 'required',
            'password' => ['required', 'min:8', 'max:21', Password::min(8)->letters()->numbers()],
            'phoneNumber' => ['required', Rule::unique('users', 'phoneNumber')],
            'specializtion' => 'required',
            'location' => 'required',
            'role' => 'required',
            'closingTime' => 'required',
            'openningTime' => 'required',
            'breakbeginningtime' => 'required',
            'breakendingtime' => 'required',
            'treatmentDuration' => 'required',
            'medicalNumer' => ['required', Rule::unique('users', 'medicalNumer')],
            'certificateImage' => 'required',
            'state' => 'required'
        ]);
        $date = Carbon::now();
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;
        $openningTime =  $formFileds['openningTime'];
        $breakbeginningtime =  $formFileds['breakbeginningtime'];
        $breakendingtime =  $formFileds['breakendingtime'];
        $closingTime =  $formFileds['closingTime'];


        $openningDate = Carbon::create($year, $month, $day, intval(substr($openningTime, 0, 2)), intval(substr($openningTime, 3, 2)), 0);
        $breakbeginningDate = Carbon::create($year, $month, $day, intval(substr($breakbeginningtime, 0, 2)), intval(substr($breakbeginningtime, 3, 2)), 0);
        $breakendingDate = Carbon::create($year, $month, $day, intval(substr($breakendingtime, 0, 2)), intval(substr($breakendingtime, 3, 2)), 0);
        $closingDate = Carbon::create($year, $month, $day, intval(substr($closingTime, 0, 2)), intval(substr($closingTime, 3, 2)), 0);


        if (
            !($openningDate->lessThan($breakbeginningDate)
                && $breakbeginningDate->lessThan($breakendingDate) &&
                $breakendingDate->lessThan($closingDate))
        ) {
            return redirect()->back()->with('error', 'يرجى التاكد من مواعيد التي ادخلتها');
        }


        //hash password
        $formFileds['password'] = bcrypt($formFileds['password']);

        $formFileds['certificateImage'] = $request->file('certificateImage')->store('images', 'public');
        User::create($formFileds);

        return redirect('/');
    }

    public function patientSignup(Request $request)
    {
        $formFileds = $request->validate([
            'fullname' => ['required', Rule::unique('users', 'fullname')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'genre' => 'required',
            'password' => ['required', 'min:8', 'max:21', Password::min(8)->letters()->numbers()],
            'role' => 'required',
            'phoneNumber' => ['required', Rule::unique('users', 'phoneNumber')],
            'location' => 'required'
        ]);
        //hash password
        $formFileds['password'] = bcrypt($formFileds['password']);

        $user = User::create($formFileds);

        auth()->login($user);
        return redirect('/');
    }
    public function sellerSignup(Request $request)
    {
        $formFileds = $request->validate([
            'fullname' => ['required', Rule::unique('users', 'fullname')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:21', Password::min(8)->letters()->numbers()],
            'role' => 'required',
            'phoneNumber' => ['required', Rule::unique('users', 'phoneNumber')],
            'location' => 'required'
        ]);
        //hash password
        $formFileds['password'] = bcrypt($formFileds['password']);

        $user = User::create($formFileds);

        auth()->login($user);
        return redirect('/seller');
    }



    public function contactWithDevelopers(Request $request)
    {
        $formFileds = $request->validate([
            'problem' => 'required',
        ]);
        $data = [
            'subject' => "مشكلة في الموقع",
            "body" => $formFileds['problem']
        ];
        MailController::connectWithAdmin($data);
        return back();
    }
    public function contactWithManager(Request $request)
    {
        $formFileds = $request->validate([
            'problem' => 'required',
        ]);
        $data = [
            'subject' => "مشكلة في الموقع",
            "body" => $formFileds['problem']
        ];
        MailController::connectWithDeveloders($data);
        return back();
    }


    public function updateDoctor(Request $request, $id)
    {
        $user = Auth::user();
        $formFileds = $request->validate([
            'fullname' => ['required', Rule::unique('users', 'fullname')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phoneNumber' => ['required', Rule::unique('users', 'phoneNumber')->ignore($user->id)],
            'location' => 'required',
            'closingTime' => 'required',
            'openningTime' => 'required',
            'breakbeginningtime' => 'required',
            'breakendingtime' => 'required',
            'treatmentDuration' => 'required'
        ]);
        $date = Carbon::now();
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;
        $openningTime =  $formFileds['openningTime'];
        $breakbeginningtime =  $formFileds['breakbeginningtime'];
        $breakendingtime =  $formFileds['breakendingtime'];
        $closingTime =  $formFileds['closingTime'];

        $openningDate = Carbon::create($year, $month, $day, intval(substr($openningTime, 0, 2)), intval(substr($openningTime, 3, 2)), 0);
        $breakbeginningDate = Carbon::create($year, $month, $day, intval(substr($breakbeginningtime, 0, 2)), intval(substr($breakbeginningtime, 3, 2)), 0);
        $breakendingDate = Carbon::create($year, $month, $day, intval(substr($breakendingtime, 0, 2)), intval(substr($breakendingtime, 3, 2)), 0);
        $closingDate = Carbon::create($year, $month, $day, intval(substr($closingTime, 0, 2)), intval(substr($closingTime, 3, 2)), 0);
        $appointments = Appointment::getDoctorAppointments($user->id);
        if ($appointments->isEmpty()) {
            if (
                $user->openningTime != $openningTime
                || $user->breakbeginningtime != $breakbeginningtime
                || $user->breakendingtime != $breakendingtime
                || $user->closingTime != $closingTime
            ) {
                return redirect()->back()->with('message', "لا يمكن تعديل مواعيد الفتح والاغلاق يرجى حذف مواعيك اولا");
            }
        }
        if (
            !($openningDate->lessThan($breakbeginningDate)
                && $breakbeginningDate->lessThan($breakendingDate) &&
                $breakendingDate->lessThan($closingDate))
        ) {
            return redirect()->back()->with('message', 'يرجى التاكد من مواعيد التي ادخلتها');
        }
        if ($request->hasFile('ProfilePhoto'))
            $formFileds['ProfilePhoto'] = $request->file('ProfilePhoto')->store('profilePhotos', 'public');

        //hash password
        if ($request->password) {
            $x = $request->validate([
                'password' => ['required', 'max:21', Password::min(8)->letters()->numbers()]
            ]);
            $formFileds['password'] = bcrypt($x['password']);
        }

        User::find($id)->update($formFileds);
        return back();
    }

    public function updatePatient(Request $request, $id)
    {
        $user = Auth::user();

        $formFileds = $request->validate([
            'fullname' => ['required', Rule::unique('users', 'fullname')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'genre' => 'required',
            'phoneNumber' => ['required', Rule::unique('users', 'phoneNumber')->ignore($user->id)],

        ]);
        if ($request->hasFile('ProfilePhoto')) {
            $formFileds['ProfilePhoto'] = $request->file('ProfilePhoto')->store('profilePhotos', 'public');
        }
        //hash password
        if ($request->password) {
            $x = $request->validate([
                'password' => ['required', 'max:21', Password::min(8)->letters()->numbers()]
            ]);
            $formFileds['password'] = bcrypt($x['password']);
        }
        User::find($id)->update($formFileds);

        return back();
    }
    public function updateSeller(Request $request, $id)
    {
        $user = Auth::user();

        $formFileds = $request->validate([
            'fullname' => ['required', Rule::unique('users', 'fullname')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phoneNumber' => ['required', Rule::unique('users', 'phoneNumber')->ignore($user->id)],
            'location' => 'required'
        ]);
        if ($request->hasFile('ProfilePhoto')) {
            $formFileds['ProfilePhoto'] = $request->file('ProfilePhoto')->store('profilePhotos', 'public');
        }
        //hash password
        if ($request->password) {
            $x = $request->validate([
                'password' => ['required', 'max:21', Password::min(8)->letters()->numbers()]
            ]);
            $formFileds['password'] = bcrypt($x['password']);
        }
        User::find($id)->update($formFileds);
        return back();
    }

    public function calender($id)
    {
        return view('calender', [
            'doctor' => User::find($id),
            "data" => $this->getcalender()
        ]);
    }

    public function getcalender()
    {
        $date = Carbon::now();
        $day = $date->day;
        $year = $date->yearIso;
        $month = $date->month;

        if ($month === 1) {
            $nameofmonth = "كانون الاول";
        } elseif ($month === 2) {
            $nameofmonth = "شباط";
        } elseif ($month === 3) {
            $nameofmonth = "أذار";
        } elseif ($month === 4) {
            $nameofmonth = "نيسان";
        } elseif ($month === 5) {
            $nameofmonth = "أيار";
        } elseif ($month === 6) {
            $nameofmonth = "حزيران";
        } elseif ($month === 7) {
            $nameofmonth = "تموز";
        } elseif ($month === 8) {
            $nameofmonth = "أب";
        } elseif ($month === 9) {
            $nameofmonth = "ايلول";
        } elseif ($month === 10) {
            $nameofmonth = "تشرين الاول";
        } elseif ($month === 11) {
            $nameofmonth = "تشرين الثاني";
        } elseif ($month === 12) {
            $nameofmonth = "كانون الثاني";
        }

        $d = Carbon::create($year, $month, 1);

        $nameofday = $d->dayName;
        $endofmonth = $d->daysInMonth;
        $x = [$nameofday, $endofmonth, $nameofmonth, [$year, $month, $day]];
        return $x;
    }


    public function nextCalender($id, $year, $month)
    {

        return view('calender', [
            'doctor' => User::find($id),
            "data" => $this->getnextcalender($year, $month)
        ]);
    }
    public function previousCalender($id, $year, $month)
    {
        return view('calender', [
            'doctor' => User::find($id),
            "data" => $this->getpreviouscalender($year, $month)
        ]);
    }

    public function getnextcalender($year, $month)
    {

        $d = Carbon::create($year, $month, 1);
        $nameofmonth = $d->format('F');

        if ($nameofmonth === 'January') {
            $nameofmonth = "كانون الاول";
        } elseif ($nameofmonth === 'February') {
            $nameofmonth = "شباط";
        } elseif ($nameofmonth === 'March') {
            $nameofmonth = "أذار";
        } elseif ($nameofmonth === 'April') {
            $nameofmonth = "نيسان";
        } elseif ($nameofmonth === 'May') {
            $nameofmonth = "أيار";
        } elseif ($nameofmonth === 'June') {
            $nameofmonth = "حزيران";
        } elseif ($nameofmonth === 'July') {
            $nameofmonth = "تموز";
        } elseif ($nameofmonth === 'August') {
            $nameofmonth = "أب";
        } elseif ($nameofmonth === 'September') {
            $nameofmonth = "ايلول";
        } elseif ($nameofmonth === 'October') {
            $nameofmonth = "تشرين الاول";
        } elseif ($nameofmonth === 'November') {
            $nameofmonth = "تشرين الثاني";
        } elseif ($nameofmonth === 'December') {
            $nameofmonth = "كانون الثاني";
        }
        $day = 1;
        $nameofday = $d->dayName;
        $endofmonth = $d->daysInMonth;

        $x = [$nameofday, $endofmonth, $nameofmonth, [$year, $month, $day]];

        return $x;
    }

    public function getpreviouscalender($year, $month)
    {

        $d = Carbon::create($year, $month, 1);

        $nameofmonth = $d->format('F');

        if ($nameofmonth === 'January') {
            $nameofmonth = "كانون الاول";
        } elseif ($nameofmonth === 'February') {
            $nameofmonth = "شباط";
        } elseif ($nameofmonth === 'March') {
            $nameofmonth = "أذار";
        } elseif ($nameofmonth === 'April') {
            $nameofmonth = "نيسان";
        } elseif ($nameofmonth === 'May') {
            $nameofmonth = "أيار";
        } elseif ($nameofmonth === 'June') {
            $nameofmonth = "حزيران";
        } elseif ($nameofmonth === 'July') {
            $nameofmonth = "تموز";
        } elseif ($nameofmonth === 'August') {
            $nameofmonth = "أب";
        } elseif ($nameofmonth === 'September') {
            $nameofmonth = "ايلول";
        } elseif ($nameofmonth === 'October') {
            $nameofmonth = "تشرين الاول";
        } elseif ($nameofmonth === 'November') {
            $nameofmonth = "تشرين الثاني";
        } elseif ($nameofmonth === 'December') {
            $nameofmonth = "كانون الثاني";
        }

        $day = 1;
        $nameofday = $d->dayName;
        $endofmonth = $d->daysInMonth;
        $x = [$nameofday, $endofmonth, $nameofmonth, [$year, $month, $day]];
        return $x;
    }

    public static function getDailyDates($doctor, $year, $month, $day)
    {
        $hour1 = intval(substr($doctor->openningTime, 0, 2));
        $minute1 = intval(substr($doctor->openningTime, 3, 2));
        $second1 = intval(substr($doctor->openningTime, 6, 2));

        $hour2 = intval(substr($doctor->breakbeginningtime, 0, 2));
        $minute2 = intval(substr($doctor->breakbeginningtime, 3, 2));
        $second2 = intval(substr($doctor->breakbeginningtime, 6, 2));

        $hour3 = intval(substr($doctor->breakendingtime, 0, 2));
        $minute3 = intval(substr($doctor->breakendingtime, 3, 2));
        $second3 = intval(substr($doctor->breakendingtime, 6, 2));

        $hour4 = intval(substr($doctor->closingTime, 0, 2));
        $minute4 = intval(substr($doctor->closingTime, 3, 2));
        $second4 = intval(substr($doctor->closingTime, 6, 2));

        $openDate = Carbon::create($year, $month, $day, $hour1, $minute1, $second1);
        $beginBreakDate = Carbon::create($year, $month, $day, $hour2, $minute2, $second2);
        $endBreakDate = Carbon::create($year, $month, $day, $hour3, $minute3, $second3);
        $closeDate = Carbon::create($year, $month, $day, $hour4, $minute4, $second4);

        $dates = [];

        while ($openDate->notEqualTo($beginBreakDate)) {
            if ($openDate->greaterThan($beginBreakDate)) {
                break;
            }

            if ((substr($openDate->format('h:i:s A'), 9, 2)) === "AM") {
                array_push($dates, [$openDate->format('h:i:s'), "صباحا", $openDate->format('h:i:s A'), Carbon::create($openDate)->format('Y-m-d H:i:s')]);
            } else {
                array_push($dates, [$openDate->format('h:i:s'), "مساء", $openDate->format('h:i:s A'), Carbon::create($openDate)->format('Y-m-d H:i:s')]);
            }

            $openDate->addMinute($doctor->treatmentDuration);
        }

        while ($endBreakDate->notEqualTo($closeDate)) {
            if ($endBreakDate->greaterThan($closeDate)) {
                break;
            }
            if ((substr($endBreakDate->format('h:i:s A'), 9, 2)) === "AM") {
                array_push($dates, [$endBreakDate->format('h:i:s'), "صباحا", $endBreakDate->format('h:i:s A'), Carbon::create($endBreakDate)->format('Y-m-d H:i:s')]);
            } else {
                array_push($dates, [$endBreakDate->format('h:i:s'), "مساء", $endBreakDate->format('h:i:s A'), Carbon::create($endBreakDate)->format('Y-m-d H:i:s')]);
            }
            $endBreakDate->addMinute($doctor->treatmentDuration);
        }
        return $dates;
    }
    public function dailyDatesForPatient($id, $year, $month, $day)
    {
        $doctor = User::find($id);
        $date = Carbon::now();
        $y = Carbon::now();
        $x = Carbon::create($year, $month, $day);
        if ($x > $y->addMonths(3)) {
            return view('dailyDatesPatientToDoctor', [
                'doctor' => $doctor,
                "dates"  => [],
                'appointments' => [],
                'appointmentsWithName' =>  [],
                'date' => [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ],
                'message' => " لا يمكنك الحجز قمت باخيتار موعد في شهر بعيد "
            ]);
        }
        if ($date->day > $day) {
            return view('dailyDatesPatientToDoctor', [
                'doctor' => $doctor,
                "dates"  => [],
                'appointments' => [],
                'appointmentsWithName' =>  [],
                'date' => [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ],
                'message' => " لا يمكنك الحجز قمت باخيتار يوم خاطئ"
            ]);
        }
        if ($x->dayName === "Friday") {
            return view('dailyDatesPatientToDoctor', [
                'doctor' => $doctor,
                "dates"  => [],
                'appointments' => [],
                'appointmentsWithName' =>  [],
                'date' => [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ],
                'message' => "قمت باختيار يوم الجمعة وهو يوم عطلة يرجى اختيار يوم جديد "
            ]);
        }

        $dates = $this->getDailyDates($doctor, $year, $month, $day);

        $appointments = Appointment::doctorAppointments($id);

        $appointmentsWithName = [];

        foreach ($appointments as $i) {
            $x = User::find($i->patient_id);
            if ($x->role === "patient") {
                array_push($appointmentsWithName, [$i, $x->fullname]);
            } else {
                array_push($appointmentsWithName, [$i, "موعد تم الغاءه"]);
            }
        }
        return view('dailyDatesPatientToDoctor', [
            'doctor' => $doctor,
            "dates"  => $dates,
            'appointments' => $appointments,
            'appointmentsWithName' =>  $appointmentsWithName,
            'date' => [
                'day' => $day,
                'month' => $month,
                'year' => $year
            ]
        ]);
    }
    public function dailyDatesFordoctor($id, $year, $month, $day)
    {

        $doctor = User::find($id);
        $date = Carbon::now();
        $y = Carbon::now();
        $x = Carbon::create($year, $month, $day);
        if ($x > $y->addMonths(3)) {
            return view('dailyDatesDoctor', [
                'doctor' => $doctor,
                "dates"  => [],
                'appointments' => [],
                'appointmentsWithName' =>  [],
                'date' => [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ],
                'message' => " لا يمكنك الحجز قمت باخيتار موعد في شهر بعيد "
            ]);
        }
        /*
        if ($date->day > $day) {
            return view('dailyDatesDoctor', [
                'doctor' => $doctor,
                "dates"  => [],
                'appointments' => [],
                'appointmentsWithName' =>  [],
                'date' => [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ], 'message' => " لا يمكنك الحجز قمت باخيتار يوم خاطئ"
            ]);
        }
*/
        if ($x->dayName === "Friday") {
            return view('dailyDatesDoctor', [
                'doctor' => $doctor,
                "dates"  => [],
                'appointments' => [],
                'appointmentsWithName' =>  [],
                'date' => [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ],
                'message' => "قمت باختيار يوم الجمعة وهو يوم عطلة يرجى اختيار يوم جديد "
            ]);
        }

        $dates = $this->getDailyDates($doctor, $year, $month, $day);

        $appointments = Appointment::doctorAppointments($id);

        $appointmentsWithName = [];

        foreach ($appointments as $i) {
            $x = User::find($i->patient_id);
            if ($x->role === "patient") {
                array_push($appointmentsWithName, [$i, $x->fullname]);
            } else {
                array_push($appointmentsWithName, [$i, "موعد تم الغاءه"]);
            }
        }
        return view('dailyDatesDoctor', [
            'doctor' => User::find($id),
            "dates"  => $dates,
            'appointments' => $appointments,
            'appointmentsWithName' =>  $appointmentsWithName,
            'date' => [
                'day' => $day,
                'month' => $month,
                'year' => $year
            ]
        ]);
    }

    public function showSeller()
    {
        return view('seller');
    }

    public function showAdminPage()
    {
        return view('admin');
    }


    public function showTransactionPage()
    {
        $data = Transfer::latest()->paginate(100);
        $transfers = [];
        foreach ($data as $d) {
            $retailer = User::find($d->retailer_id);
            $reciever = User::find($d->reciever_id);

            array_push($transfers, [
                'retailerName' => $retailer->fullname,
                'recieverName' => $reciever->fullname,
                'date' => Carbon::create($d->date)->format('Y-m-d H:i:s A'),
                'value' => $d->value
            ]);
        }
        return view('transactionPage', [
            'data' => $data,
            'transfers' => $transfers
        ]);
    }

    public function sellerTransformation(Request $request)
    {
        $formFileds = $request->validate([
            'email' => ['required', 'email'],
            'value' => ['required', 'integer']
        ]);
        $seller_id = Auth::user()->id;
        $seller = User::find($seller_id);
        $d = User::findDoctor($request->email);
        if ($formFileds['value'] <= 0) {
            return  redirect('/seller')->with('message', 'عملية تحويل خاطئة  يرجى تأكد من القيمة المدخلة');
        }
        if ($seller->points >= $formFileds['value']) {
            if ($d->isEmpty()) {
                return  redirect('/seller')->with('message', 'الحساب الذي قمت بادخاله خاطئ يرجى التاكد من الحساب واعادة المحاولة');
            } else {
                $doctor_id = $d[0]->id;
                $doctor = User::find($doctor_id);
                $doctor->update([
                    "points" =>  $doctor->points + $formFileds['value']
                ]);
                $seller->update([
                    "points" =>  $seller->points - $formFileds['value']
                ]);
                Transfer::create([
                    'retailer_id' => $seller_id,
                    'reciever_id' => $doctor_id,
                    'date' => Carbon::now(),
                    'value' => $formFileds['value']
                ]);
                $data = [
                    'subject' => "عملية تحويل",
                    "body" => " مرحبا دكتور" . " " . $doctor->fullname . " " .  "تم تحويل " . " " . $formFileds['value'] . " " . "الى حسابك في الموقع"
                ];
                MailController::transformation($data, $doctor->email);
                return  redirect('/seller')->with('message', 'تمت عملية التحويل بنجاح');
            }
        } else {
            return  redirect('/seller')->with('message', 'لا يتوفر رصيد كافي يرجى اعادة تعبئة الحساب لاتمام العملية');
        }
    }
    public function adminTransformation(Request $request)
    {
        $formFileds = $request->validate([
            'email' => ['required', 'email'],
            'value' => ['required', 'integer', '']
        ]);
        if ($formFileds['value'] <= 0) {
            return  redirect('/admin')->with('message', 'عملية تحويل خاطئة  يرجى تأكد من القيمة المدخلة');
        }
        $s = User::findSeller($formFileds['email']);
        if ($s->isEmpty()) {
            return  redirect('/admin')->with('message', 'الحساب الذي قمت بادخاله خاطئ يرجى التاكد من الحساب واعادة المحاولة');
        } else {
            $seller_id = $s[0]->id;
            $seller = User::find($seller_id);
            $a = User::admin();
            $admin_id = $a[0]->id;
            $seller->update([
                "points" =>  $seller->points + $formFileds['value']
            ]);
            Transfer::create([
                'retailer_id' => $admin_id,
                'reciever_id' => $seller_id,
                'date' => Carbon::now(),
                'value' => $formFileds['value']
            ]);

            $data = [
                'subject' => "عملية تحويل",
                "body" => "مرحبا " . " " . $seller->fullname . " " .  "تم تحويل " . " " . $formFileds['value'] . " " . "الى حسابك في الموقع"
            ];
            MailController::transformation($data, $seller->email);
            return  redirect('/admin')->with('message', 'تمت عملية التحويل بنجاح');
        }
    }
}