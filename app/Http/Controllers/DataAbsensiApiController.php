<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Exception;
use Carbon\Carbon;

class DataAbsensiApiController extends Controller
{

    public function list(Request $request) {

        $id = $request->id;

        try {

            if ( !$id ) {
                $this->code = 422;
                throw new Exception('ID required!');
            }

            $user = User::find($id);
            if ( !$user ) {
                $this->code = 404;
                throw new Exception('User not found!');
            }

            $query = Absensi::query();

            $query->with('user');

            $result = [];
            if ( $user->level === 'karyawan' ) {
                $result = $query->where('users_id', $id);
            }

            $result = $query->orderByDesc('created_at')->get();

            foreach($result as $key => $item) {
                $this->data[] = [
                    'no'            => $key + 1,
                    'name'          => $item->user->name,
                    'created_at'    => $item->created_at
                ];
            }

            if ( !$this->data ) {
                $this->code = 404;
                throw new Exception('Belum ada data absensi');
            }

        } catch (Exception $e) {

            if ( $this->code === 200 ) {
                $this->code = 500;
            }

            $this->msg = $e->getMessage();
        }

        $response = [
            'code'  => $this->code,
            'msg'   => $this->msg,
            'data'  => [
                'total' => count($this->data),
                'item'  => $this->data
            ]
        ];

        return response()->json($response, $this->code);
    }

    public function store(Request $request) {

        $usersId    = $request->users_id;
        $createdAt  = $request->created_at;

        try {

            $user = User::find($usersId);

            if ( !$user ) {
                $this->code = 404;
                throw new Exception('User not found!');
            }

            $absensi = Absensi::where('users_id', $usersId)->orderByDesc('created_at')->first();
            if ( $absensi ) {
                $lastAbsent     = Carbon::parse($absensi->created_at)->toDateString();
                $todayAbsent    = Carbon::parse($createdAt)->toDateString();

                if ($lastAbsent === $todayAbsent) {
                    $this->code = 409;
                    throw new Exception('anda sudah absen hari ini.');
                }
            }

            Absensi::create([
                'users_id'      => $usersId,
                'created_at'    => $createdAt
            ]);

            $this->msg = "Absensi berhasil";
        } catch (Exception $e) {
            if ($this->code === 200) {
                $this->code = 500;
            }

            $this->msg = $e->getMessage();
        }

        $response = [
            'code'  => $this->code,
            'msg'   => $this->msg,
            'data'  => $this->data
        ];

        return response()->json($response, $this->code);
    }
}
