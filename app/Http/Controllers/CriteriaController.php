<?php
namespace App\Http\Controllers;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller {
    public function index() {
        $criterias = Criteria::all();
        return view('criterias.index', compact('criterias'));
    }
    public function create() { return view('criterias.create'); }
    public function store(Request $request) {
        Criteria::create($request->all());
        return redirect()->route('criterias.index');
    }
    public function edit($id) {
        $criteria = Criteria::find($id);
        return view('criterias.edit', compact('criteria'));
    }
    public function update(Request $request, $id) {
        Criteria::find($id)->update($request->all());
        return redirect()->route('criterias.index');
    }
}