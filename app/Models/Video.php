<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Video extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['type', 'path' , 'user_id', 'vlog_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vlog()
    {
        return $this->belongsTo(Vlog::class);
    }

}
