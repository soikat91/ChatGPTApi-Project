<?php

namespace App\Http\Controllers;

use App\Models\Gpt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GptController extends Controller
{


    function testGpt(Request $request){

        $userInput = $request->input('question');
        $userID = $request->header('id');
               
       
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' .env('CHATGPT_API_KEY'),
           
        ])
        ->post('https://api.openai.com/v1/chat/completions', [

            'model'=>'gpt-3.5-turbo',
            'messages' => [     
                    [
                        "role"=>'user',
                        "content"=> $userInput
                    ]      
                              
                ],
           "temperature"=>0.5,
           "max_tokens"=>200,
           "top_p"=>1.0,
           'frequency_penalty'=>0.52,
           'presence_penalty'=>0.5,
            'stop'=>["11"]
            
        ])->json();     
       

        // Handle the API response
        if ($response->successful()) {
            // Display the result to the user
            $result = $response->json('choices.0.message.content');
            
            // Save the result to the database (assuming you have a Chat model and a user relationship)          

          $data= Gpt::where('user_id',$userID)->create([
                'question'=>$userInput,
                'answer'=>$result,
                'user_id'=>$userID                
            ]);

            return response()->json(['answer' => $data]);
        } else {
            // Handle error
            return response()->json(['error' => 'API request failed'], 500);
        }
    }

   
}
