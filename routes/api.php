<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Str;
use App\Models\Ebook;
use App\Jobs\KindleEmailJob;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/mailgun', function(Request  $request){        
//     $data = var_export($request->all(), true);
//     $filename = "mailgun-" . now()->format('Ymd-His') . ".log";
//     Storage::put($filename, $data);
// });



Route::post('/zlib-gmail-mailgun-notify', function(Request  $request){       

    $data = $request->all();
    
    
    $data_export = var_export($data, true);
    $filename = "zlib-gmail-mailgun-notify-" . now()->format('Ymd-His') . ".log";
    Storage::put($filename, $data_export);

    if(!isset($data['attachments']) || empty($data['attachments'])){        
        return response()->json(['message' => 'no attachments'], 404);
    }        

    $ebookDataStr = $data['attachments'];
    $ebookData = json_decode($ebookDataStr,true)[0];                 

    $client = new Client();    
    $credentials = base64_encode(
        sprintf("%s:%s", 
            config('services.mailgun.username'),
            config('services.mailgun.secret')
        )
    );

    
    $request = new GuzzleRequest(
        'GET',
        $ebookData['url'],
        [
            'Authorization' => 'Basic ' . $credentials,
        ]
    );

    $response = $client->send($request);

    $code = $response->getStatusCode(); // 输出状态码

    if($code == 200){
            $fileData = $response->getBody(); // 输出响应体

            $originalFileName = pathinfo($ebookData['name'], PATHINFO_FILENAME);
            // 获取文件扩展名
            $extensionName = pathinfo($ebookData['name'], PATHINFO_EXTENSION);
            // 生成新的文件名
            $newFileName = Str::uuid() . '.' . $extensionName;
            // 构造文件路径
            $filePath =  date('Y/m/') . $newFileName;            
            Storage::disk('local')->put('ebooks/'.$filePath, $response->getBody());  // 保存文件到本地存储
                        
            $ebookRow = Ebook::create([
                'title' => $originalFileName,
                'body' => '',
                'file_path' => $filePath,
                'user_id' => config('services.mailgun.m2k_user_id'),
                'kindle_email' => config('services.mailgun.m2k_kindle_email'),
                'uploaded_time' => now(),
                'sent_time' => null,
            ]);
            // 放入邮件消息队列
            dispatch(new KindleEmailJob($ebookRow->id));

            return response()->json(['message' => 'sending book '. $originalFileName]);

    }else{
        return response()->json(['message' => 'fetch attachment error, code:'. $code], 500);
    }
    

});









// routes/api.php
Route::fallback(function () {
    return response()->json(['message' => 'Route Not Found'], 404);
})->name('api.fallback.404');