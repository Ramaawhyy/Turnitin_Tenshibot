<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekPlagiasi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data CekPlagiasi beserta relasi Token
        $query = CekPlagiasi::with('token')->orderBy('created_at', 'desc');

        // Filter berdasarkan status (opsional)
        if ($request->has('status') && in_array($request->status, ['pending', 'in_progress', 'completed'])) {
            $query->whereHas('token', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Tambahkan pagination jika data banyak
        $documents = $query->paginate(10); // Menampilkan 10 dokumen per halaman

        // Logging untuk debugging
        Log::info('SuperAdmin - Documents retrieved:', ['count' => $documents->count()]);

        return view('dashboard.superadmin', compact('documents'));
    }

    public function edit($id)
    {
        // Cari dokumen berdasarkan ID
        $document = CekPlagiasi::findOrFail($id);

        return view('dashboard.superadmin_edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'link_dokumen' => 'nullable|file|mimes:pdf,doc,docx,txt|max:2048', // Maksimal 2MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cari dokumen
        $document = CekPlagiasi::findOrFail($id);

        // Update data
        $document->judul = $request->judul;
        $document->nomor_hp = $request->nomor_hp;

        // Cek apakah ada file baru yang diunggah
        if ($request->hasFile('link_dokumen')) {
            // Hapus file lama jika ada
            if ($document->link_dokumen && Storage::exists($document->link_dokumen)) {
                Storage::delete($document->link_dokumen);
            }

            // Simpan file baru
            $path = $request->file('link_dokumen')->store('documents');

            $document->link_dokumen = $path;
        }

        $document->save();

        // Logging untuk debugging
        Log::info('SuperAdmin - Document updated:', ['id' => $document->id]);

        return redirect()->route('dashboard.superadmin.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi status
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Cari dokumen
        $document = CekPlagiasi::findOrFail($id);

        if ($document->token) {
            $document->token->status = $request->status;
            $document->token->save();
        }

        // Logging untuk debugging
        Log::info('SuperAdmin - Status updated:', ['id' => $document->id, 'status' => $request->status]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
