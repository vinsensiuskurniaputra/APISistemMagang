<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth as LaravelAuth;
use Kreait\Firebase\Auth as FirebaseAuth;  // Menggunakan alias FirebaseAuth untuk membedakan dengan Laravel Auth

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if ($credentials->fails()) {
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $credentials->errors()
            ], 400);
        }

        if (LaravelAuth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $auth = LaravelAuth::user();
            $user = [
                "token" => $auth->createToken('auth_token')->plainTextToken,
                "name" => $auth->name,
                "role" => $auth->role,
            ];

            return response()->json([
                "code" => "200",
                "status" => "OK",
                "data" => $user
            ], 200);
        }

        return response()->json([
            "code" => "401",
            "status" => "UNAUTHORIZED",
            "errors" => [
                "message" => "Username or Password Wrong"
            ]
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'code' => '200',
            'status' => 'success',
            'message' => 'Logged out successfully.'
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required'],
            'new_password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ], 400);
        }

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "code" => "401",
                "status" => "UNAUTHORIZED",
                "errors" => [
                    "message" => "Password is incorrect."
                ]
            ], 401);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'code' => '200',
            'status' => 'success',
            'message' => 'Password reset successfully.'
        ], 200);
    }

    public function authenticateWithFirebase(Request $request)
    {
        // Validasi bahwa ID Token Firebase diterima di request
        $credentials = Validator::make($request->all(), [
            'idToken' => ['required'], // ID Token Firebase harus ada di request
        ]);

        if ($credentials->fails()) {
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $credentials->errors()
            ], 400);
        }

        try {
            // Inisialisasi Firebase Auth
            $firebaseAuth = (new Factory)
                ->withServiceAccount(base_path('credentials.json'))
                ->createAuth();

            // Verifikasi ID Token Firebase yang dikirim dari client
            $idToken = $request->idToken;
            $verifiedIdToken = $firebaseAuth->verifyIdToken($idToken);

            Log::info('Received ID Token: ' . $request->idToken);


            // Ambil email dari verified token
            $firebaseEmail = $verifiedIdToken->claims()->get('email');

            // Cari pengguna di tabel 'users' berdasarkan email yang ada di Firebase
            $user = User::where('email', $firebaseEmail)->first();

            if (!$user) {
                return response()->json([
                    "code" => "401",
                    "status" => "UNAUTHORIZED",
                    "errors" => [
                        "message" => "Google Email Wrong"
                    ]
                ], 401);
            }

            // Login pengguna secara otomatis di Laravel
            LaravelAuth::login($user);

            // Membuat token menggunakan Laravel Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            // Mengembalikan response dengan token dan data pengguna
            $userData = [
                "token" => $token,
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->role, 
            ];

            return response()->json([
                "code" => "200",
                "status" => "OK",
                "data" => $userData
            ], 200);

        } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
            // Jika ID Token tidak valid atau tidak dapat diverifikasi
            return response()->json([
                "code" => "401",
                "status" => "UNAUTHORIZED",
                "errors" => [
                    "message" => "Invalid Firebase ID Token"
                ]
            ], 401);
        }
    }
}
