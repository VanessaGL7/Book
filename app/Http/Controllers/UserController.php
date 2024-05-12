<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,id,' . Auth::id(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();
        $user->username = $request->input('username');
        $user->save();

        return response()->json(['message' => 'Nombre de usuario actualizado exitosamente'], 200);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['message' => 'Contraseña actual incorrecta'], 401);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada exitosamente'], 200);
    }

    public function updateProfilePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_pic' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'public/user-profiles/' . $user->id;

            Storage::put($path . '/' . $filename, $file->getContents());

            if (Storage::exists($path . '/' . $user->profile_pic)) {
                Storage::delete($path . '/' . $user->profile_pic);
            }

            $user->profile_pic = $filename;
            $user->save();
        }

        return response()->json(['message' => 'Foto de perfil actualizada exitosamente'], 200);
    }
}
