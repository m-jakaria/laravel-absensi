<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\UserRole;
use Hash;

class UserController extends Controller
{
    public function getUser() {

        $users = User::where('status',1)->get();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $users

        ], 200);

    }

    public function createUser(Request $request) {
        $email = $request->input('email');
        $name = $request->input('name');
        $role = $request->input('role');

        if (!$email || !$name|| !$role ){
            return response()->json([
                'status' => false,
                'message' => 'Form tidak boleh kosong'
            ], 400);
        }

        // validasi
        //validasi email
        $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);

        if(!$email_validate){
            return response()->json([
                'status' => false,
                'message' => 'email tidak valid'

            ],400);
        }

        $exis_user = User::where('email',$email)->where('status',1)->first();
        if ($exis_user){
            return response()->json([
                'status' => false,
                'message' => 'user sudah terdaftar'
            ], 400);
        }

        //cek role
        $roles = Role::get()->count();
        if($roles < 1) {
            return response()->json([
                'status' => false,
                'message' => 'Role tidak ditemukan'
            ],400);
        }

        $exis_role = Role::where('id',$role)->first();
        if(!$exis_role){
            return response()->json([
                'status'=> false,
                'message' => ' Role tidak ditemukan',
                'data' => $exis_role
            ],404);
        }

        $password = Hash::make('123456');
        $status = 1;


        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'status' => $status
        ]);


        if(!$user){
            return response()->json([
                'status'=> false,
                'message' => 'error user gagal dibuat'
            ],400);
        }

        $user_id = $user->id;
        $role_id = $exis_role->id;

        $user_role = UserRole::create([
            'user_id' => $user_id,
            'role_id' => $role_id
        ]);
       


        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $user

        ], 201);

    }

    public function deleteUser(Request $request,$id=null){

        $user = User::where('id',$id)->where('status',1)->first();

        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'user tidak ditemuukan'
            ],404);
        }

        $update_user = $user->update(['status'=>2]);
        if(!$update_user) {
            return response()->json([
                'status' => false,
                'message' => 'user gagal dihapus'
            ],400);
        }

        return response()->json([
            'status' => true,
            'message' => 'data berhasil dihapus'
        ],200);
    }
}
