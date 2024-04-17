<?php

namespace App\Services;

use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ThreadRepository;

class NewchatService
{
    protected $threadRepository, $questionRepository, $answerRepository;

    public function __construct(
        ThreadRepository $threadRepository,
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository
    ) {
        $this->threadRepository = $threadRepository;
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
    }

    public function createChat(
        string $threadId,
        string $assistantId,
        string $contentAnswer,
        string $contentQuestion,
        string $promt
    ) {
        $title = $promt;

        $atribute = [
            'title' => $title,
            'thread_id' => $threadId,
            'assistant_id' => $assistantId,
            'user_id' => 1,
            'modal_id' => '1',
        ];

        $Createthread = $this->threadRepository->create($atribute);

        $createQuestion = $this->questionRepository->create([
            'content' => $contentQuestion,
            'thread_id' => $Createthread->id,
        ]);

        $createAnswer = $this->answerRepository->create([
            'content' => $contentAnswer,
            'question_id' => $createQuestion->id,
        ]);

        return response()->json('ok', 200);
    }


}
