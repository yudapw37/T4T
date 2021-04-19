<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Session;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    /**
     * @SWG\Post(
     *   path="/api/Regist",
	 *   tags={"Users"},
     *   summary="Regist User",
     *   operationId="UsersRegist",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Regist User",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="name", type="string", example="nama"),
     *              @SWG\Property(property="email", type="string", example="nama@mail.com"),
	 *				@SWG\Property(property="password", type="string", example="nama123")
     *          ),
     *      )
     * )
     *
     */

    public function Regist(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
            return response()->json($rslt, 400);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $rslt =  $this->ResultReturn(200, 'success', 'success');
        return response()->json($rslt, 200);
    
    }

    /**
     * @SWG\Post(
     *   path="/api/Login",
	 *   tags={"Users"},
     *   summary="Login User",
     *   operationId="UsersLogin",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Login User",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="email", type="string", example="nama@mail.com"),
	 *				@SWG\Property(property="password", type="string", example="nama123")
     *          ),
     *      )
     * )
     *
     */

    public function Login (Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }

            // var_dump('test');
            $credentials = request(['email', 'password']);
            if (! $token = auth()->attempt($credentials)) {                
                $rslt =  $this->ResultReturn(401, 'Incorrect Email & password', 'Unauthorized');
                return response()->json($rslt, 401);
            }else{
                $getUser = User::where('email', '=', $request->email)->first();  
                // var_dump($token);         
                $usernew = ['User'=>$getUser, 'access_token' => $token, 'token_type' => 'bearer', 'expires_in' => auth()->factory()->getTTL() * 60 ];
                $rslt =  $this->ResultReturn(200, 'success', $usernew);
                return response()->json($rslt, 200);                
            }
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/Logout",
	 *   tags={"Users"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Logout User",
     *   operationId="UsersLogout",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     * )
     *
     */

    public function Logout()
    {
        auth()->logout();
        $rslt =  $this->ResultReturn(200, 'Successfully logged out', 'Successfully logged out');
        return response()->json($rslt, 200);
    }

    /**
     * @SWG\Post(
     *   path="/api/ForgotPassword",
	 *   tags={"Users"},
     *   summary="Forgot Password User",
     *   operationId="ForgotPassword",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Forgot Password User",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="email", type="string", example="nama@mail.com")
     *          ),
     *      )
     * )
     *
     */
    public function ForgotPassword (Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }

            $getUser = User::where('email', '=', $request->email)->first();

            if ($getUser) {                
                $newPass = $this->RandomPassword();
                User::where('email', '=', $request->email)
                    ->update(['password' => bcrypt($newPass)]);                
                $usernew = ['User'=>$getUser, 'new_password' => $newPass];
                $rslt =  $this->ResultReturn(200, 'success', $usernew);
                return response()->json($rslt, 200);
            }else{
                $rslt =  $this->ResultReturn(401, 'Incorrect Email', 'Unauthorized');
                return response()->json($rslt, 401);  
            }
            
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/EditProfile",
	 *   tags={"Users"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Edit Profile User",
     *   operationId="EditProfile",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Edit Profile User",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="name", type="string", example="nama"),
	 *				@SWG\Property(property="email", type="string", example="nama@mail.com"),
     *              @SWG\Property(property="password", type="string", example="1QwOp@"),
	 *				@SWG\Property(property="new_password", type="string", example="1QwOp@"),
     *              @SWG\Property(property="confirm_password", type="string", example="1QwOp@")
     *          ),
     *      )
     * )
     *
     */
    public function EditProfile (Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }

            $credentials = request(['email', 'password']);
            if (! $token = auth()->attempt($credentials)) {                
                $rslt =  $this->ResultReturn(401, 'Incorrect Email & password', 'Unauthorized');
                return response()->json($rslt, 401);
            }elseif($request->new_password != $request->confirm_password){
                $rslt =  $this->ResultReturn(401, 'Incorrect New Password & Confirm password', 'Unauthorized');
                return response()->json($rslt, 401);
            }else{
                User::where('email', '=', $request->email)
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($request->new_password)
                        ]);

                $rslt =  $this->ResultReturn(200, 'Success Update Profile', 'success');
                return response()->json($rslt, 200);                
            }
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    function RandomPassword() {
        $maxLengthPass=8;
        $pass = array(); 
        
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char='!@#$*';
        $number='1234567890';
        
        $getNumberRandChar = rand(1,$maxLengthPass-1);
        $getNumberRandNumber = rand(1,$maxLengthPass-1);
        if($getNumberRandChar == $getNumberRandNumber){
            $getNumberRandChar = 2;
            $getNumberRandNumber = 5;
        }

        $alphaLength = strlen($alphabet) - 1;
        $charLength = strlen($char) - 1;
        $numberLength = strlen($number) - 1; 

        for ($i = 0; $i < $maxLengthPass; $i++) {
            $varPass='';
            if($getNumberRandChar == $i){
                $n = rand(0, $charLength);
                $varPass=$char[$n];
            }elseif($getNumberRandNumber == $i){
                $n = rand(0, $numberLength);
                $varPass=$number[$n];
            }else{
                $n = rand(0, $alphaLength); 
                $varPass=$alphabet[$n]; 
            }           
            $pass[] = $varPass;
        }
        return implode($pass); 
    }

    protected function RespondWithToken($token, $data)
    {
        return response()->json([
            'success'=>true,
            'data'=>$data,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }
}
