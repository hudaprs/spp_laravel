<?php

namespace App\Interfaces\CMS\Master;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

interface RoleInterface
{
    /**
     * roles data table
     * 
     * @method GET cms/master/roles/datatables
     * @access private
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function roleDataTables(Request $request);

    /**
     * Get all roles
     * 
     * @method GET cms/master/roles/all
     * @access private
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function getRoles(Request $request);

    /**
     * Create new instance of role model
     * This is just for binding a form
     */
    public function newRole();

    /**
     * Creating / Updating data
     * 
     * @method POST (cms/master/roles) | PUT (cms/master/roles/{id})
     * @access private
     * 
     * @param App\Http\Requests\RoleRequest $request
     * @param int $id
     */
    public function requestRole(RoleRequest $request, $id = null);

    /**
     * Get role by id
     * 
     * @method GET cms/master/roles/{id}
     * @access private
     * 
     * @param int $id
     */
    public function getRoleById($id);

    /**
     * Delete role
     * 
     * @method DELETE cms/master/roles/{id}
     * @access private
     * 
     * @param int $id
     */
    public function deleteRole($id);
}