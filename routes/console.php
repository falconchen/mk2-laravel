<?php

use App\Mail\KindleMail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');





Artisan::command('send-test-mail', function () {

    $path = 'ebooks/2024/01/bd469b03-6a0d-49c3-863c-f385af426160.epub';


    Mail::to('dev@cellmean.com')->send(new KindleMail(
        subject:'title',
        content: 'body',
        attachment:$path
    ));

})->purpose('Send test mail');


Artisan::command('test', function () {

    $path = 'ebooks/2024/01/bd469b03-6a0d-49c3-863c-f385af426160.epub';


    Mail::to('dev@cellmean.com')->send(new KindleMail(
        subject:'title',
        content: 'body',
        attachment:$path
    ));

})->purpose('Send test mail');
