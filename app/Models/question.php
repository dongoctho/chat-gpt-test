<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = [
        'id',
        'content',
        'thread_id',
    ];

    public function threads()
    {
        return $this->belongsTo(thread::class, 'thread_id', 'id');
    }

    public function answers()
    {
        return $this->hasOne(answer::class);
    }
}
