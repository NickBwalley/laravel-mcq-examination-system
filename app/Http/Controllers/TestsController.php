<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TestsController extends Controller
{
    //

    public function getTestQuestions(){
        $questions = DB::table('tests')->get();
        return view('test', ['questions' => $questions ]);
    }

    public function submitExam(Request $request){
        // the request contains the answers
        
        $answers = $request->all();
        // dd($answers);
        $points = 0;
        $percentage = 0;
        $totalQuestions = 2;


        foreach($answers as $questionId => $userAnswer){
            // check if the id is not a number then don't try to get an answer
            if(is_numeric($questionId)){
                $questionInfo = DB::table('tests')->where('id', $questionId)->get(); 
                //$questionInfo =  [0=>['id'=>1, name=>'', correct_answer=]]
                
                $correctAnswer = $questionInfo[0]->correct_answer;

                if($correctAnswer == $userAnswer){
                // give user a point 
                $points++;
                }
            }
            
        }
        // calculate the final score. 
        $percentage = ($points/$totalQuestions) * 100; 
        // dd($percentage);

        // insert the score in the results table in the database.
        DB::table('results')->insert([
            'user_id'=>1,
            'score'=>$percentage,
        ]);

        // return to main page. 
        return view('index');
    }
    
    
}
