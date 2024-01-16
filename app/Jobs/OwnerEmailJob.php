<?php

namespace App\Jobs;

use App\Mail\KindleMail;
use App\Models\Ebook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

// 启动队列 php artisan queue:work

class OwnerEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ebook;

    public function __construct($id)
    {
        $this->ebook = Ebook::find($id);

    }

    public function handle()
    {

        $email = new KindleMail(
            subject: $this->ebook->title,
            attachment: $this->ebook->file_path
        );
        Mail::to($this->ebook->user)->send($email);

    }
}
