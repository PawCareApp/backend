<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
/**
 * @authenticated
 */
class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with('customer')->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
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
        $user = $request->user()->load('customer');

        $validate = $request->validate([
            'name' => 'required',
            'species' => 'required',
            'age' => 'required',
            'color' => 'required',
            'gender' => 'required|in:male,female',
        ]);

        $pet = Pet::create([
            'customer_id' => $user->customer->id,
            'name' => $validate['name'],
            'species' => $validate['species'],
            'age' => $validate['age'],
            'color' => $validate['color'],
            'gender' => $validate['gender'],
        ]);

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
        $validate = $request->validate([
            'name' => 'sometimes|string',
            'species' => 'sometimes|string',
            'age' => 'sometimes|string',
            'color' => 'sometimes|string',
            'gender' => 'sometimes|in:male,female',
        ]);
        $pet->update([
            'name' => $validate['name'],
            'species' => $validate['species'],
            'age' => $validate['age'],
            'color' => $validate['color'],
            'gender' => $validate['gender'],
        ]);
        $pet->save();
        return new PetResource(true, 'Pet updated successfully', $pet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();
        return new PetResource(true, 'Pet deleted successfully', $pet->deleted_at);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $pet = Pet::withTrashed()->findOrFail($id);
        $pet->restore();
        return new PetResource(true, 'Pet restored successfully', $pet);
    }
}
