<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Guest_events_vistes;
use App\Models\Guest;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['show']]);
    }

    public function store(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'user_id' => 'required|string',
            'title' => 'required|string',
            "description"=>'required|string'
        ]);

        try 
        {
            $user = new Events;
            $user->user_id= $request->input('user_id');
            $user->title = $request->input('title');
            $user->description=$request->input('description');
            $user->save();

            return response()->json( [
                        'entity' => 'event', 
                        'action' => 'create', 
                        'result' => 'success'
            ], 201);

        } 
        catch (\Exception $e) 
        {
            return response()->json( [
                       'entity' => 'event', 
                       'action' => 'create', 
                       'result' => 'failed'
            ], 409);
        }
    }

    public function show(Request $request,$id)
    {   
         dd($request);
         Events::find($id);
         Auth::claims(['foo' => "asdasd"])->attempt($credentials);
    }



}