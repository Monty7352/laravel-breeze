<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    //
    public function index()
    {
        $role = Role::all();
        $permisson = Permission::all();

        return view('Role&Permisson.index', compact('role', 'permisson'));
    }
    public function permissonByRoleId(Request $request)
    {
        $roleId = $request->roleId;


        $role = Role::find($roleId);
        if ($role) {

            $permissions = $role->getAllPermissions();


            return response()->json($permissions); // Return JSON response


        }
        return response()->json(['error' => 'Role not found'], 404); // Return error response if role not found
    }
    public function updatePermissonOfRole(Request $request)
    {
        $roleId = $request->roleid;
        $permissonId = $request->permissonId;
        // Find the role
        $role = Role::findById($roleId);

        // If role doesn't exist, return an error or handle accordingly
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        // If permissionIds is not an array, convert it to an array
        if (!is_array($permissonId)) {
            $permissonId = [$permissonId];
        }
        foreach($permissonId as $permissonIds)
        {
            $permisson=Permission::findById($permissonIds);
             // If permission doesn't exist, return an error or handle accordingly
        if (!$permisson) {
            return response()->json(['error' => 'Permission not found'], 404);
        }
         // Check if the role already has the permission
         if ($role->hasPermissionTo($permisson)) {
            $role->syncPermissions($permisson);
              
    
        } else {
            // If no, assign permission
            $role->givePermissionTo($permisson);
        }

        }
        return response()->json(['message' => 'Permissions updated successfully'], 200);

    }

}
