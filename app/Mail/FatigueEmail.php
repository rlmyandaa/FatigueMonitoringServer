<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FatigueEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($result, $attendanceData)
    {
        $this->result = $result;
        $this->attendanceData = $attendanceData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this);
        return $this->view('mail.mail')
            ->with([
                "name" => $this->result->name,
                "attend_date" => $this->attendanceData->attend_date,
                "shift_duration" => $this->result->shiftDuration,
                "uid" => $this->result->attendanceID
            ]);
    }
}
