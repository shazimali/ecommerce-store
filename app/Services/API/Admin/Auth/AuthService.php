<?php

namespace App\Services\API\Admin\Auth;

use App\Http\Requests\API\Admin\Auth\TokenRequest;
use App\Interfaces\API\Admin\Auth\TokenInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements TokenInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAuthToken(TokenRequest $request){

        if (!Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'Invalid login details.'
                           ], 401);
        }
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $permissions = [];
        foreach ($user->roles as $key => $role) {
            foreach ($role->permissions as $key => $permission) {
                array_push($permissions, $permission->key);
            }
        }
        $respon = [
                    'status' => 'success',
                    'msg' => 'Login successfully',
                    'status_code' => 200,
                    'permissions' => $permissions,
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ]
                ];
       
        return response()->json($respon, 200); 
        
    }
}
