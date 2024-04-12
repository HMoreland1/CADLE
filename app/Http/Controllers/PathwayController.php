<?php

namespace App\Http\Controllers;

use App\Models\Pathway;
use Illuminate\Http\Request;

class PathwayController extends Controller
{
    public function index()
    {
        $pathways = Pathway::all(); // Fetch all pathways from the database
        return response()->json($pathways); // Return pathways as JSON response
    }
}
