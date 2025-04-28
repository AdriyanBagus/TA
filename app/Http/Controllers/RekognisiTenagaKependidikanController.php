<?php

namespace App\Http\Controllers;

use App\Models\RekognisiTenagaKependidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekognisiTenagaKependidikanController extends Controller
{
    public function index(){
        return view('pages.rekognisi_tenaga_kependidikan');
    }

    public function show(){
        if (Auth::user()->id) {
            $rekognisi_tenaga_kependidikan = RekognisiTenagaKependidikan::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.rekognisi_tenaga_kependidikan', compact('rekognisi_tenaga_kependidikan'));
    }

    public function add(Request $request)
    {
        RekognisiTenagaKependidikan::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'bidang_keahlian' => $request->bidang_keahlian,
            'jenis_rekognisi' => $request->jenis_rekognisi,
            'tingkat' => $request->tingkat,
            'tahun_perolehan' => $request->tahun_perolehan,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $rekognisi_tenaga_kependidikan = RekognisiTenagaKependidikan::find($id);
        $rekognisi_tenaga_kependidikan->nama = $request->nama;
        $rekognisi_tenaga_kependidikan->bidang_keahlian = $request->bidang_keahlian;
        $rekognisi_tenaga_kependidikan->jenis_rekognisi = $request->jenis_rekognisi;
        $rekognisi_tenaga_kependidikan->tingkat = $request->tingkat;
        $rekognisi_tenaga_kependidikan->tahun_perolehan = $request->tahun_perolehan;
        $rekognisi_tenaga_kependidikan->user_id = Auth::user()->id;
        $rekognisi_tenaga_kependidikan->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $rekognisi_tenaga_kependidikan = RekognisiTenagaKependidikan::find($id);
        $rekognisi_tenaga_kependidikan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
