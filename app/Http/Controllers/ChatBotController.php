<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    // public function handle(Request $request){
    //     $result = OpenAI::completions()->create([
    //         'max_tokens' => 1000,
    //         'model' => 'text-davinci-003',
    //         'prompt' => $request->input
    //     ]);
    //     Log::debug("mesage",[$result]);
    //     $response = array_reduce(
    //         $result->toArray()['choices'],
    //         fn(string $result, array $choice) => $result.$choice['text'], ""
    //     );
    //     return $response;
    // }
}
