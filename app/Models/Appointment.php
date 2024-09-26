<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['doctor_id', 'patient_id', 'appointmentDate', 'appointmentEndDate'];


    public static function  getPatientAppointments($id)
    {
        $appointments = DB::table('appointments')
            ->where('patient_id', '=', $id)
            ->where('appointmentDate', '>=', Carbon::now())
            ->get();

        return $appointments;
    }
    public static function  getDoctorAppointments($id)
    {
        $appointments = DB::table('appointments')
            ->where('doctor_id', '=', $id)
            ->where('appointmentDate', '>=', Carbon::now())
            ->get();

        return $appointments;
    }
    public static function  getAppointments($id)
    {
        $appointments = DB::table('appointments')
            ->where('patient_id', '=', $id)
            ->get();

        return $appointments;
    }
    public static function  getDailyAppointments($id, $date, $date2)
    {

        $appointments = DB::table('appointments')
            ->where('patient_id', '=', $id)
            ->where('appointmentDate', '>=', $date)
            ->where('appointmentDate', '<', $date2)
            ->get();

        return $appointments;
    }

    public static function  doctorAppointments($id)
    {
        $appointments = DB::table('appointments')
            ->where('doctor_id', '=', $id)
            ->get();

        return $appointments;
    }

    public function doctors()
    {
        return $this->belongsTo(User::class, 'id', 'doctor_id');
    }
    public function patients()
    {
        return $this->belongsTo(User::class, 'id', 'patient_id');
    }
}