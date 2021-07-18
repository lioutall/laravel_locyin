<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Dynamic extends Model
{
    use HasFactory, Notifiable , DefaultDatetimeFormat;

    protected $fillable = ['user_id', 'thumb_count','collect_count','comment_count','content','status','location'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->hasMany(Image::class,);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class,'dynamic_id','id');
    }
    public function thumb()
    {
        return $this->hasMany(Thumb::class);
    }
    public function collection()
    {
        return $this->hasMany(Collection::class);
    }
}
