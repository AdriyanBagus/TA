<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FormSettingController extends Controller
{
    public function index()
    {
        // $forms = Settings::all();
        // return view('admin.form_settings', compact('forms'));

        // Untuk menampilkan user dan yang sudah dipilih
        $forms = Settings::all();
        $users = User::with('dosen')
            ->where('usertype', 'user')
            ->get();

        // Ambil selected user per form
        $selectedUsersRaw = DB::table('form_user_settings')->get();
        $selectedUsers = [];
        foreach ($selectedUsersRaw as $row) {
            $selectedUsers[$row->form_id][] = $row->user_id;
        }

        return view('admin.form_settings', compact('users', 'forms', 'selectedUsers'));

    }

    public function update(Request $request, $id)
    {

        // Update status form
        $form = Settings::findOrFail($id);
        $form->status = $request->status;
        $form->save();

        // Update user settings
        DB::table('form_user_settings')->where('form_id', $id)->delete();

        $userIds = $request->input('users', []);
        foreach ($userIds as $userId) {
            DB::table('form_user_settings')->insert([
                'form_id' => $id,
                'user_id' => $userId,
                'is_enabled' => true
            ]);
        }

        return redirect()->back()->with('success','Izin Form diubah');

    }
}
