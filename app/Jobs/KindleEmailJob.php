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

class KindleEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ebook;
    private $receiveAddr;

    public function __construct($id, $receiveAddr = null)
    {
        $this->ebook = Ebook::find($id);

        $this->receiveAddr = !is_null($receiveAddr)
            ? $receiveAddr
            : $this->ebook->kindle_email;
    }

    public function handle()
    {

        $email = new KindleMail(
            subject: $this->ebook->title,
            attachment: $this->ebook->file_path
        );

        Mail::to($this->receiveAddr)->send($email);
        $this->ebook->sent_time = now();
        $this->ebook->save();

        dispatch(new OwnerEmailJob(
            id: $this->ebook->id,
        ));
    }
}
