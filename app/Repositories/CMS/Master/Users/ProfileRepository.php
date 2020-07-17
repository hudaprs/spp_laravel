<?php

namespace App\Repositories\CMS\Master\Users;

use App\Interfaces\CMS\Master\Users\ProfileInterface;
use Illuminate\Http\Request;
use App\Interfaces\CMS\Master\Users\UserInterface;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Helpers\Common;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use DB;

class ProfileRepository implements ProfileInterface
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function updateUserProfile(ProfileRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userInterface->getUserById($id);
            $user->image = Common::uploadFile($request, 'image', 'users', $user);
            $user->name = $request->input('name');
            $user->email = Common::removeWhiteSpace(strtolower($request->input('email')));
            $user->save();

            DB::commit();
            return redirect()->back()->with('success', 'Profile has been updated');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateUserPassword(PasswordRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userInterface->getUserById($id);
            $user->password = \Hash::make($request->input('password'));
            $user->save();

            DB::commit();
            return redirect()->back()->with('success', 'Password has been updated');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteUserPhotoProfile($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userInterface->getUserById($id);
            // Delete the image
            Common::deleteImage('users', $user);
            
            $user->image = null;
            $user->save();


            DB::commit();
            return redirect()->back()->with('success', 'Photo profile has been removed');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteUserAccount($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userInterface->getUserById($id);
            // Delete the image
            Common::deleteImage('users', $user);
            $user->delete();

            DB::commit();
            return redirect()->route('login');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}