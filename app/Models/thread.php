<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thread extends Model
{
    use HasFactory;
    protected $table = 'threads';
    protected $fillable = [
        'id',
        'title',
        'thread_id',
        'assistant_id',
        'user_id',
        'modal_id',
    ];

    public function questions()
    {
        return $this->hasMany(question::class);
    }
}
