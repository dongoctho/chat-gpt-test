<?php

namespace App\Repositories;

use App\Models\question;

class QuestionRepository extends BaseRepository
{
    public function __construct(question $question){
        parent::__construct($question);
    }
}
