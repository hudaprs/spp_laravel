<?php

namespace App\Http\Controllers\CMS\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Interfaces\CMS\Master\RoleInterface;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{

    protected $roleInterface;

    public function __construct(RoleInterface $roleInterface)
    {
        $this->roleInterface = $roleInterface;
        
        // Only High Admin can access this page
        $this->middleware(function($request, $next) {
            if(Gate::allows('is_high_admin')) return $next($request);
            abort(403, config('globalvar.high_admin_gate_message'));
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.master.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = $this->roleInterface->newRole();
        return view('cms.master.roles.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        return $this->roleInterface->requestRole($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->roleInterface->getRoleById($id);
        return view('cms.master.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->roleInterface->getRoleById($id);
        return view('cms.master.roles.create', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        return $this->roleInterface->requestRole($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->roleInterface->deleteRole($id);
    }

    /**
     * Get roles by DataTables
     * 
     * @param \Illuminate\Http\Request;
     */
    public function roleDataTables(Request $request)
    {
        return $this->roleInterface->roleDataTables($request);
    }

    /**
     * Get all roles
     * 
     */
    public function getRoles(Request $request)
    {
        return $this->roleInterface->getRoles($request);
    }
}
