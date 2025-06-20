<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DataAbsensiController extends Controller
{
    public function index() {
        return Inertia::render('attendances/Attendances');
    }
}
