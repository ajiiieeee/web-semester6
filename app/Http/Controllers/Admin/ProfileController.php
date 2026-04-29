<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // 🔥 TAMPILKAN HALAMAN (1 PAGE CRUD)
    public function index()
    {
        $data = PerangkatDesa::all();
        return view('admin.profile.index', compact('data'));
    }

    // 🔥 SIMPAN DATA BARU
  public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'jabatan' => 'required',
        'foto' => 'nullable|image'
    ]);

    $data = new PerangkatDesa();
    $data->nama = $request->nama;
    $data->jabatan = $request->jabatan;

    if ($request->hasFile('foto')) {
        $data->foto = $request->file('foto')->store('perangkat', 'public');
    }

    $data->save();

    return back()->with('success', 'Data berhasil ditambahkan');
}

    // 🔥 UPDATE DATA
    public function update(Request $request, $id)
{
    $data = PerangkatDesa::findOrFail($id);

    $data->nama = $request->nama;
    $data->jabatan = $request->jabatan;

    if ($request->hasFile('foto')) {
        $data->foto = $request->file('foto')->store('perangkat', 'public');
    }

    $data->save();

    return back()->with('success', 'Data berhasil diupdate');
}

    // 🔥 HAPUS DATA
    public function destroy($id)
    {
        $item = PerangkatDesa::findOrFail($id);

        if ($item->foto) {
            Storage::delete('public/' . $item->foto);
        }

        $item->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}