<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentData extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $phone, $course)
    {
        $this->name=$name;
        $this->phone=$phone;
        $this->course=$course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $course=$this->course;
        $name=$this->name;
        $phone=$this->phone;
        return $this->view('mail', compact(['name', 'phone', 'course']));
    }
}
