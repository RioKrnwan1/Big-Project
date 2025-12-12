<?php
namespace App\Http\Controllers;
use App\Models\Drink;
use Illuminate\Http\Request;

class DrinkController extends Controller {
    public function index() {
        $drinks = Drink::all();
        return view('drinks.index', compact('drinks'));
    }
    public function create() { return view('drinks.create'); }
    public function store(Request $request) {
        Drink::create($request->all());
        return redirect()->route('drinks.index');
    }
    public function edit($id) {
        $drink = Drink::find($id);
        return view('drinks.edit', compact('drink'));
    }
    public function update(Request $request, $id) {
        Drink::find($id)->update($request->all());
        return redirect()->route('drinks.index');
    }
    public function destroy($id) {
        Drink::destroy($id);
        return redirect()->back();
    }
}