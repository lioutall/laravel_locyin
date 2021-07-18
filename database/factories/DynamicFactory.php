<?php

namespace Database\Factories;

use App\Models\Dcomment;
use App\Models\Dynamic;
use App\Models\Image;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class DynamicFactory extends Factory
{
    protected $model = Dynamic::class;

    public function definition()
    {
        return [
            'thumb_count' => $this->faker->numberBetween(1000,2000),
            'collect_count' => $this->faker->numberBetween(100,200),
            'comment_count' => 10,
            'content' => $this->faker->text($maxNbChars = 800),
            'location' => $this->faker->city,
            'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'status' => 1
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Dynamic $dynamic) {
            //
            $images = [
                'https://locyin.oss-cn-beijing.aliyuncs.com/apps/luoxun_flutter/images/dynamic/dynamic_2.jpg',
                'https://locyin.oss-cn-beijing.aliyuncs.com/apps/luoxun_flutter/images/dynamic/dynamic_1.jpg',
                'https://youimg1.c-ctrip.com/target/0101t1200081dhiphAA71_R_1024_10000_Q90.jpg?proc=autoorient',
                'https://youimg1.c-ctrip.com/target/10011h000001i248d485C_R_671_10000_Q90.jpg?proc=autoorient',
                'https://youimg1.c-ctrip.com/target/100t1g000001hds280A36_R_671_10000_Q90.jpg?proc=autoorient',
                'https://youimg1.c-ctrip.com/target/0105p120008drjhd623F8_R_671_10000_Q90.jpg?proc=autoorient',
                'https://dimg06.c-ctrip.com/images/01038120008cre3iq7A40_R_800_10000_Q90.jpg?proc=autoorient',
                'https://youimg1.c-ctrip.com/target/0104s1200084bpk7f4A65_R_671_10000_Q90.jpg?proc=autoorient',
            ];
            for($i=0;$i<10;$i++){
                Dcomment::create([
                    'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                    'dynamic_id' => $dynamic->id,
                    'thumb_count' => $this->faker->numberBetween(40,150),
                    'status' => 1,
                    'content' => $this->faker->text($maxNbChars = 150),
                ]);
            }
            for($i=0;$i<9;$i++){
                Image::create([
                    'user_id' => $dynamic->user_id,
                    'dynamic_id' => $dynamic->id,
                    'type' => "dynamic",
                    'path' => $this->faker->randomElement($images),
                ]);
            }
            for($i=0;$i<4;$i++){
                Message::create([
                    'from_id' => 0,
                    'to_id' =>$dynamic->user_id,
                    'dynamic_id' => $dynamic->id,
                    'type' => "dynamic",
                    'content' => "系统消息：小寻点赞了你的游记。",
                    'status' => 0,
                    'push' => 0,
                ]);
            }
        });
    }
}
