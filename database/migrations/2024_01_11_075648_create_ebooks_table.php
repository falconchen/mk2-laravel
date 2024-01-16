<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('kindle_email'); // 发送到 Kindle 电子邮件
            $table->string('file_path');  // 文件路径
            $table->timestamp('uploaded_time')->useCurrent();
            $table->timestamp('sent_time')->nullable();  // 发送时间
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
