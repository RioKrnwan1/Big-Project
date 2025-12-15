<?php

namespace App\Http\Controllers;

use App\Models\SubCriteria;
use App\Models\Criteria;
use App\Http\Requests\SubCriteriaRequest;

/**
 * SubCriteria Controller - Manages sub-criteria ranges
 */
class SubCriteriaController extends Controller
{
    /**
     * Display a listing of sub-criterias grouped by criteria
     */
    public function index()
    {
        $groupedSubs = SubCriteria::with('criteria')->get()->groupBy('criteria_id');
        return view('subcriterias.index', compact('groupedSubs'));
    }

    /**
     * Show the form for creating a new sub-criteria
     */
    public function create()
    {
        $criterias = Criteria::all();
        return view('subcriterias.create', compact('criterias'));
    }

    /**
     * Store a newly created sub-criteria
     */
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

    /**
     * Remove the specified sub-criteria
     */
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