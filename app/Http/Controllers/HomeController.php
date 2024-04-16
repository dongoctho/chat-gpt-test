<?php

namespace App\Http\Controllers;

use App\Services\OpenAiService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $openAiService;

    public function __construct(OpenAiService $openAiService ) {
        $this->openAiService = $openAiService;
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

        return view('index')->with('content');
    }

    public function list()
    {
        $datas = $this->openAiService->listChat();

        return view('content', compact('datas'));
    }

    public function edit(string $id)
    {
        $data = $this->openAiService->findThread($id);
        $thread_id = $id;
        return view('edit', compact('data', 'thread_id'));
    }

    public function continueChat(Request $request)
    {
        $promt = $request->promt;
        $instructions = $request->instructions;
        $thread_id = $request->id;
        $response = $this->openAiService->createProcess($promt,$instructions, $thread_id);

        return view('index')->with('content');
    }
}
