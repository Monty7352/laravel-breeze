<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

class PermissonController extends Controller
{
    // 
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Define your validation rules here
            'permisson' => 'required|unique:permissions,name',

            // Add more rules as needed
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $permisson = Permission::create([
            'name' => $request->permisson,
        ]);
        if ($permisson) {
            return response()->json(['success' => 'Permisson Created Successfully']);
        }
    }
    public function permissonList()
    {
        $permisson = Permission::all();
        return response()->json($permisson);
    }
    public function permissonDeleteCross(Request $request)
    {
        $permisson = Permission::findById($request->pid);

        if ($permisson) {
            $permisson->delete();
            return response()->json(['msg' => 'ok']);
        }

    }
   

}
