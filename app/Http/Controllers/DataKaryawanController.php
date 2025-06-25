<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DataKaryawanController extends Controller
{
    public function index() {

        if ( auth()->user()->level === 'karyawan' ) {
            return Inertia::render('Dashboard');
        }

        return Inertia::render('employees/Employees');
    }

    public function create() {

        if ( auth()->user()->level === 'karyawan' ) {
            return Inertia::render('Dashboard');
        }

        return Inertia::render('employees/EmployeeAdd');
    }

    public function edit($id) {

        if ( auth()->user()->level === 'karyawan' ) {
            return Inertia::render('Dashboard');
        }

        return Inertia::render('employees/EmployeeEdit', [
            'id' => $id,
            '_token' => auth()->user()->tokens->last()->token
        ]);
    }
}
