<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SCORMCreatorController extends Controller
{
    public function index()
    {
        return Inertia::render('SCORM/SCORMCreator');
    }
}
