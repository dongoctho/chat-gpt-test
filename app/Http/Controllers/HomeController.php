<?php

namespace App\Http\Controllers;

use App\Services\ContinuechatService;
use App\Services\NewchatService;
use App\Services\OpenAiService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $openAiService;
    protected $newChatService;
    protected $continueChatService;

    public function __construct(OpenAiService $openAiService, NewchatService $newChatService, ContinuechatService $continueChatService) {
        $this->openAiService = $openAiService;
        $this->newChatService = $newChatService;
        $this->continueChatService = $continueChatService;
    }
    public function index() {
        return view('index');
    }
    //
    public function createRequest(Request $request)
    {
        $promt = $request->promt;
        $instructions = $request->instructions;
        $response = $this->openAiService->createProcess($promt,$instructions);

        $threadId = $response['threadId'];
        $assistantId = $response['assistantId'];
        $contentAnswer = $response['contentAnswer'];
        $contentQuestion = $response['contentQuestion'];

        $this->newChatService->createChat($threadId, $assistantId, $contentAnswer, $contentQuestion, $promt);

        return redirect()->route('chatgpt.list');
    }

    public function list()
    {
        $datas = $this->openAiService->listChat();

        return view('content', compact('datas'));
    }

    public function edit(string $id)
    {
        $data = $this->openAiService->getQuestionAnswer($id);
        $thread = $this->openAiService->findThread($id);
        $thread_id = $thread->thread_id ;
        $assistant_id = $thread->assistant_id ;
        $id =$thread->id ;
        return view('edit', compact('data', 'thread_id','id','assistant_id'));
    }

    public function continueChat(Request $request)
    {
        $thread_id = $request->thread_id;
        $promt = $request->promt;
        $instructions = $request->instructions;
        $assistant_id = $request->assistant_id;
        $id = $request->id;
        $data = $this->openAiService->createProcess($promt, $instructions, $thread_id,$assistant_id);
        $contentAnswer = $data['contentAnswer'];
        $contentQuestion = $data['contentQuestion'];
        $this->continueChatService->continueChat($contentQuestion, $contentAnswer, $id);

        return redirect()->back();
    }
}
