<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use HasFactory, Notifiable;
    //
    protected $fillable =  ['from_id','to_id','content','push','dynamic_id','video_id','type','status'];

    public function dynamic()
    {
        return $this->belongsTo(Dynamic::class);
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
