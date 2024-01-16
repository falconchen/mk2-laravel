<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory;

class EbooksTableSeeder extends Seeder
{
    static function extension($faker){
        $ebookExtensions = ['epub', 'pdf', 'mobi'];  // 电子书的扩展名
        return $faker->randomElement($ebookExtensions);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('zh_CN');

        $faker->addProvider(
            new class($faker) extends \Faker\Provider\Base {
                // 这是一个例子，你可以根据需要自定义词汇库
                protected static $bookName = [
                    '夜深忽梦', '无人机之战', '时间的秘密', '蝴蝶梦', '烈火英雄', '光明之角', '未来世界'
                ];

                public function bookTitle() {
                    return static::randomElement(static::$bookName);
                }
            }
        );

        for ($i=0; $i < 10; $i++) {
            $bookTitle = $faker->bookTitle();
            $randomFilePath = $faker->slug . '/' . $faker->slug . '.' . self::extension($faker);

            // 在这里插入数据
            DB::table('ebooks')->insert([
                'title' => $bookTitle,
                'body' => $faker->text(200),
                'user_id' => 1,
                'file_path' => $randomFilePath,
                'uploaded_time' => now(),
                'sent_time' => rand(0, 1) ? now() : null  // 放送时间有一半的机会为空
            ]);
        }
    }
}
