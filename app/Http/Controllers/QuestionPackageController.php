<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionPackage;

class QuestionPackageController extends Controller
{
    public function index()
    {
        $questionPackages = QuestionPackage::all();
        return view('exam.exam', compact('questionPackages'));
    }

    public function create()
    {
        $questionPackages = []; // initialize the variable
        return view('exam.create', compact('questionPackages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'time' => 'required|string',
        ]);

        QuestionPackage::create($request->all());

        return redirect()->route('exam.index')->with('success', 'Question Package created successfully.');
    }

    public function edit(QuestionPackage $questionPackage)
    {
        $questionPackages = []; // initialize the variable
        return view('exam.edit', compact('questionPackage'));
    }

    public function update(Request $request, QuestionPackage $questionPackage)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'time' => 'required|string',
        ]);

        $questionPackage->update($request->all());

        return redirect()->route('exam.index')->with('success', 'Question Package updated successfully.');
    }

    public function destroy(QuestionPackage $questionPackage)
    {
        $questionPackage->delete();

        return redirect()->route('exam.index')->with('success', 'Question Package deleted successfully.');
    }

    // Implement other CRUD methods like show, edit, update, and destroy as needed.
}
