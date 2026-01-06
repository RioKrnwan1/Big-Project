<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Http\Requests\DrinkRequest;
use Illuminate\Http\Request;

//Drink Controller - Mengelola alternatif minuman
class DrinkController extends Controller
{
    //Menampilkan daftar minuman
    public function index()
    {
        $drinks = Drink::all();
        return view('drinks.index', compact('drinks'));
    }

    //Menampilkan form tambah minuman
    public function create()
    {
        return view('drinks.create');
    }

    //Menyimpan minuman baru
    public function store(DrinkRequest $request)
    {
        try {
            $data = $request->validated();
            Drink::create($data);

            return redirect()->route('drinks.index')
                ->with('success', 'Minuman berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error creating drink: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan minuman');
        }
    }

    //Menampilkan form edit minuman
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

    //Memperbarui data minuman
    public function update(DrinkRequest $request, $id)
    {
        try {
            $drink = Drink::findOrFail($id);
            $data = $request->validated();
            $drink->update($data);

            return redirect()->route('drinks.index')
                ->with('success', 'Minuman berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating drink: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui minuman');
        }
    }

    //Menghapus minuman
    public function destroy($id)
    {
        try {
            $drink = Drink::findOrFail($id);
            $drink->delete();

            return redirect()->back()
                ->with('success', 'Minuman berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting drink: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus minuman');
        }
    }
}