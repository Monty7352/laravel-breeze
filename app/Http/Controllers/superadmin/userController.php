<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    //
    public function createUser()
    {
        return view('superadmin.createuser');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => 'User Created successfully']);



    }

    public function userList(Request $request)
    {
        $page = $request->get('page', 1);
        $itemsPerPage = $request->get('itemsPerPage', 5);

        $users = User::paginate($itemsPerPage, ['*'], 'page', $page);

        return response()->json($users);
    }
    public function edit(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'user not found']);
        }

    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->update([
            'name' => $request->name,
        ]);
        return response()->json(['message' => 'User updated successfully']);
    }
    public function delete(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->delete();
            return response()->json(['msg' => 'user deleted successfully']);
        }


    }
    public function searchData(Request $request){
        $searchInput=$request->searchData;
        if($searchInput){
            $user=User::where('name','LIKE',"%$searchInput%")
            ->orWhere('email','LIKE',"%$searchInput%")->get();
            return response()->json($user);

        }
        

    }
}
