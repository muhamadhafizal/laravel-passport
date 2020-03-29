<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function index(){
        return response()->json('user index');
    }

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $token =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['status' => 'success', 'api_key' => $token, 'value' => $user]);
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $request) { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        $input = $request->all(); 
                $input['password'] = bcrypt($input['password']); 
                $user = User::create($input); 
                $token =  $user->createToken('MyApp')-> accessToken; 
                Auth::attempt(['email' => request('email'), 'password' => request('password')]);
            
                $profile = Auth::user(); 

        return response()->json(['status' => 'success', 'api_key' => $token, 'value' => $profile]);
    }

    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user]); 
    } 

    public function unauthorized(){
        return response()->json(['error'=>'Unauthorised'], 401); 
    }
}
