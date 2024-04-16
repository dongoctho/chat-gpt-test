<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    use HasFactory;
    protected $table = 'answers';
    protected $fillable = [
        'id',
        'content',
        'question_id',
    ];

    public function questions()
    {
        return $this->belongsTo(question::class, 'question_id', 'id');
    }
}
