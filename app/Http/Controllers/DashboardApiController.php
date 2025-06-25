<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;

class DashboardApiController extends Controller
{

    public function list() {

        $todaysAbsent = Absensi::whereDay('created_at', now()->day)->count();
        $totalEmployees = User::count();

        $this->data = [
            'todaysAbsent' => $todaysAbsent,
            'totalEmployees' => $totalEmployees
        ];

        $response = [
            'code'  => $this->code,
            'msg'   => $this->msg,
            'data'  => $this->data
        ];

        return response()->json($response, $this->code);
    }

}
