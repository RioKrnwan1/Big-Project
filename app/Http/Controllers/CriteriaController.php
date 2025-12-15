<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Http\Requests\CriteriaRequest;

/**
 * Criteria Controller - Manages evaluation criteria
 */
class CriteriaController extends Controller
{
    /**
     * Display a listing of criterias
     */
    public function index()
    {
        $criterias = Criteria::with('subCriterias')->get();
        return view('criterias.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new criteria
     */
    public function create()
    {
        return view('criterias.create');
    }

    /**
     * Store a newly created criteria
     */
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

    /**
     * Show the form for editing the specified criteria
     */
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

    /**
     * Update the specified criteria
     */
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

    /**
     * Remove the specified criteria
     */
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