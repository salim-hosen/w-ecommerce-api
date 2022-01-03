<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Rules\CheckSamePassword;
use App\Rules\MatchOldPassword;

class SettingsController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required', 'string', 'email'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return new UserResource($user);

    }

    public function updatePassword(Request $request){

        $this->validate($request, [
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required', 'confirmed', 'min:6', new CheckSamePassword]
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['message' => 'Password updated'], 200);
    }
}
