<?php

namespace App\Http\Controllers\Admin;

use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::all();
        return view('admin.diseases.index', compact('diseases'));
    }

    public function create()
    {
        $symptoms = Symptom::all();
        return view('admin.diseases.form', compact('symptoms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'symptoms' => 'required|array',
            'symptoms.*' => 'integer',
            'additional_symptoms' => 'array',
            'additional_symptoms.*' => 'string'
        ]);

        $disease = Disease::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'additional_symptoms' => json_encode($request->input('additional_symptoms'))
        ]);

        $disease->symptoms()->attach($request->input('symptoms'));

        return redirect()->route('diseases.index');
    }

    public function edit(Disease $disease)
    {
        $symptoms = Symptom::all();
        $disease->load('symptoms');
        return view('admin.diseases.form', compact('disease', 'symptoms'));
    }

    public function update(Request $request, Disease $disease)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'symptoms' => 'required|array',
            'symptoms.*' => 'integer',
            'additional_symptoms' => 'array',
            'additional_symptoms.*' => 'string'
        ]);

        $disease->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'additional_symptoms' => json_encode($request->input('additional_symptoms'))
        ]);

        $disease->symptoms()->sync($request->input('symptoms'));

        return redirect()->route('diseases.index');
    }

    public function destroy(Disease $disease)
    {
        $disease->delete();
        return redirect()->route('diseases.index');
    }
}
