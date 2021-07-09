<?php

namespace App\Http\Controllers;
use App\User;
use App\QuestionBank;
use App\Http\Controllers\Questioncontroller;
<<<<<<< Updated upstream

use Illuminate\Http\Request;

=======
use App\Http\Controllers\AnswerController;
use PhpOffice\PhpSpreadsheet;
use Validator;
use Request;
use App\Question;
use App\Answer;
use DB;

>>>>>>> Stashed changes
class QBcontroller extends Controller
{
    protected $guarded =[];
    
    public function __construct() 
    {
        $this->middleware('auth'); 
    }

    public function homeView()
    {
        return view('questionsbank/QBhome');
    }

    public function createQBView()
    {
        return view('questionsbank/createQB');
    }

    public function addQuestionToQBView($QB_id)
    {
        return view('questionsbank/addQuestionToQB',['id'=>$QB_id]);
    }

    public function createQB()
    {
        // Babbo 
        dd("babbo");
    }

    public function addQuestionToQB($QuestionBankID)
    {
        if(auth()->user()->role == 1 )
        {
            $data = request::all();
            $validatedData = Validator::make($data, [
                'chapter' => 'required',
                'type' => 'required',
                'Qcontent' => 'required',
                'answer1' => 'required',
            ]);
            if (!$validatedData->fails()) 
            {
                for ($i = 1; $i <= count($data) - 5 ; $i++) 
                {   
                    if( array_key_exists( "answer".$i ,$data ) )
                    {
                        $answersData['answer'.$i] = $data['answer'.$i];
                        if( array_key_exists( "ch".$i ,$data ) )
                        {
                            $answersData["ch".$i] = $data['ch'.$i];
                        }
                        else
                        {
                            $answersData["ch".$i] = "false";
                        }
                    }
                }   
                
                $Qdata = [ 'content'=>$data['Qcontent'],'type'=>$data['type'],'chapter'=> $data['chapter'],'parent_id'=> $data['parent'] , 'question_bank_id'=> $QuestionBankID ];
                $QC = new Questioncontroller();
                $question_obj = $QC->store($Qdata);
                
                $QC = new AnswerController();
                for ($i = 1; $i <= count($answersData) / 2 ; $i++) 
                {   
                    $temp['content'] = $answersData['answer'.$i];
                    $temp['is_correct'] = $answersData["ch".$i];
                    $temp['question_id'] = $question_obj['id'] ;
                    $QC->store($temp);
                } 
            }
            else
            {
                return response($validatedData->messages(), 200);
            }                    
        }
        else
        {
            return view('errorPages/accessDenied');
        }
        return $this->addQuestionToQBView($QuestionBankID); 
    }

        

}
