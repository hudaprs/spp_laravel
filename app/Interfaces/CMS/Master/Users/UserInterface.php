<?php

namespace App\Interfaces\CMS\Master\Users;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

interface UserInterface
{
    /**
     * Users data table
     * 
     * @method GET cms/master/users/datatables
     * @access private
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function userDataTables(Request $request);

    /**
     * Create new instance of user model
     * This is just for binding a form
     */
    public function newUser();

    /**
     * Creating / Updating data
     * 
     * @method POST (cms/master/users) | PUT (cms/master/users/{id})
     * @access private
     * 
     * @param App\Http\Requests\UserRequest $request
     * @param int $id
     */
    public function requestUser(UserRequest $request, $id = null);

    /**
     * Get user by id
     * 
     * @method GET cms/master/users/{id}
     * @access private
     * 
     * @param int $id
     */
    public function getUserById($id);

    /**
     * Delete user
     * 
     * @method DELETE cms/master/users/{id}
     * @access private
     * 
     * @param int $id
     */
    public function deleteUser($id);
}