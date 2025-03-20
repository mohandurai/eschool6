<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
Use Exception;

use App\User;

class UserController extends Controller
{
    //
    public function index()
    {
        $userlist = User::all();
        return view('pages.users.index', compact('userlist'));
    }


    public function show($id)
    {
        return view('pages.auth.login');
    }


    public function create()
    {
        return view('pages.users.create');
    }

    public function edit($id)
    {
        $data['posts'] = User::find($id);
        return View::make('pages.users.edit', $data);
    }

    // public function logout()
    // {
    //     return view('pages.auth.login');
    // }

    // public function logincheck(Request $request)
    // {
    //     echo "QQQQQQQQQQQQQQQQQ";
    //     exit;
    // }


    public function register(Request $request)
    {
        $validations = [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'password2' => ['required']
        ];
        $validator = Validator::make($request->all(), $validations, []);

        if ($validator->fails()) {
            $this->message = $validator->errors();
            // print_r($this->message);
            // exit;
            return Redirect::to('/auth/register')->with('message', $this->message);
        } else {

            if($request->password == $request->password2) {
                try {
                    $user = new User();

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->password = Hash::make($request->password);

                    $user->save();
                    return Redirect::to('/auth/login')->with('message', "Welcome ! New User Registered Successfully !!!");
                }
                catch (\Throwable $e) {
                    // return 'My error message';
                    return Redirect::to('/auth/register')->with('message', "User email id already exists - Try different email id !!!");
                }
            } else {
                return Redirect::to('/auth/register')->with('message', "Passwords are not matched, Re-Try again !!!");
            }


        }
    }

    // public function logout()
    // {
    //     Session::flush();
    //     Auth::logout();
    //     // return redirect('pages.auth.login');
    //     // Session::flush();
    //     // Auth::logout();

    //     return Redirect::to('/auth/login');
    // }


}
