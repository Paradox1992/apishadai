<?php

namespace App\Models;

use App\Notifications\AlertMail;
use App\Notifications\EsLuchTimeNotify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class WorkSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pc_work',
        'wkstart_time',
        'end_time',
        'lunch_start_time',
        'lunch_end_time',
    ];
    /*
 |----------------------------------------------------------------------------|
 |                                  FOREIGN KEYS                              |
 |----------------------------------------------------------------------------|
 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pcWork()
    {
        return $this->belongsTo(Pcs::class);
    }

    /*
|----------------------------------------------------------------------------|
 |                                 END FOREIGN KEYS                           |
 |----------------------------------------------------------------------------|
 */

    public function notifyES()
    {
        $currentInfo =   Pcs::where('id', $this->pc_work)->first();
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
        ];;
        Notification::route('mail', $mails->mail_cc1)->notify(new AlertMail($details));
    }




    public function getWorkDurationAttribute()
    {
        if ($this->end_time) {
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);

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