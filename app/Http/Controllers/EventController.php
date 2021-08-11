<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Guest_events_vistes;
use App\Models\Guest;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

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
        try {
            $event= Events::find($id);
          } catch (ModelNotFoundException $e) {
            // Handle the error.
                return response()->json( [
                    'entity' => 'event', 
                    'action' => 'getevent', 
                    'result' => 'failed'
                ], 409);
          }
        //   $payload = JWTAuth::factory()->claims(['sub' => $event])->make();
        //   $token = JWTAuth::manager()->encode($payload)->get();
        //   dd($token);
        //   return $this->respondWithToken($token);
        $header = $request->header('Authorization');
        dd(JWTAuth::parseToken()->authenticate());
        // $verify = JWTAuth::authenticate($header);


        if($header){

            $verify = JWTAuth::authenticate($header);
            if($verify){
                return $this->respondWithToken($header);
            }
            // custome validation 
            // getrs
            // mutetares
            // aggreratres
            // scope
            // service injectors
            // validator
            
        }else{

            $factory = JWTFactory::claims([
                'sub'   => "bad",
            ]);

            $payload = $factory->make();
            $token = JWTAuth::encode($payload)->get();  
            return $this->respondWithToken($token);

        }

       
    }


// prefetch

}