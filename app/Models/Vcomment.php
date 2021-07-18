<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vcomment extends Model
{
    use HasFactory, Notifiable, DefaultDatetimeFormat;
    //
    protected $fillable =  ['vlog_id','user_id','content','thumb_count'];

    public function dynamic()
    {
        return $this->belongsTo(Dynamic::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
    public function thumb()
    {
        return $this->hasMany(Thumb::class);
    }
}
