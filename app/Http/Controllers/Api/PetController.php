<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with('customer')->whereNull('deleted_at')->get();
        return new PetResource(true, 'Pets retrieved successfully', $pets);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'species' => 'required',
            'age' => 'required',
            'color' => 'required',
            'gender' => 'required|in:male,female',
        ]);
        $customer = auth()->user()->customer;
        $pet = Pet::create([
            'customer_id' => $customer->id,
            'name' => $validate['name'],
            'species' => $validate['species'],
            'age' => $validate['age'],
            'color' => $validate['color'],
            'gender' => $validate['gender'],
        ]);
        // dd($pet);
        return new PetResource(true, 'Pet created successfully', $pet);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        return new PetResource(true, 'Pet retrieved successfully', $pet);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        //
    }
}
