<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function registerCustomer(Request $request)
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

        return response()->json([
            'message' => 'Register customer berhasil',
            'data' => $user->load('customer')
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
