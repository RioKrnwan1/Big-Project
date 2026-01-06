<?php

namespace App\Http\Controllers;

use App\Models\SubCriteria;
use App\Models\Criteria;
use App\Http\Requests\SubCriteriaRequest;

//SubCriteria Controller - Mengelola rentang sub-kriteria
class SubCriteriaController extends Controller
{
    //Menampilkan daftar sub-kriteria yang dikelompokkan berdasarkan kriteria
    public function index()
    {
        $groupedSubs = SubCriteria::with('criteria')->get()->groupBy('criteria_id');
        return view('subcriterias.index', compact('groupedSubs'));
    }

    //Menampilkan form tambah sub-kriteria
    public function create()
    {
        $criterias = Criteria::all();
        return view('subcriterias.create', compact('criterias'));
    }

    //Menyimpan sub-kriteria baru
    public function store(SubCriteriaRequest $request)
    {
        try {
            SubCriteria::create($request->validated());

            return redirect()->route('subcriterias.index')
                ->with('success', 'Sub-kriteria berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error creating sub-criteria: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan sub-kriteria');
        }
    }

    //Menampilkan form edit sub-kriteria
    public function edit($id)
    {
        try {
            $subCriteria = SubCriteria::findOrFail($id);
            $criterias = Criteria::all();
            return view('subcriterias.edit', compact('subCriteria', 'criterias'));
        } catch (\Exception $e) {
            return redirect()->route('subcriterias.index')
                ->with('error', 'Sub-kriteria tidak ditemukan');
        }
    }

    //Memperbarui data sub-kriteria
    public function update(SubCriteriaRequest $request, $id)
    {
        try {
            $subCriteria = SubCriteria::findOrFail($id);
            $subCriteria->update($request->validated());

            return redirect()->route('subcriterias.index')
                ->with('success', 'Sub-kriteria berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating sub-criteria: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui sub-kriteria');
        }
    }

    //Menghapus sub-kriteria
    public function destroy($id)
    {
        try {
            $subCriteria = SubCriteria::findOrFail($id);
            $subCriteria->delete();

            return redirect()->back()
                ->with('success', 'Sub-kriteria berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting sub-criteria: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus sub-kriteria');
        }
    }
}