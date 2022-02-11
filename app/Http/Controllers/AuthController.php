<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = ['name' => $request->input('username'), 'password' => $request->input('password')];

        //for postman
        $mobile = ($request->input('mobile') === 'true');
        $remember = ($request->input('remember') === 'true');

        //Check if the call came from the mobile application
        if (!$mobile) {

            //**** call from web ***//
            //check if the user checked the remember me option
            if ($remember) {
                //Token valide for one week
                $expiration_date = Carbon::now()->addWeek()->timestamp;
                $customClaims = ['exp' => $expiration_date];
                $token = JWTAuth::customClaims($customClaims)->attempt($credentials);
            } else {
                //token valide for 1 hour

                $token = JWTAuth::attempt($credentials);
            }
        } else {

            //***** Mobile application login*****//
            //token valide for one year
            $expiration_date = Carbon::now()->addYear()->timestamp;
            $customClaims = ['exp' => $expiration_date];
            $token = JWTAuth::customClaims($customClaims)->attempt($credentials);
        }


        if ($token) {
            //return json response with the token in the header , for vue-auth
            return $this->respondWithToken($token)->header('Authorization', $token);
        }
        // unsuccessful login return response 401
        return response()->json(['Login Error' => 'Unauthorized'], 401);
    }


    public function webLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        // dd($credentials);
        if ($token = auth()->attempt($credentials, ['exp' => Carbon::now()->addDays(1)->timestamp])) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'login_error'], 401);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        if ($token = auth()->refresh())
            return $this->respondWithToken($token)->header('Authorization', $token);
        else
            return response()->json(['error' => 'refresh_token_error'], 401);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $exp = JWTAuth::setToken($token)->getPayload();

        $expirationTime = $exp['exp'];
        return response()->json([
            'access_token' => $token,
            'status' => 'success',
            'user' => auth()->user()->load(['role:id,name']),
            'token_type' => 'bearer',
            'expires_in' => $expirationTime
        ]);
    }

}