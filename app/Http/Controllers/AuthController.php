<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Traits\UserTrait;

class AuthController extends Controller
{
    use UserTrait {
        same as traitcalc;
    }
   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','index','same','traitcalc']]);
    }

    public function same(){
        echo "sd";
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'username' => 'required|string|unique:users',
            'password' => 'required|confirmed',
        ]);

        try 
        {
            $user = new User;
            $user->username= $request->input('username');
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            return response()->json( [
                        'entity' => 'users', 
                        'action' => 'create', 
                        'result' => 'success'
            ], 201);

        } 
        catch (\Exception $e) 
        {
            return response()->json( [
                       'entity' => 'users', 
                       'action' => 'create', 
                       'result' => 'failed'
            ], 409);
        }
    }
	
     /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */	 
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $header = $request->header('apikey');
            
        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::claims(['foo' => $header])->attempt($credentials)) {			
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
    }
	
     /**
     * Get user details.
     *
     * @param  Request  $request
     * @return Response
     */	 	
    public function showlogin()
    {
        return response()->json(auth()->user());
    }


    public function showOne(Request $request,$id)
    {
        $payload = auth()->payload();
        // $header = $request->header('apikey');

        // then you can access the claims directly e.g.
        $payload->get('foo'); // = 123
        $payload['jti']; // = 'asfe4fq434asdf'
        $payload('exp'); // = 123456
        return response()->json( $payload->toArray()); 
        return response()->json(User::find($id));
    }



    public function update($id, Request $request)
    {
        $author = User::findOrFail($id);
        $credentials = $request->only(['username', 'password']);
        // dd($id);
        $author->update($credentials);

        return response()->json($author, 200);
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}