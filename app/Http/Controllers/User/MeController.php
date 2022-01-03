<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;

class MeController extends Controller
{

    public function getMe(){
        return new UserResource(auth()->user());
    }

}
