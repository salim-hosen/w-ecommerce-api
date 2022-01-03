<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{
    public function getAdmin(){
        return new UserResource(auth()->user());
    }
}
