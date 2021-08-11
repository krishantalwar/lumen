<?php

namespace App\Http\Traits;
use App\Models\User;

trait UserTrait {
    public function index() {
        // Fetch all the students from the 'student' table.
        $user = User::all();
        dd($user);
    }

     function same() {
        // Fetch all the students from the 'student' table.
        $user = User::all();
        // dd($user);
        echo "asd";
    }
}
