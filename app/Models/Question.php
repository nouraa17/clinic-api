<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $fillable = [
        'user_id',
        'question',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
