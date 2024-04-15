<?php

namespace App\Http\Controllers\ReactControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\CommonMark\Extension\Table\Table;

class SCORMCreator extends Controller
{
    public function index()
    {
        $dataName = "jaya";
        return view('welcome', ['dataName' => $dataName]);
    }
}
