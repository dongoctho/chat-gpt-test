<?php

namespace App\Services;

use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ThreadRepository;

class ContinuechatService
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

    public function continueChat(string $question, string $answer, $id)
    {
        $createQuestion = $this->questionRepository->create([
            'content' => $question,
            'thread_id' => $id,
        ]);

        $createAnswer = $this->answerRepository->create([
            'content' => $answer,
            'question_id' => $createQuestion->id,
        ]);

        return response()->json('ok', 200);
    }
}
