<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;

class LoginController extends Controller
{
    public function login(Request $request) {

        $email = $request->input('email');
        $password = $request->input('password');

     

        if(!$email || !$password){

            return response()->json([
                'status' => false,
                'message' => 'Harap Masukan email password'
            ],400);
        }

// comment
             //validasi email
             $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);

             if(!$email_validate){
                 return response()->json([
                     'status' => false,
                     'message' => 'email tidak valid'
     
                 ],400);
             }

        $exis_user = User::where('email',$email)->where('status',1)->first();
   

        if (!$exis_user){
            return response()->json([
                'status' => false,
                'message' => 'email tidak terdaftar'
            ], 400);
        }


 
       

    
        //hash password

 

        $password_hash = Hash::check($password,$exis_user->password);
        
        if (!$password_hash){
            return response()->json([
                'status' => false,
                'message' => 'password tidak sesuai'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'selamat anda berhasil login',
            'data' => $exis_user
        ],200);
    }
}
