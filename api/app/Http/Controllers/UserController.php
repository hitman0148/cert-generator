<?php

namespace App\Http\Controllers;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::where('email',$request->input('email'))->exists()){
            return response()->json(['status' => 406, 'message' => 'Email already used.','icon'=>'info','type'=>'negative']);
        }else{
            User::create([
                'fname'             => $request->input('fname'),
                'lname'             => $request->input('lname'),
                'email'             => $request->input('email'),
                'password'          => Hash::make($request->input('password')),
                'date_created'      => now()
            ]);
            return response()->json(['status' => 200, 'message' => 'User Registered Successfully','icon'=>'check_circle','type'=>'positive']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::where('id',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    // ============================================================
    public function login(Request $request){
        $credentials = $request->only(['email','password']);
        $res =  User::where('email',$request->email)->first();
        if($res):
            
                if(Hash::check($request->password,$res->password)){

                    // if (!$token = JWTAuth::attempt($credentials)) {
                    if (!$token = auth()->attempt($credentials)) {
                        return response()->json(['error' => 'Unauthorized'], 401);
                    }else{
                        // $payload = auth()->payload();
                        $msg = [
                            'status' => 200,
                            'msg' => "success",
                            'access_token' => $token,
                            'token_type' => 'bearer',
                            // 'payload' => $payload->toArray(),
                            'data' => JWTAuth::user(),
                        ];
                    }
                }else{
                    $msg = [
                        'test' => json_decode(Hash::check($request->password,$res->password)),
                        'status' => 401,
                        'msg' => "Invalid Credentials",
                        'type' => 'negative',
                        'icon' => 'info'
                    ];
                }
            
        else:
            $msg = [
                'status' => 401,
                'msg' => "Invalid Users",
                'type' => 'negative',
                'icon' => 'info'
            ];
        endif;
        return $msg;
    }
}
