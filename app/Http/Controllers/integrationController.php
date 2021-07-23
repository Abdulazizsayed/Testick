<?php

namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet;
use Illuminate\Http\Request;
use App\Http\Controllers\userController;
use App\User;
use App\Http\Controllers\courseController;
use App\Course;

class integrationController extends Controller
{
    public function integrate(Request $request)
    {
        $uploaded_file = $request->file->store('public/uploads'); // default , will upload the file and store it at storage/app/public
        $path = $request->file->getRealPath();
        $reader= \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
        $excel_Obj = $reader->load($path);
        $worksheet=$excel_Obj->getActiveSheet();
        $lastRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestDataColumn();

        $Uni = array();
        $Course = array();
        $users = array();
        for($row = 1 ; $row <= $lastRow ; $row++) 
        {
            $userObj = new User();
            for($col='A';$col<=$highestColumn ;$col++)
            {
                $cellValue = $worksheet->getCell($col . $row)->getValue();
                if($cellValue != null)
                {
                    if($row == 1) // Univirsty infomration
                    {
                        array_push($Uni , $cellValue); 
                    }
                    else if ($row == 2 ) // Course infromation
                    {
                        array_push($Course , $cellValue);
                    }
                    else{ // Users information
                        if($col == 'A')
                        {
                            $userObj['name'] = $cellValue;
                        }
                        if($col == 'B')
                        {
                            $userObj['email'] = $cellValue;
                        }
                        if($col == 'C')
                        {
                            $role = 0;
                            if($cellValue == 'doctor')
                            {
                                $role = 1;
                            }
                            $userObj['role'] = $role;
                        }
                    } 
                }  
            }
            if($row > 2){
                array_push($users , $userObj);
            }
        }
        $courseObj = new courseController();
        $myCourse = $courseObj->create($Course);
        $user = new userController();
        $usersIDs = array();
        for($i = 0 ; $i < count($users) ; $i++)
        {
           $foundUser =  $user->create($users[$i]);
           $foundUser->courses()->attach($myCourse['id']);
        }
        return redirect()->away('http://localhost/integrationForm/ContactFrom_v12/integrationForm.php');
    }
}
