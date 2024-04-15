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

    public function createProcess(string $promt,string $instructions=null)
    {
        $key =  env('OPENAI_API_KEY');
        $client =  OpenAI::client($key);

        $thread = $client->threads()->create([

        ]);

        $assistant = $client->assistants()->create([
            'instructions' => $instructions,
            'model' => 'gpt-4',
        ]);

        $message = $client->threads()->messages()->create($thread->id,[
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
        $data =[
            'threadId' => $response['data'][0]['thread_id'],
            'assistantId' => $response['data'][0]['assistant_id'],
            'content' => $response['data'][0]['content'][0]['text']['value'],
        ];
        return $data;
    }

}
