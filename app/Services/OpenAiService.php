<?php

namespace App\Services;

use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ThreadRepository;
use OpenAI;

class OpenAiService
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

    public function createProcess(
        string $promt,
        string $instructions = null,
        string $id = null
    ) {
        $key =  env('OPENAI_API_KEY');
        $client =  OpenAI::client($key);



        if ($id == null) {
            $thread = $client->threads()->create([]);

            $assistant = $client->assistants()->create([
                'instructions' => $instructions,
                'model' => 'gpt-3.5-turbo',
            ]);
        } else {
            $findThread = $this->threadRepository->find($id);
            $thread = $client->threads()->retrieve($findThread->thread_id);
        }


        $client->threads()->messages()->create($thread->id, [
            'role' => 'user',
            'content' => $promt,
        ]);

        $runs = $client->threads()->runs()->create(
            threadId: $thread->id,
            parameters: [
                'assistant_id' => $assistant->id,
            ],
        );

        while (true) {
            $runs = $client->threads()->runs()->retrieve(
                threadId: $thread->id,
                runId: $runs->id,
            );
            if ($runs->status == 'completed') break;
        }

        $response = $client->threads()->messages()->list($thread->id)->toArray();



        $data = [
            'threadId' => $response['data'][0]['thread_id'],
            'assistantId' => $response['data'][0]['assistant_id'],
            'content' => $response['data'][0]['content'][0]['text']['value'],
        ];

        return $data;
    }

    public function listChat()
    {
        $datas = $this->threadRepository->getThread('questions.answers');
        return $datas;
    }

    public function findThread($id)
    {
        $datas = $this->questionRepository->getQuestionWithCondition(['thread_id' => $id], 'answers');
        return $datas;
    }
}
