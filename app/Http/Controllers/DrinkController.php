<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Http\Requests\DrinkRequest;
use Illuminate\Http\Request;

/**
 * Drink Controller - Manages beverage alternatives
 */
class DrinkController extends Controller
{
    /**
     * Display a listing of drinks
     */
    public function index()
    {
        $drinks = Drink::all();
        return view('drinks.index', compact('drinks'));
    }

    /**
     * Show the form for creating a new drink
     */
    public function create()
    {
        return view('drinks.create');
    }

    /**
     * Store a newly created drink
     */
    public function store(DrinkRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle file upload if present
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('drinks', 'public');
                $data['image'] = $imagePath;
            }

            Drink::create($data);

            return redirect()->route('drinks.index')
                ->with('success', 'Minuman berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error creating drink: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan minuman');
        }
    }

    /**
     * Show the form for editing the specified drink
     */
    public function edit($id)
    {
        try {
            $drink = Drink::findOrFail($id);
            return view('drinks.edit', compact('drink'));
        } catch (\Exception $e) {
            return redirect()->route('drinks.index')
                ->with('error', 'Minuman tidak ditemukan');
        }
    }

    /**
     * Update the specified drink
     */
    public function update(DrinkRequest $request, $id)
    {
        try {
            $drink = Drink::findOrFail($id);
            $data = $request->validated();

            // Handle file upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($drink->image && \Storage::disk('public')->exists($drink->image)) {
                    \Storage::disk('public')->delete($drink->image);
                }
                
                $imagePath = $request->file('image')->store('drinks', 'public');
                $data['image'] = $imagePath;
            }

            $drink->update($data);

            return redirect()->route('drinks.index')
                ->with('success', 'Minuman berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating drink: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui minuman');
        }
    }

    /**
     * Remove the specified drink
     */
    public function destroy($id)
    {
        try {
            $drink = Drink::findOrFail($id);
            
            // Delete image if exists
            if ($drink->image && \Storage::disk('public')->exists($drink->image)) {
                \Storage::disk('public')->delete($drink->image);
            }
            
            $drink->delete();

            return redirect()->back()
                ->with('success', 'Minuman berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting drink: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus minuman');
        }
    }
}