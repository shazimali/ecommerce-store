<?php

namespace App\Services\API\Admin\Auth;

use App\Http\Requests\API\Admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\Admin\Auth\TokenRequest;
use App\Http\Resources\API\Admin\Auth\Notifications\NotificationsListResource;
use App\Interfaces\API\Admin\Auth\AuthInterface;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthService implements AuthInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAuthToken(TokenRequest $request)
    {

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
        $response = [
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

        return response()->json($response, 200);
    }


    public function logOut(int $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->tokens()->delete();
            $response = [
                'status' => 'success',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'status' => 'Logout successfully.',
        ];
        return response()->json($response, 200);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            ['email' => $request->email]
        );
        if ($status === Password::ResetLinkSent) {
            return response()->json(__($status), 200);
        } else {
            return response()->json(__($status), 201);
        }
    }

    public function getNotifications()
    {
        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }

    public function setToReadNotification(int $id)
    {
        AdminNotification::where('id', $id)->update(['is_read' => true]);

        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }

    public function newNotification(Request $request)
    {
        AdminNotification::create($request->except('token'));
        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }

    public function destroyAllNotifications()
    {
        AdminNotification::truncate();
        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }
}
