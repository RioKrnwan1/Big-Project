<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Http\Requests\CriteriaRequest;

//Criteria Controller - Mengelola kriteria evaluasi
class CriteriaController extends Controller
{
    //Menampilkan daftar kriteria
    public function index()
    {
        $criterias = Criteria::with('subCriterias')->get();
        return view('criterias.index', compact('criterias'));
    }

    //Menampilkan form tambah kriteria
    public function create()
    {
        return view('criterias.create');
    }

    //Menyimpan kriteria baru
    public function store(CriteriaRequest $request)
    {
        try {
            Criteria::create($request->validated());

            return redirect()->route('criterias.index')
                ->with('success', 'Kriteria berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error creating criteria: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan kriteria');
        }
    }

    //Menampilkan form edit kriteria
    public function edit($id)
    {
        try {
            $criteria = Criteria::findOrFail($id);
            return view('criterias.edit', compact('criteria'));
        } catch (\Exception $e) {
            return redirect()->route('criterias.index')
                ->with('error', 'Kriteria tidak ditemukan');
        }
    }

    //Memperbarui data kriteria
    public function update(CriteriaRequest $request, $id)
    {
        try {
            $criteria = Criteria::findOrFail($id);
            $criteria->update($request->validated());

            return redirect()->route('criterias.index')
                ->with('success', 'Kriteria berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating criteria: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kriteria');
        }
    }

    //Menghapus kriteria
    public function destroy($id)
    {
        try {
            $criteria = Criteria::findOrFail($id);
            $criteria->delete();

            return redirect()->back()
                ->with('success', 'Kriteria berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting criteria: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus kriteria');
        }
    }
}