<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';
    protected $fillable = [
        'user_id',
        'chronic_diseases',
        'prescriptions',
        'last_visit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
