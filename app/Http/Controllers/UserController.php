<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests;
use App\User;

class UserController extends Controller
{
	public function getDashboard() {
		return view('dashboard');
	}

    public function postSignUp(Request $request) {
    	$email = $request['email'];
    	$name = $request['name'];
    	$password = bcrypt($request['password']);


    	$user = new User();
    	$user->email = $email;
    	//$user->name = $name;
    	$user->password = $password;

    	$user->save();
    	return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request) {
    	//return redirect()->back();
    }


}
