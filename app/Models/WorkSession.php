<?php

namespace App\Models;

use App\Notifications\AlertMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class WorkSession extends Model
{
    use HasFactory;

    protected $table = "worklunch";
    protected $fillable = [
        'usuario',
        'device',
        'wkstart_time',
        'wkend_time',
        'lunch_start_time',
        'lunc_end_time',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
    public function Device(){
        return $this->belongsTo(Devices::class, 'device');
    }

    public function notifyES()
    {
        $currentInfo =   Devices::where('id', $this->device)->first();
        $mails = MailsConfig::all()->first();
        $details = [
            'from' =>  $mails->mail_alert,
            'cc' => $mails->mail_cc2,
            'subject' => 'Registro E/S',
            'data' => [
                'id' => $this->id,
                'user' => $this->user->name,
                'start_time' => $this->wkstart_time,
                'end_time' => $this->wkend_time,
                'lunch_start_time' => $this->lunch_start_time,
                'lunch_end_time' => $this->lunch_end_time,
                'stock' => $currentInfo->Stock->descripcion,
                'lunchDuration' => $this->getLunchDurationAttribute(),
                'workDuration' => $this->getWorkDurationAttribute(),
            ]
            ];
        Notification::route(
            'mail', $mails->mail_cc1)->notify(new AlertMail($details)
        );
    }



    public function getWorkDurationAttribute()
    {
        if ($this->end_time) {
            $start = Carbon::parse($this->wkstart_time);
            $end = Carbon::parse($this->wkend_time);

            $workDuration = $end->diffInSeconds($start);


            if ($this->lunch_start_time && $this->lunch_end_time) {
                $lunchStart = Carbon::parse($this->lunch_start_time);
                $lunchEnd = Carbon::parse($this->lunch_end_time);
                $lunchDuration = $lunchEnd->diffInSeconds($lunchStart); // Duración del almuerzo en segundos
                $workDuration -= $lunchDuration;
            }

            $hours = floor($workDuration / 3600);
            $minutes = floor(($workDuration % 3600) / 60);
            $seconds = $workDuration % 60;

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return null;
    }
    public function getLunchDurationAttribute()
    {
        if ($this->lunch_start_time && $this->lunch_end_time) {
            $lunchStart = Carbon::parse($this->lunch_start_time);
            $lunchEnd = Carbon::parse($this->lunch_end_time);

            $lunchDuration = $lunchEnd->diffInSeconds($lunchStart);

            $hours = floor($lunchDuration / 3600);
            $minutes = floor(($lunchDuration % 3600) / 60);
            $seconds = $lunchDuration % 60;

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return null;
    }

}
