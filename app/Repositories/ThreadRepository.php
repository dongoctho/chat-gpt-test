<?php

namespace App\Repositories;

use App\Models\thread;

class ThreadRepository extends BaseRepository
{
    public function __construct(thread $thread){
        parent::__construct($thread);
    }

    public function getThread($with = [])
    {

        return $this->model->with($with)->get();
    }

    

}
