<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = User::where('usertype', 'dosen')
                      ->where('parent_id', Auth::id())
                      ->get();

        return view('pages.daftar-dosen', compact('dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tambah-dosen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nidn' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'kualifikasi_pendidikan' => ['nullable', 'string', 'max:255'],
            'sertifikasi_pendidik_profesional' => ['nullable',Rule::in(['Ya', 'Tidak'])],
            'bidang_keahlian' => ['nullable', 'string', 'max:255'],
            'bidang_ilmu_prodi' => ['nullable',Rule::in(['Sesuai', 'Tidak Sesuai',])],
            'jenis_dosen' => ['nullable',Rule::in(['Dosen Tetap', 'Dosen Tidak Tetap',])],
            'status_dosen' => ['nullable',Rule::in(['Dosen Akademik', 'Dosen Praktisi',])],
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'usertype'  => $request->usertype,
            'parent_id' => Auth::id(),
            'nidn' => $request->nidn,
            'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
            'sertifikasi_pendidik_profesional' => $request->sertifikasi_pendidik_profesional,
            'bidang_keahlian' => $request->bidang_keahlian,
            'bidang_ilmu_prodi' => $request->bidang_ilmu_prodi,
            'jenis_dosen' => $request->jenis_dosen,
            'status_dosen' => $request->status_dosen,
        ]);

        return redirect()->route('tambah-dosen.index')->with('success', 'Dosen berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('pages.edit-dosen', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('tambah-dosen.index')->with('success-edit', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('tambah-dosen.index')->with('success-delete', 'User berhasil dihapus');
    }
}
