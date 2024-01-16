<?php

namespace App\Livewire\Ebook;

use App\Models\Ebook;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Jobs\KindleEmailJob;
use finfo;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\UnableToRetrieveMetadata;

class UploadEbook extends Component
{
    use WithFileUploads;

    public $ebook;
    public $kindle_email = null;


    public function __construct()
    {
        if (auth()->check()) {
            $latestEbook = auth()->user()->ebooks()->latest('uploaded_time')->first();
            $this->kindle_email = $latestEbook->kindle_email;
        }
    }
    public function render()
    {

        return view('livewire.ebook.upload-ebook');
        // ->with([
        //     'author' => Auth::user()->name,
        // ]);
    }

    public function updatedKindleEmail()
    {
        try {
            $this->validate([
                'kindle_email' => [
                    'required', 'email',
                    function ($attribute, $value, $fail) {
                        if (strpos($value, '@kindle.') === false) {
                            $fail('wrong sending to kindle email address.');
                        }
                    }
                ],
            ]);

            // $this->kindle_email =
        } catch (\Exception $e) {
            // $this->reset('kindle_email');
            // Set error message
            session()->flash('error',  $e->getMessage());
        }
    }
    public function updatedEbook()
    {
        try {
            if (auth()->guest()) {
                throw new \Exception('You must be logged in to upload files.');
            }
            echo $this->ebook->getMimeType();exit;

            $this->validate([
                'ebook' => 'required|file|mimes:epub,zip,pdf,bin,txt,html|max:51200', // max size 50MB
            ]);

        } catch (UnableToRetrieveMetadata | \Exception $e) {
            $this->reset('ebook');
            // Set error message
            $message = $e instanceof UnableToRetrieveMetadata ? 'File name too long, please rename it and upload again.' : $e->getMessage();
            session()->flash('error',  $message);
        }
    }


    public function submit()
    {
        try {
            if (auth()->guest()) {
                throw new \Exception('You must be logged in to upload files.');
            }

            $this->validate([
                'ebook' => 'required|file|mimes:epub,zip,pdf,bin,txt|max:51200', // max size 10MB
                'kindle_email' => [
                    'required', 'email',
                    function ($attribute, $value, $fail) {
                        if (strpos($value, '@kindle.') === false) {
                            $fail('Error send to kindle email address.');
                        }
                    }
                ],
            ]);

            // Logic to handle ebook upload to server goes here...
            // Grab the file
            $file = $this->ebook;


            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // $extensionName = $file->getClientOriginalExtension();
            $extensionName = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);



            // Generate a new unique file name
            $newFileName = Str::uuid() . '.' . $extensionName;

            // Construct a file path
            $filePath = 'ebooks/' . date('Y/m/') . $newFileName;

            // Using Laravel's built in Local Storage functionality to store the file
            $file->storeAs('public', $filePath);


            $this->reset('ebook');
            // Store ebook details in the database
            $ebookRow = Ebook::create([
                'title' => $originalFileName,
                'body' => '',
                'file_path' => $filePath,
                'user_id' => auth()->id(),
                'kindle_email' => $this->kindle_email,
                'uploaded_time' => now(),
                'sent_time' => null,
            ]);
            dispatch(new KindleEmailJob($ebookRow->id));
            // Set success message
            session()->flash('message', 'File uploaded and sending to kindle.');
        } catch (\Exception $e) {
            $this->reset('ebook');
            // Set error message
            session()->flash('error', 'File upload failed: ' . $e->getMessage());
        }
    }
}
