<?php

namespace Database\Factories;

use App\Models\Vcomment;
use App\Models\Vlog;
use App\Models\Video;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class VlogFactory extends Factory
{
    protected $model = Vlog::class;

    public function definition()
    {
        return [
            'thumb_count' => $this->faker->numberBetween(1000,2000),
            'collect_count' => $this->faker->numberBetween(100,200),
            'comment_count' => 10,
            'illustration' => $this->faker->text($maxNbChars = 800),
            'location' => $this->faker->city,
            'title' => $this->faker->text($maxNbChars = 34),
            'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'status' => 1
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Vlog $video) {
            //
            $videos = [
                'https://media.qyer.com/video/source/20190505/1557049265355',
                'https://media.qyer.com/video/source/20200805/1596597854129',
                'https://media.qyer.com/video/source/20181114/1542176889357',
                'http://baishan.oversketch.com/2019/11/05/d07f2f1440e51b9680f4bcfe63b0ab67.MP4',
                'https://media.qyer.com/video/source/20190424/1556071552375',
                'https://media.qyer.com/video/source/20191121/1574328815913',
            ];
            for($i=0;$i<10;$i++){
                Vcomment::create([
                    'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                    'vlog_id' => $video->id,
                    'thumb_count' => $this->faker->numberBetween(40,150),
                    'status' => 1,
                    'content' => $this->faker->text($maxNbChars = 150),
                ]);
            }
            Video::create([
                'user_id' => $video->user_id,
                'vlog_id' => $video->id,
                'type' => "vlog",
                'path' => $this->faker->randomElement($videos),
            ]);
            Message::create([
                'from_id' => 0,
                'to_id' =>$video->user_id,
                'vlog_id' => $video->id,
                'type' => "vlog",
                'content' => "系统消息：小寻点赞了你的短视频。",
                'status' => 0,
                'push' => 0,
            ]);
        });
    }
}
