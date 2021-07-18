<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $avatars = [
            'https://locyin.oss-cn-beijing.aliyuncs.com/apps/luoxun_flutter/images/avatar.jpg',
            'https://locyin.oss-cn-beijing.aliyuncs.com/apps/luoxun_flutter/images/avatar_2.jpg',
            'https://dimg04.c-ctrip.com/images/fd/headphoto/g3/M00/9D/A0/CggYGlZdjoiATgL5AADB2bqtKwI360_C_180_180.jpg',
            'https://locyin.oss-cn-beijing.aliyuncs.com/apps/luoxun_flutter/images/avatar_3.jpg',
            'https://dimg04.c-ctrip.com/images/0Z86a120008izukdy0252_C_180_180.jpg',
            'https://dimg04.c-ctrip.com/images/Z8090500000012pcu1655_C_180_180.jpg',
        ];
        return [
            'username' => $this->faker->unique()->firstName,
            'nickname' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
            'introduction' => $this->faker->sentence(),
            'avatar' => $this->faker->randomElement($avatars),
        ];
    }
}
