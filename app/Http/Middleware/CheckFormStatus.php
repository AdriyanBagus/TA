<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class CheckFormStatus
{
    public function handle(Request $request, Closure $next, $formName)
    {
        // Cek form di table settings
        $form = Settings::where('form_name', $formName)->first();

        if (!$form) {
            return redirect()->route('form.off')->with('error', 'Pengaturan form tidak ditemukan.');
        }

        if ($form->status != 1) {
            return redirect()->route('form.off')->with('error', 'Form ini sedang tidak tersedia.');
        }

        // Ambil ID user saat ini
        $userId = Auth::id();

        // Cek aktif/tidak untuk user langsung atau parent chain
        $allowed = false;

        while ($userId) {
            $isEnabled = DB::table('form_user_settings')
                ->where('form_id', $form->id)
                ->where('user_id', $userId)
                ->value('is_enabled');

            if ($isEnabled == 1) {
                $allowed = true;
                break;
            }

            // Ambil parent_id dari tabel users
            $userId = DB::table('users')->where('id', $userId)->value('parent_id');
        }

        if (!$allowed) {
            return redirect()->route('form.off')->with('error', 'Form ini sedang tidak tersedia untuk Anda.');
        }

        return $next($request);
    }


    // public function handle(Request $request, Closure $next)
    // {
    //     $formName = $request->route('form_name');
    //     $form = Settings::where('form_name', $formName)->first();

    //     if (!$form) {
    //         return redirect()->route('form.off')->with('error', 'Pengaturan form tidak ditemukan.');
    //     }

    //     if ($form->status != 1) {
    //         return redirect()->route('form.off')->with('error', 'Form ini sedang tidak tersedia.');
    //     }

    //     $user = Auth::user();

    //     // Cek akses usertype
    //     if ($user->usertype === 'dosen' && $user->parent_id) {
    //         // Ambil parent (prodi)
    //         $prodiAccess = DB::table('form_user_settings')
    //             ->where('form_id', $form->id)
    //             ->where('user_id', $user->parent_id)
    //             ->where('is_enabled', true)
    //             ->exists();

    //         if (!$prodiAccess) {
    //             return redirect()->route('form.off')->with('error', 'Formulir ini tidak tersedia untuk dosen karena prodi Anda belum diberi akses.');
    //         }
    //     } else {
    //         // Cek akses langsung (admin / user)
    //         $access = DB::table('form_user_settings')
    //             ->where('form_id', $form->id)
    //             ->where('user_id', $user->id)
    //             ->where('is_enabled', true)
    //             ->exists();

    //         if (!$access) {
    //             return redirect()->route('form.off')->with('error', 'Formulir ini tidak tersedia untuk Anda.');
    //         }
    //     }

    //     return $next($request);
    // }
}
