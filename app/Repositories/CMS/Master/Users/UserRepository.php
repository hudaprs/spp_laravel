<?php

namespace App\Repositories\CMS\Master\Users;

use App\Interfaces\CMS\Master\Users\UserInterface;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
Use App\Models\User;
use DataTables;
use DB;

class UserRepository implements UserInterface
{
    public function userDataTables(Request $request)
    {
        $users = User::query();

        // Check if request is ajax
        if($request->ajax()) {
            return DataTables::of($users)
            ->addColumn('action', function($user) {
                return view('inc.cms._action', [
                    'model' => $user,
                    'url_show' => route('users.show', $user->id),
                    'url_edit' => route('users.edit', $user->id),
                    'url_destroy' => route('users.destroy', $user->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        } else {
            return response()->json(['message' => 'This request accept ajax only'], 400);
        }
    }

    public function newUser()
    {
        return new User;
    }

    public function requestUser(UserRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $user = $id ? User::findOrFail($id) : $this->newUser();
            $user->name = $request->input('name');
            $user->email = preg_replace('/\s+/', '', strtolower($request->input('email')));
            if(!$id) $user->password = \Hash::make($request->password);
            $user->role_id = $request->input('role');
            $user->save();

            DB::commit();
            return response()->json([
                'message' => $id ? 'User has been updated' : 'User created'
            ], $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserById($id)
    {
        return User::with('role')->findOrFail($id);
    }

    public function deleteUser($id)
    {
        DB::beginTransaction();
        try {
            // Check for the same user
            if(auth()->user()->id == $id) return response()->json(['message' => 'You cannot remove your account here'], 400);
            else User::findOrFail($id)->delete();

            DB::commit();
            return response()->json([
                'message' => 'User has been removed'
            ], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
