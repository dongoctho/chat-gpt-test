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
        string $thread_id = null,
        string $assistantId = null
    ) {
        $key =  env('OPENAI_API_KEY');
        $client =  OpenAI::client($key);

        if ($thread_id == null) {
            $thread = $client->threads()->create([]);

            $assistant = $client->assistants()->create([
                'instructions' => $instructions,
                'model' => 'gpt-3.5-turbo',
            ]);

            $assistantId = $assistant->id;
        } else {
            $thread = $client->threads()->retrieve($thread_id);

            //change assistant
            if($instructions != null){
                $client->assistants()->modify($assistantId, [
                    'instructions' => $instructions,
                    'model' => 'gpt-4',
                ]
                );
            } else {
                $client->assistants()->modify($assistantId, [
                    'model' => 'gpt-4',
                ]
                );
            }
        }

        $client->threads()->messages()->create($thread->id, [
            'role' => 'user',
            'content' => $promt,
        ]);

        $runs = $client->threads()->runs()->create(
            threadId: $thread->id,
            parameters: [
                'assistant_id' => $assistantId,
            ],
        );

        while (true) {
            $runs = $client->threads()->runs()->retrieve(
                threadId: $thread->id,
                runId: $runs->id,
            );
            if ($runs->status == 'completed') break;
        }

        dd($runs);

        $response = $client->threads()->messages()->list($thread->id)->toArray();

        $data = [
            'threadId' => $response['data'][0]['thread_id'],
            'assistantId' => $response['data'][0]['assistant_id'],
            'contentAnswer' => $response['data'][0]['content'][0]['text']['value'],
            'contentQuestion' => $response['data'][1]['content'][0]['text']['value'],
        ];

        return $data;
    }

    public function listChat()
    {
        $datas = $this->threadRepository->getThread('questions.answers');
        return $datas;
    }

    public function getQuestionAnswer($id)
    {
        $datas = $this->questionRepository->getQuestionWithCondition(['thread_id'=>$id],'answers');
        return $datas;
    }
    public function findThread($id){
        $thread = $this->threadRepository->find($id);
        return $thread;
    }
}
