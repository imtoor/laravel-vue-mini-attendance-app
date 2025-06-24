<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use Exception;

class DataKaryawanApiController extends Controller
{
    private $code   = 200;
    private $msg    = '';

    public function list(Request $request) {

        $result = User::where('level', 'karyawan')->get();

        if  (!$result) {
            $this->code = 404;
            $this->msg = 'Data not found!';
        }

        $total = $result->count();

        $response = [
            'code'  => $this->code,
            'msg'   => $this->msg,
            'data'  => [
                'total' => $total,
                'item' => $result
            ]
        ];

        return response()->json($response, $this->code);
    }

    public function detail($id) {

        $user = User::find($id);

        if (!$user) {
            $this->code = 404;
            $this->msg = 'Data not found!';
        }

        $response = [
            'code'  => $this->code,
            'msg'   => $this->msg,
            'data'  => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone
            ]
        ];

        return response()->json($response, $this->code);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users'
        ], [
            'name.required'     => 'Nama harus diisi',
            'email.required'    => 'Email harus diisi',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah terdaftar',
            'phone.required'    => 'No.handphone harus diisi',
            'phone.unique'      => 'No.handphone sudah terdaftar'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'id'        => '',
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make('123456'),
            'level'     => 'karyawan'
        ]);

        if (!$user) {
            $this->code = 500;
        } else {
            $this->code = 201;
        }

        return response()->json(['message' => 'Karyawan berhasil ditambahkan'], $this->code);
    }

    public function update(Request $request, $id = '') {

        if ($id === '') {
            return response()->json(['code' => 422, 'msg' => 'ID Required'],422);
        }

        try {

            $user = User::find($id);

            if (!$user) {
                $this->code   = 404;
                throw new Exception('Data not found!');

            }

            $user = User::where('id', $id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
            ]);

            if (!$user) {
                throw new Exception('Something went wrong!');
            }

        } catch (Exception $e) {

            if ($this->code === 200) {
                $this->code = 500;
            }

            $this->msg = $e->getMessage();
        }

        $response = [
            'code'  => $this->code,
            'msg'   => $this->msg,
            'data'  => $user
        ];

        return response()->json($response, $this->code);
    }

    public function delete($id) {

        try {

            $user = User::find($id);
            $name = $user->name;

            if (!$user) {
                $this->code = 404;
                throw new Exception('Data not found!');
            }

            $user = User::where('id', $id)->delete();

            if (!$user) {
                throw new Exception('Something went wrong!');
            }

            $this->msg = 'Data '.ucwords($name).' telah dihapus.';
        } catch (Exception $e) {
            if ($this->code === 200) {
                $this->code = 500;
            }
            $this->msg = $e->getMessage();
        }

        $response = [
            'code'  => $this->code,
            'msg'   => $this->msg,
            'data'  => $user
        ];

        return response()->json($response, $this->code);
    }

}
