<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class KindleMail extends Mailable
{
    use Queueable, SerializesModels;

    // public $subject;
    // public $viewData;
    // public $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct(public $subject, private $content='', private $attachment=null)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'mails.kindle',
            with: ['title'=>$this->subject, 'content' => $this->content],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // return [];
        if(is_null($this->attachment)){
            return[];
        }

        $pathParts = pathinfo($this->attachment);
        $fileName = $this->subject . '.' .$pathParts['extension'];

        // $fullPath = storage_path('app/public/' . $this->attachment);
        // Attachment::fromPath($fullPath)->as($fileName),
        $storePath = sprintf('ebooks/%s',$this->attachment );
        return [

            Attachment::fromStorageDisk('local',$storePath)
            ->as($fileName)
         ];

    }
}
