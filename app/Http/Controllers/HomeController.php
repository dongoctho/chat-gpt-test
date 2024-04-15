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
        dd('hello');
    }
    //
    public function createRequest(Request $request)
    {
        //
        // dd('helo');

        $promt = $request->promt;
        $instructions = $request->instructions;
        $response = $this->openAiService->createProcess($promt,$instructions);
        return $response;
    }
}
