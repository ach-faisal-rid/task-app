<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->filled(['name', 'email', 'username', 'password'])) {
            return response()->json(['message' => 'Semua field harus diisi.'], 422);
        }

        // Validasi input
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'username harus diisi.',
            'username.unique' => 'username sudah terdaftar.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus memiliki setidaknya :min karakter.',
        ]);

        // Cek hasil validasi
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'registrasi berhasil !'
        ], 201);
    }

    public function login(Request $request)
    {
        // Validasi input
        try {
            // Validasi input
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Email harus diisi.',
                'password.required' => 'Password harus diisi.',
            ]);
        } catch (ValidationException $e) {
            // Tangani error validasi dan berikan respons dengan status 422 Unprocessable Entity
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Cek apakah pengguna sudah terautentikasi
        if (auth()->check()) {
            return response()->json(['message' => 'User sudah terautentikasi.'], 422);
        }

        // Cek login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Berhasil login, dapatkan informasi pengguna
            $user = auth()->user();

            // Cek apakah token sudah ada untuk pengguna ini
            $existingToken = $user->tokens()->first();

            if (!$existingToken) {
                // Jika belum ada token, generate token
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'data' => $user,
                    'message' => 'Login berhasil!',
                    'token' => $token
                ], 200);
            } else {
                // Token sudah ada, berikan respons bahwa pengguna sudah terautentikasi
                return response()->json(['message' => 'User sudah terautentikasi.'], 422);
            }
        }

        // Gagal login
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function currentUser()
    {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'message' => 'Informasi pengguna saat ini',
            ], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function changePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        // Periksa kecocokan kata sandi saat ini
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json(['message' => 'Current password does not match'], 400);
        }

        // Ubah kata sandi
        auth()->user()->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    public function logout()
    {
        $user = auth()->user();

        if ($user) {
            // Hapus token akses saat ini
            $user->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout berhasil'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
