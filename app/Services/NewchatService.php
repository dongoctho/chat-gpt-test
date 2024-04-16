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
        string $promt,
        string $instructions = null,
        string $id = null,
        $client
    )
    {
        $thread = $client->threads()->create([]);
        $assistant = $client->assistants()->create([
            'instructions' => $instructions,
            'model' => 'gpt-3.5-turbo',
        ]);
        $title = $promt;
        $atribute = [
            'title' => $title,
            'thread_id' => $thread->id,
            'assistant_id' => $assistant->id,
            'user_id' => 1,
            'modal_id' => '1',
        ];
        $thread = $this->threadRepository->create($atribute);

        $createQuestion = $this->questionRepository->create([
            'content' => $promt,
            'thread_id' => $thread->id,
        ]);
        $createAnswer = $this->answerRepository->create([
            'content' => $response['data'][0]['content'][0]['text']['value'],
            'question_id' => $createQuestion->id,
        ]);
    }


}
