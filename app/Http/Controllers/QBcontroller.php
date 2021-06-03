<?php
namespace App\Http\Controllers;
use App\User;
use App\QuestionBank;
use App\Http\Controllers\Questioncontroller;
use PhpOffice\PhpSpreadsheet;
use App\Question;
use App\Answer;

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
        
        if(auth()->user()->role == 1 )
        {
            $data = request()->validate([ 
                'QBfile' => 'mimes:xls,xlsx,csv',
                'title' => 'required',
                'sub' => 'required',
            ]);
            $QuestionBankData = ['title' => $data['title'] , 'instructor_id' => auth()->user()->id , 'subject_id' => $data['sub']];
            $newQuestionBank = QuestionBank::create($QuestionBankData); // creating the new question bank
            $path = $data['QBfile']->getRealPath();
            $reader= \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
            $excel_Obj = $reader->load($path);
            $worksheet=$excel_Obj->getActiveSheet();
            $lastRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestDataColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); 
            
            $Questions = array(); // total questions
                     
            for($row=2;$row<=$lastRow ;$row++){
                $QuestionObj = new Question();
                $QuestionFromDataBase;
                for($col='A';$col<=$highestColumn ;$col++)
                {
                    $Answers = array(); // total answers
                    $cellValue = $worksheet->getCell($col . $row)->getValue();
                    if($col == 'A') // Question
                    {
                        $QuestionObj['content'] = $cellValue;
                    }
                    else if ($col == 'B') // Type
                    {
                        $QuestionObj['type'] = $cellValue;
                    }
                    else if ($col == 'C') // Chapter
                    {
                        $QuestionObj->chapter = $cellValue;
                    }
                    else if ($col == 'D') // parent id
                    {
                        $QuestionObj['parent_id'] = $cellValue;
                        $insertQuestion = ['content' => $QuestionObj['content'] , 'type' => $QuestionObj['type'] , 'chapter' => $QuestionObj['chapter'] , 'parent_id' => $QuestionObj['parent_id'] , 'question_bank_id' => $newQuestionBank['id']];
                        $QuestionFromDataBase = Question::create($insertQuestion); 
                    }
                    else if ($col == 'E') // Correct Answer - the question ID is missing :)
                    {
                        
                        if($QuestionObj['type'] == "Essay")
                        {
                            $insertAnswer = ['content' => $cellValue , 'is_correct' => 1 , 'question_id' => $QuestionFromDataBase->id];
                            $dummy = Answer::create($insertAnswer);
                        }
                        else{
                            $answersArray = explode("~" , $cellValue); // cutting string on ~ char
                            for($ans = 0; $ans < count($answersArray) ; $ans++) 
                            {
                                $insertAnswer = ['content' => $answersArray[$ans] , 'is_correct' => 1 , 'question_id' => $QuestionFromDataBase->id];
                                $dummy = Answer::create($insertAnswer);
                            }
                        }
                    }
                    else if ($col == 'F') // Wrong Answer -  the question ID is missing :)
                    {
                        if($QuestionObj['type']!= "Essay")
                        {
                            $answersArray = explode("~" , $cellValue); // cutting string on ~ char
                            for($ans = 0; $ans < count($answersArray) ; $ans++)
                            {
                                $insertAnswer = ['content' => $answersArray[$ans] , 'is_correct' => 0 , 'question_id' => $QuestionFromDataBase->id];
                                $dummy = Answer::create($insertAnswer);
                            }
                        }
                    }
                }
            }
        }
        else
        {
            return view('errorPages/accessDenied');
        }
        return view('questionsbank/addQuestionToQB');
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
