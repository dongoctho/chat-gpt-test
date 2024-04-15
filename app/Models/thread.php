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
        'content',
        'user_id',
        'modal_id',
    ];
}
