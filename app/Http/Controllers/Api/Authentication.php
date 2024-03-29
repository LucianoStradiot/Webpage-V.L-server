<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use App\Http\Requests\SignUpSuperAdmin;
use App\Http\Requests\Password\ForgotPassword;
use App\Http\Requests\Password\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use \App\Models\SuperAdmin;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\HomeInfoResource;

class Authentication extends Controller
{
    public function signupSuperAdmin(SignUpSuperAdmin $request)
    {
        try {
            $data = $request->validated();
            $user = SuperAdmin::create([
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $token = $user->createToken('main')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error.'], 500);
        }
    }

    public function login(Login $request)
    {
        try {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            $user = SuperAdmin::where('email', $request->email)->first();

            if (optional($user)->email !== $request->email) {
                return response()->json(['messageEmail' => 'Email incorrecto para la contraseña ingresada'], 422);
            }

            if (!password_verify($request->password, $user->password)) {
                return response()->json(['messagePassword' => 'Contraseña incorrecta para el email ingresado'], 422);
            }

            $profilePhotoPath = null;

            if ($request->hasFile('profilePhoto')) {
                $profilePhotoPath = $request->file('profilePhoto')->storeOnCloudinary()->getPublicId();
            }

            Auth::login($user);
            $request->session()->regenerate();
            $token = $user->createToken('main')->plainTextToken;
            $userResource = new HomeInfoResource($user);

            return response([
                'user' => $userResource,
                'token' => $token,
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function forgotPassword(ForgotPassword $request)
    {
        $user = SuperAdmin::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No se encontró un usuario con este correo electrónico'], 404);
        }

        $user->update(['reset_password_used' => false]);

        $token = app('auth.password.broker')->createToken($user);
        $user->update(['reset_password_token' => $token]);

        $frontendResetLink = env('FRONTEND_URL') . '/reset-password/' . $token;


        Mail::to($user->email)->send(new ResetPasswordMail($frontendResetLink, ));

        return response()->json(['message' => 'Enlace de restablecimiento de contraseña enviado al correo electrónico.']);
    }

    public function resetPassword(ResetPassword $request)
    {

        try {
            $user = SuperAdmin::where('reset_password_token', $request->token)
                ->where('reset_password_used', false)
                ->first();

            if (!$user) {
                return response()->json(['messageReset' => 'Email de restablecimiento ya utilizado. Por favor, vuelva a enviar la solicitud'], 404);
            }

            $user->update([
                'password' => bcrypt($request->password),
                'reset_password_token' => null,
                'reset_password_used' => true,
            ]);

            if (!$user->wasChanged()) {
                return response()->json(['error' => 'No se pudo actualizar la contraseña'], 500);
            }

            return response()->json(['message' => 'Contraseña restablecida con éxito']);
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }


    public function verifyResetToken($token)
    {
        try {
            $user = SuperAdmin::where('reset_password_token', $token)
                ->where('reset_password_used', false)
                ->first();

            if (!$user) {
                return response()->json(['messageReset' => 'Token de restablecimiento de contraseña no válido'], 404);
            }

            $tokenRepository = Password::getRepository();
            if (!$tokenRepository->exists($user, $token)) {
                return response()->json(['messageReset' => 'Token de restablecimiento de contraseña no válido'], 404);
            }

            return response()->json(['messageReset' => 'Token de restablecimiento de contraseña válido'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
