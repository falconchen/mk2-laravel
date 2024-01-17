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
    public $ebook; // 定义电子书变量
    public $kindle_email = null; // 初始化 kindle 邮箱



    // 检查用户是否已经登录的函数
    public function checkAuthentication()
    {
        if (auth()->guest()) {

            throw new \Exception(
                'You must be logged in to upload files.'
            );
        }
    }

    // 验证用户的输入
    public function validateInput($inputParams)
    {
        $rules = [ // 验证电子书

            'kindle_email' => [
                'required', 'email',
                function ($attribute, $value, $fail) {
                    if (strpos($value, '@kindle.') === false) {
                        $fail('Error kindle email address.');
                    }
                }
            ],
            'ebook' => 'required|file|mimes:epub,zip,pdf,bin,text,html|max:51200', // max size 50MB
        ];

        $inputParams = is_array($inputParams)
            ? $inputParams
            : [$inputParams];

        $validateRules = [];
        foreach ($inputParams as $field) {
            if (array_key_exists($field, $rules)) {
                $validateRules[$field] = $rules[$field];
            }
        }

        $this->validate($validateRules);
    }

    public function __construct()
    {
        if (auth()->check()) {
            // 如果用户已登录，获取最新的电子书
            $latestEbook = auth()->user()->ebooks()->latest('uploaded_time')->first();

            // 设置当前的 kindle 电子邮件地址
            $this->kindle_email =  $latestEbook->kindle_email ?? null;
        }
    }

    // 渲染上传电子书的视图
    public function render()
    {
        return view('livewire.ebook.upload-ebook');
    }

    public function updatedKindleEmail()
    {
        try {
            $this->checkAuthentication(); // 检查用户是否登录
            $this->validateInput('kindle_email');
        } catch (\Exception $e) {
            session()->flash('error',  $e->getMessage()); // 若存在错误，设置错误信息
        }
    }

    public function updatedEbook()
    {
        try {
            $this->checkAuthentication(); // 检查用户是否登录

            $this->validateInput('ebook');
        } catch (UnableToRetrieveMetadata | \Exception $e) {
            $this->reset('ebook'); // 若存在错误，重置电子书
            $message = $e instanceof UnableToRetrieveMetadata ? 'File name too long, please rename it shorter and upload again.' : $e->getMessage();
            session()->flash('error',  $message); // 设置错误信息
        }
    }

    public function resetEbook(){
        $this->reset('ebook');    
    }

    // 创建电子书并存储至数据库
    public function createEbook($file, $originalFileName, $filePath)
    {
        $ebookRow = Ebook::create([
            'title' => $originalFileName,
            'body' => '',
            'file_path' => $filePath,
            'user_id' => auth()->id(),
            'kindle_email' => $this->kindle_email,
            'uploaded_time' => now(),
            'sent_time' => null,
        ]);
        // 放入邮件消息队列
        dispatch(new KindleEmailJob($ebookRow->id));
    }

    // 提交电子书表单
    public function submit()
    {
        try {
            $this->checkAuthentication();  // 检查用户是否登录
            $this->validateInput(['kindle_email', 'ebook']);

            // 加载电子书
            $file = $this->ebook;
            // 获取原始文件名
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // 获取文件扩展名
            $extensionName = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            // 生成新的文件名
            $newFileName = Str::uuid() . '.' . $extensionName;
            // 构造文件路径
            $filePath =  date('Y/m/') . $newFileName;
            // 将文件存储于 ebooks 目录
            $file->storeAs('ebooks', $filePath, 'local');
            $this->reset('ebook'); // 重置电子书

            $this->createEbook($file, $originalFileName, $filePath); // 创建并存储电子书至数据库

            session()->flash('message', 'File uploaded and sending to kindle.'); // 设置成功信息
        } catch (\Exception $e) {
            $this->reset('ebook'); // 若存在错误，重置电子书
            session()->flash('error', 'File upload failed: ' . $e->getMessage()); // 设置错误信息
        }
    }
}
