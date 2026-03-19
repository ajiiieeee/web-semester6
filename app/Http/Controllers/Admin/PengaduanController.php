<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\master_pengaduan;
use App\Models\master_penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;

        $pengaduan = master_pengaduan::with('penduduk')
            ->when($katakunci, function ($query) use ($katakunci) {
                $query->where('nik', 'like', "%$katakunci%")
                    ->orWhereHas('penduduk', function ($q) use ($katakunci) {
                        $q->where('nama_lengkap', 'like', "%$katakunci%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.pengaduan.index', compact('pengaduan'));
    }


    public function show($id)
    {
        $pengaduan = master_pengaduan::with('penduduk')->findOrFail($id);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    
    public function destroy($id)
    {
        $pengaduan = master_pengaduan::findOrFail($id);

        if ($pengaduan->foto1 && Storage::disk('public')->exists($pengaduan->foto1)) {
            Storage::disk('public')->delete($pengaduan->foto1);
        }

        $pengaduan->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function feedback(Request $request, $id)
{
    $pengaduan = master_pengaduan::findOrFail($id);

    $request->validate([
        'feedback' => 'required|string|max:1000',
    ]);

    $pengaduan->feedback = $request->feedback;
    $pengaduan->save();

    return redirect()->route('master-pengaduan.index')->with('success', 'Feedback berhasil dikirim.');
}

}