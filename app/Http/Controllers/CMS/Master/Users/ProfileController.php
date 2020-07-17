<?php

namespace App\Http\Controllers\CMS\Master\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Interfaces\CMS\Master\Users\UserInterface;
use App\Interfaces\CMS\Master\Users\ProfileInterface;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class ProfileController extends Controller
{
    protected $userInterface, $profileInterface;

    public function __construct(UserInterface $userInterface, ProfileInterface $profileInterface)
    {
        $this->userInterface = $userInterface;
        $this->profileInterface = $profileInterface;

        // Only specific user can access the profile page
        $this->middleware(function($request, $next) {
            $user = User::findOrFail(request()->route('user'));

            if(Gate::allows('is_correct_user', $user)) return $next($request);
            abort(403, config('globalvar.unauthorized'));
        });
    }
    
    public function index($id)
    {
        $user = $this->userInterface->getUserById($id);        
        return view('cms.master.users.profiles.index', compact('user'));
    }

    public function updateUserProfile(ProfileRequest $request, $id)
    {
        $user = $this->userInterface->getUserById($id);
        return $this->profileInterface->updateUserProfile($request, $id);
    }

    public function editPassword($id)
    {
        $user = $this->userInterface->getUserById($id);
        return view('cms.master.users.profiles.password.index', compact('user'));
    }

    public function updatePassword(PasswordRequest $request, $id)
    {
        $user = $this->userInterface->getUserById($id);
        return $this->profileInterface->updateUserPassword($request, $id);
    }

    public function deleteUserPhotoProfile($id)
    {
        $user = $this->userInterface->getUserById($id);
        return $this->profileInterface->deleteUserPhotoProfile($id);
    }

    public function deleteUserAccount($id)
    {
        $user = $this->userInterface->getUserById($id);
        return $this->profileInterface->deleteUserAccount($id);
    }
}
