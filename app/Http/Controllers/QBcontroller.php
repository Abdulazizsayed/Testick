<?php

namespace App\Http\Controllers;
use App\User;
use App\QuestionBank;
use App\Http\Controllers\Questioncontroller;

use Illuminate\Http\Request;

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

    public function addQuestionToQBView()
    {
        return view('questionsbank/addQuestionToQB');
    }

    public function createQB()
    {
        // Babbo 
        dd("babbo");
    }

    public function addQuestionToQB()
    {
        if(auth()->user()->role == 1 )
        {
            $data = request()->validate([ 
                'another'=>'',
                'QB'=> 'required',
                'parent'=> '',
                'chapter'=> 'required',
                'type'=> 'required',
                'Qcontent'=> 'required',
                'answer1'=> 'required',
                ]);

            $Qdata = [ 'content'=>$data['Qcontent'],'type'=>$data['type'],'chapter'=> $data['chapter'],'parent_id'=> $data['parent'] , 'question_bank_id'=> $data['QB'] ];
            $QC = new Questioncontroller();
            $QC->store($Qdata);
        }
        else
        {
            return view('errorPages/accessDenied');
        }
        return view('questionsbank/addQuestionToQB');
    }

        

}
