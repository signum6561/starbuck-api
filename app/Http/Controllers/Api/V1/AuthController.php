<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'username' => 'required|min:2|unique:users,username',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 401);
            }

            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            ));

            return response()->json([
                'message' => 'User Register Successfully',
                'user' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'message' => 'Invalid email or password',
                ], 401);
            }


            if (!$token = auth()->attempt($validator->validated())) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            $refreshToken = $this->createRefreshToken();
            return $this->respondWithToken($token, $refreshToken);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            if (!auth()->user()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'message' => 'User successfully logout',
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUser()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        return response()->json(['message' => 'Get user data successfully', 'data' => $user]);
    }

    public function refresh()
    {
        try {
            $refreshToken = request()->refresh_token;
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            if (time() >= $decoded['exp']) {
                return response()->json(['message' => 'Refresh Token expired'], 401);
            }
            $user = User::find($decoded['sub']);

            if ($user->refresh_token != $decoded['jti']) {
                return response()->json(['message' => 'Invalid Refresh Token'], 404);
            }

            $newRefreshToken = $this->createRefreshToken();
            JWTAuth::invalidate(JWTAuth::getToken());
            $newToken = auth()->login($user);
            return $this->respondWithToken($newToken, $newRefreshToken);
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    private function createRefreshToken()
    {
        $data = [
            'sub' => auth()->user()->id,
            'jti' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];
        auth()->user()->update(['refresh_token' => $data['jti']]);
        return JWTAuth::getJWTProvider()->encode($data);
    }
}
