<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DataKaryawanController extends Controller
{
    public function index() {
        return Inertia::render('employees/Employees');
    }
    //
}
