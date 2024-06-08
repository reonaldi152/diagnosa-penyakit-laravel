<?php

namespace App\Http\Controllers\Admin;

use App\Models\Symptom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SymptomController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::all();
        return view('admin.symptoms.index', compact('symptoms'));
    }

    public function create()
    {
        return view('admin.symptoms.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Symptom::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('symptoms.index');
    }

    public function edit(Symptom $symptom)
    {
        return view('symptoms.form', compact('symptom'));
    }

    public function update(Request $request, Symptom $symptom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $symptom->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('symptoms.index');
    }

    public function destroy(Symptom $symptom)
    {
        $symptom->delete();
        return redirect()->route('symptoms.index');
    }
}
