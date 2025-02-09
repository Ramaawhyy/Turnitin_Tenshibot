<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;

class AdminController extends Controller
{
    // Menampilkan daftar token
    public function tokenList()
    {
        $tokens = Token::with('cekTurnitin', 'user')->get();
        return view('admin.token_list', compact('tokens'));
    }
}
