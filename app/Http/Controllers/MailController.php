<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public static function accept($mailData, $to)
    {
        try {
            $GLOBALS['x'] = $to;
            Mail::send('email', [
                'data' => $mailData
            ], function ($message,) {
                $message->to($GLOBALS['x']);
                $message->subject("قبول طلب التسجيل ");
            });
        } catch (Exception) {
        }
    }
    public static function reject($mailData, $to)
    {
        try {
            $GLOBALS['x'] = $to;
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to($GLOBALS['x']);
                $message->subject("رفض طلب التسجيل ");
            });
        } catch (Exception) {
        }
    }
    public static function deleteAppointemt($mailData, $to)
    {
        $GLOBALS['x'] = $to;
        try {
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to($GLOBALS['x']);
                $message->subject("الغاء موعد");
            });
        } catch (Exception) {
        }
    }
    public static function transformation($mailData, $to)
    {
        $GLOBALS['x'] = $to;
        try {
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to($GLOBALS['x']);
                $message->subject("عمليات تحويل");
            });
        } catch (Exception) {
        }
    }

    public static function connectWithAdmin($mailData)
    {
        try {
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to('haidarrayya243@gmail.com');
                $message->subject("مشاكل في الموقع");
            });
        } catch (Exception) {
        }
    }
    public static function connectWithDeveloders($mailData)
    {
        try {
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to('haidarrayya243@gmail.com');
                $message->subject("مشاكل في الموقع");
            });
        } catch (Exception) {
        }
    }
}