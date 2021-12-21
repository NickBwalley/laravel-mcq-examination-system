<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TestsController extends Controller
{
    //

    public function getTestQuestions(Request $request, $subject_id){

        // has user registered for this exam.
        $student_already_registered = DB::table('students')->where('user_id', Auth::user()->id)->where('subject_id', $subject_id)->exists();
        $has_taken_exam = DB::table('results')->where('user_id', Auth::user()->id)
                ->where('subject_id', $subject_id)->exists();        

        if($has_taken_exam){
            return redirect()->route('main')->with('hasTakenExam', 'You have already taken the exam!');
        }
        else if(!$student_already_registered){
            return \redirect()->route('dashboard')->with('registerFirst', 'You have not registered for this exam yet!'); 
        }
        // user has already registered
        else{
            //check if the user has already taken the exam.
                $questions = DB::table('tests')->where('subject_id', $subject_id)->get();
                return view('test', ['questions'=>$questions, 'subject_id'=>$subject_id]);
        }

        
        
    }

    public function allResults(){
        // get all results that belong to the currently logged in user.
        $allResults = DB::table('results')->where('user_id', Auth::user()->id)->get();

        return view('table.allResults', ['allResults'=>$allResults] );

    }

    public function allTests(){

        $subjects = DB::table('students')->where('user_id', Auth::user()->id)
            ->join('subjects', 'students.subject_id', '=', 'subjects.id')->get();
        
            return view('table.allTests', ['subjects' => $subjects]);

    }

    public function registerExam(Request $request, $subject_id){

        //check if user already registered!
        $student_already_registered = DB::table('students')->where('user_id', Auth::user()->id)->where('subject_id', $subject_id)->exists();
        $has_taken_exam = DB::table('results')->where('user_id', Auth::user()->id)
                            ->where('subject_id', $subject_id)->exists();
        
        if($has_taken_exam){
            return \redirect()->route('dashboard')->with('hasTakenExam', 'You have already taken this exam before!'); 
        }
        
        else if($student_already_registered){
            return \redirect()->route('dashboard')->with('alreadyRegisteredForExam', 'You have already registered for exam before!'); 
        }else{

            DB::table('students')->insert([
                'user_id'=>Auth::user()->id,
                'name'=>Auth::user()->name,
                'subject_id'=>$subject_id
            ]);
     
            
            return \redirect()->route('dashboard')->with('registeredForExam', 'You have successfully registered for exam!');
        }
    }

    public function submitExam(Request $request){
        // the request contains the answers
        
        $answers = $request->all();
        // dd($answers);

        $points = 0;
        $percentage = 0;
        $totalQuestions = 2;

        $subjectId = $request->input('subject_id');


        foreach($answers as $questionId => $userAnswer){
            // check if the id is not a number then don't try to get an answer
            if(is_numeric($questionId)){
                $questionInfo = DB::table('tests')->where('id', $questionId)->get(); 
                //$questionInfo =  [0=>['id'=>1, name=>'', correct_answer=1]]
                
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

        $subjectName = DB::table('subjects')->where('id', $subjectId)->value('name');

        $id = Auth::user()->id;
        // insert the score in the results table in the database.
        DB::table('results')->insert([
            'user_id'=>$id,
            'score'=>$percentage,
            'subject_id'=>$subjectId,
            'subject_name'=> $subjectName
        ]);

        //remove student information from students table
        DB::table('students')->where('user_id', Auth::user()->id)->where('subject_id', $subjectId)->delete();

        // return to main page. 
        return redirect()->route('main')->with('examSubmitted', 'The Exam has been submitted successfully, check your profile for the results later. ');

    }
    
    
}
