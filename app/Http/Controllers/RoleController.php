<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{

    

    public function getRole(){

        $role = Role::all();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $role
        ], 200);

    }


    public function createRole(Request $request){
        $name = $request->input('name');
        $status = $request->input('status');

        if(!$name||!$status){

            return response()->json([

                'status' => false,
                'message' => 'Form tidak boleh kosong'
            ],400);

        }

        //input ke database
        $role = Role::create([
            'name' => $name,
            'status' => $status
        ]);

        if(!$role){
            return response()->json([
                'status' => false,
                'message' => 'Error data gagal dibuat'
            ],400);
        }

        

        return response()->json([

            'status' => true,
            'message' => 'berhasil'

        ],201);
    }

    public function deleteRole(Request $request,$id=null) {

        $role = Role::where('id',$id)->first();

        if(!$role){
            return response()->json([
                'status' => false,
                'message' => 'user tidak ditemukan'

            ],404);
        }

        $delete = $role->delete();
        
        if(!$delete){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak terhapus'
            ],400);
        }
        



        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Dihapus'
        ],200);
    }
}
