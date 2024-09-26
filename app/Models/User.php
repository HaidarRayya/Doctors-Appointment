<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'genre',
        'phoneNumber',
        'specializtion',
        'location',
        'role',
        'treatmentDuration',
        'closingTime',
        'openningTime',
        'medicalNumer',
        'certificateImage',
        'age',
        'points',
        'breakbeginningtime',
        'breakendingtime',
        'ProfilePhoto',
        'state'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected array $filters = [
        User::class,
    ];

    public static function searchDoctor($x)
    {

        $xx =  DB::table('users')
            ->where('role', '=', 'doctor')
            ->where('state', '=', 'accept')
            ->where('fullname', 'like', '%' . $x . '%')
            ->orWhere('specializtion', 'like', '%' . $x . '%')
            ->orWhere('location', 'like', '%' . $x . '%')->paginate(4);
        return $xx;
    }


    public static function doctors()
    {
        $doctors = DB::table('users')
            ->where('role', '=', 'doctor')
            ->where('state', '=', 'accept')
            ->paginate(4);
        return  $doctors;
    }

    public static function doctorRequests()
    {
        $doctorRequests = DB::table('users')
            ->where('role', '=', 'doctor')
            ->where('state', '=', 'processing')
            ->get();
        return  $doctorRequests;
    }

    public static function findDoctor($email)
    {
        $id = DB::table('users')
            ->select('id')
            ->where('role', '=', 'doctor')
            ->where('state', '=', 'accept')
            ->where('email', '=', $email)->get();
        return  $id;
    }
    public static function findPatient($email)
    {
        $id = DB::table('users')
            ->select('id')
            ->where('role', '=', 'patient')
            ->where('email', '=', $email)->get();
        return  $id;
    }

    public static function findSeller($email)
    {
        $id = DB::table('users')
            ->select('id')
            ->where('role', '=', 'seller')
            ->where('email', '=', $email)->get();
        return  $id;
    }
    public static function admin()
    {
        $id = DB::table('users')
            ->select('id')
            ->where('role', '=', 'admin')
            ->get();
        return  $id;
    }

    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'id', 'appointment_id');
    }

    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'id', 'appointment_id');
    }

    public function adminTransfers()
    {
        return $this->hasMany(Transfer::class, 'id', 'transfer_id');
    }

    public function sellersTransfers()
    {
        return $this->hasMany(Transfer::class, 'id', 'transfer_id');
    }
}