<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user_id' => $user->id,
            'role' => $user->getRoleNames(),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'customer.name' => 'nullable',
            'customer.address' => 'nullable',
            'customer.phone_number' => 'nullable',
            'customer.gender' => 'nullable',
        ]);

        $user = DB::transaction(function () use ($request) {

            // 1. buat user
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. buat customer (relasi)
            $user->customer()->create([
                'name' => $request->customer['name'] ?? null,
                'address' => $request->customer['address'] ?? null,
                'phone_number' => $request->customer['phone_number'] ?? null,
                'gender' => $request->customer['gender'] ?? null,
            ]);
            $user->assignRole('customer');
            return $user;
        });
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user_id' => $user->id,
            'role' => $user->getRoleNames(),
        ]);
    }

    public function getProfile()
    {
        $user = Auth::user()->load('customer'); // Mendapatkan pengguna yang sedang login

        return response()->json([
            'message' => 'Profile retrieved successfully',
            'user' => $user,
        ]);
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:6',
            'customer.name' => 'nullable',
            'customer.address' => 'nullable',
            'customer.phone_number' => 'nullable',
            'customer.gender' => 'nullable',
        ]);

        // Update user information
        $user->update([
            'username' => $request->username ?? $user->username,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Update customer information
        $user->customer()->update([
            'name' => $request->customer['name'] ?? $user->customer->name,
            'address' => $request->customer['address'] ?? $user->customer->address,
            'phone_number' => $request->customer['phone_number'] ?? $user->customer->phone_number,
            'gender' => $request->customer['gender'] ?? $user->customer->gender,
        ]);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
