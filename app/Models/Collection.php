<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Collection extends Model
{
    use HasFactory, Notifiable;
    //
    protected $fillable =  ['dynamic_id','user_id','video_id','type'];

    public function dynamic()
    {
        return $this->belongsTo(Dynamic::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
