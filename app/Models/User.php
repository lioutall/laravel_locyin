<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    use HasFactory, Notifiable, DefaultDatetimeFormat;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'username',
        'nickname',
        'password',
        'avatar',
        'phone',
        'email',
        'email_verified_at',
        'introduction',
        'provider',
        'provider_id',
        'notification_count',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'provider',
        'provider_id',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function dynamic()
    {
        return $this->hasMany(Dynamic::class, 'user_id', 'id');
    }
    public function image()
    {
        return $this->hasMany(Image::class);
    }
    public function vlog()
    {
        return $this->hasMany(Vlog::class, 'user_id', 'id');
    }
    public function video()
    {
        return $this->hasMany(Video::class);
    }
    public function thumb()
    {
        return $this->hasMany(Thumb::class);
    }
    public function collection()
    {
        return $this->hasMany(Collection::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}
