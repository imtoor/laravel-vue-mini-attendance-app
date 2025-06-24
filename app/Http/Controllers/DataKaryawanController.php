<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DataKaryawanController extends Controller
{
    public function index() {
        return Inertia::render('employees/Employees');
    }
    
    public function create() {
        return Inertia::render('employees/EmployeeAdd');
    }

    public function edit($id) {
        return Inertia::render('employees/EmployeeEdit', [
            'id' => $id,
            '_token' => auth()->user()->tokens->last()->token
        ]);
    }
}
