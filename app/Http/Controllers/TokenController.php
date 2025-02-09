<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\CekPlagiasi;

class TokenController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:tokens,token',
        ]);

        $token = Token::where('token', $request->token)->first();

        if (!$token) {
            return back()->with('token_error', 'Token tidak ditemukan.');
        }

        // Mengambil dokumen terkait
        $document = $token->cekPlagiasi;

        return back()->with([
            'document' => $document,
            'status' => $token->status,
        ]);
    }

    /**
     * Update status token oleh superadmin.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $token = Token::findOrFail($id);
        $token->status = $request->status;
        $token->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
