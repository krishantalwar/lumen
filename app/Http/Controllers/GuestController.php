<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class GuestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

  

}