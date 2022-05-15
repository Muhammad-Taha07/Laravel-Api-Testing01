<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Students;


class UserController extends Controller

{
    public $successStatus = 200;

    public function Userdata()
    {
        return Students::all();
    }

    public function register(Request $request)
    {
        try
        {
        $validator = Validator::make($request->all(),
        [
            'name'=> 'required',
            'email' => 'required',
            'password' => 'required',
            'c_password' => 'required'|'same:password',
        ]);

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        
        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Task fetched successfully",
            "data" => $validator,        
        ], 200);
        }

        catch(Exception $exception)
        {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $exception,
            ], 500);
        }
    }


}
