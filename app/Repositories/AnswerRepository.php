<?php

namespace App\Repositories;

use App\Models\answer;

class AnswerRepository extends BaseRepository
{
    public function __construct(answer $answer){
        parent::__construct($answer);
    }
}
