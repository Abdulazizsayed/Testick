<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\Gmail;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    public function create($User)
    {
        $found = User::where('email', '=', $User['email'])->first();
        if($found == null) // a new user will be created
        {
            $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890');
            $password = substr($random, 0, 6);
            $hashedPassword = Hash::make($password);
            $User['password'] = $hashedPassword;
            $User['username'] = $User['name'];
            $addUser = array('username' => $User['name'] , 'name'  => $User['name'] , 'password' => $hashedPassword 
            , 'role' => $User['role'] , 'email' => $User['email']);
            $createdUser = User::create($addUser);

            $emailBody = 'You have been successfully registered to Testick. 
            Now you can login using these credantials.' .
            '  Email: ' . $User['email'] .
            '  Password: ' . $password;

            $details = [
                'title' => 'New user login credantials.',
                'body' => $emailBody,
            ];

            Mail::to($User['email'])->send(new Gmail($details));
            return createdUser;
        }
        else{
            return $found;
        }
        
    }
}
