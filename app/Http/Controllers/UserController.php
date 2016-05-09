<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

    public function postSignUp(Request $request) {
    	
    	$this->validate($request, [
    		'email' => 'required|email|unique:users',
    		'name' => 'required|max:10',
    		'password' => 'required|min:5'
    	]);

    	$email = $request['email'];
    	$name = $request['name'];
    	$password = bcrypt($request['password']);

    	$user = new User();
    	$user->email = $email;
    	//$user->name = $name;
    	$user->password = $password;

    	$user->save();

    	Auth::login($user);

    	return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request) {

    	$this->validate($request, [
    		'email' => 'required',
    		'password' => 'required'
    	]);

    	if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
    		return redirect()->route('dashboard');
    	}
    	return redirect()->back();
    }

    public function getLogout() {
    	Auth::logout();
    	return redirect()->route('home');
    }

    public function getAccount() {
    	return view('account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request, [
           'email' => 'required|max:120'
        ]);
        $user = Auth::user();
        $old_name = $user->email;
        $user->email = $request['email'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['email'] . '-' . $user->id . '.jpg';
        $old_filename = $old_name . '-' . $user->id . '.jpg';
        $update = false;
        if (Storage::disk('local')->has($old_filename)) {
            $old_file = Storage::disk('local')->get($old_filename);
            Storage::disk('local')->put($filename, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return Response($file, 200);
    }

}
