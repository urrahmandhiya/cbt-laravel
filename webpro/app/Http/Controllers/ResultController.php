<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::all(); // You might need to adjust this query based on your application's logic

        return view('results.index', compact('results'));
    }
}
