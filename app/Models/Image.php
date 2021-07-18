<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Image extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['type', 'path' , 'user_id', 'dynamic_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dynamic()
    {
        return $this->belongsTo(Dynamic::class);
    }

}
