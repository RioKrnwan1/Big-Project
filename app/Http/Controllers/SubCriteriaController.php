<?php
namespace App\Http\Controllers;
use App\Models\SubCriteria;
use App\Models\Criteria;
use Illuminate\Http\Request;

class SubCriteriaController extends Controller {
    public function index()
{
    // Kita ambil semua data, lalu KELOMPOKKAN (Group By) berdasarkan ID Kriteria
    // Hasilnya: [ 1 => [Range Gula...], 2 => [Range Energi...] ]
    $groupedSubs = SubCriteria::with('criteria')->get()->groupBy('criteria_id');
    
    return view('subcriterias.index', compact('groupedSubs'));
}
    public function create() {
        $criterias = Criteria::all();
        return view('subcriterias.create', compact('criterias'));
    }
    public function store(Request $request) {
        SubCriteria::create($request->all());
        return redirect()->route('subcriterias.index');
    }
    public function destroy($id) {
        SubCriteria::destroy($id);
        return redirect()->back();
    }
}