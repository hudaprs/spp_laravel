<?php

namespace App\Repositories\CMS\Master;

use App\Interfaces\CMS\Master\RoleInterface;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
Use App\Models\Role;
use DataTables;
use DB;

class RoleRepository implements RoleInterface
{
    public function roleDataTables(Request $request)
    {
        $roles = Role::all();

        // Check if request is ajax
        if($request->ajax()) {
            return DataTables::of($roles)
            ->addColumn('action', function($role) {
                return view('inc.cms._action', [
                    'model' => $role,
                    'url_show' => route('roles.show', $role->id), 
                    'url_edit' => route('roles.edit', $role->id), 
                    'url_destroy' => route('roles.destroy', $role->id) 
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        } else {
            return response()->json(['message' => 'This request accept ajax only'], 400);
        }
    }

    public function getRoles(Request $request)
    {
        return Role::where('name', 'LIKE', '%' . $request->get('q') . '%')->orderBy('name', 'asc')->get();
    }

    public function newRole()
    {
        return new Role;
    }

    public function requestRole(RoleRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $role = $id ? Role::findOrFail($id) : $this->newRole();
            $role->name = $request->input('name');
            $role->save();
            
            DB::commit();
            return response()->json([
                'message' => $id ? 'Role has been updated' : 'Role created'
            ], $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public function deleteRole($id)
    {
        DB::beginTransaction();
        try {
            Role::findOrFail($id)->delete();

            DB::commit();
            return response()->json([
                'message' => 'Role has been removed'
            ], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}