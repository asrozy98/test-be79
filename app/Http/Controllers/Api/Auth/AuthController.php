<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repository\AuthRepository;
use App\Http\Response\BaseResponses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwtAuth', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->segment(3) == 'mahasiswa') {
                $validator = Validator::make($request->all(), [
                    'nama' => 'required|string|min:2|max:100',
                    'nim' => 'required|min:2|max:15',
                    'email' => 'required|string|email|max:100|unique:users',
                    'password' => 'required|string|min:6',
                    'alamat' => 'required|string|min:2|max:100',
                    'tanggal_lahir' => 'required|date',
                    'jurusan' => 'required|string|min:2|max:100',
                ]);

                if ($validator->fails()) {
                    return BaseResponses::status(417, null, $validator->errors());
                }

                $data = AuthRepository::registerMahasiswa($request);
            } else {
                $validator = Validator::make($request->all(), [
                    'nama' => 'required|string|min:2|max:100',
                    'email' => 'required|string|email|max:100|unique:users',
                    'password' => 'required|string|min:6',
                ]);

                if ($validator->fails()) {
                    return BaseResponses::status(417, null, $validator->errors());
                }

                $data = AuthRepository::registerDosen($request);
            }

            DB::commit();
            return BaseResponses::status(200, $data, 'Register Success');
        } catch (\Throwable $th) {
            DB::rollback();
            return BaseResponses::status(500, $th->getMessage());
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return BaseResponses::status(417, null, $validator->errors());
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return BaseResponses::status(401, null, 'Unauthorized');
        } else {
            return BaseResponses::withToken(200, $token);
        }
    }

    public function logout()
    {
        auth()->logout();

        return BaseResponses::status(200, null, 'User successfully logged out.');
    }

    public function refresh()
    {
        return BaseResponses::status(200, auth()->refresh(), 'Refresh Success');
    }

    public function profile()
    {
        $data = User::with('dosen')->find(auth()->user()->id);
        return BaseResponses::status(200, $data);
    }
}
