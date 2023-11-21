<?php

namespace App\Classes\Automation;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class Test{

    public function __invoke()
    {
        Mail::to('mcinfas9394@gmail.com')->send(new TestMail());
    }
}