<?php

namespace App\Http\Controllers;
use App\Models\Reader;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReaderController extends Controller
{
    public function getAllReaders()
    {
        $readers = Reader::all();
        return response()->json($readers, 200);
    }

    // Metode untuk mendapatkan pembaca berdasarkan ID
    public function getReaderById($readerId)
    {
        $reader = Reader::find($readerId);

        if (!$reader) {
            return response()->json(['message' => 'Pembaca tidak ditemukan'], 404);
        }

        return response()->json($reader, 200);
    }

    // Metode untuk membuat pembaca baru
    public function createReader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:readers',
            'email' => 'required|email|unique:readers',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $reader = Reader::create($request->all());

        return response()->json($reader, 201);
    }

    // Metode untuk mengupdate pembaca
    public function updateReader(Request $request, $readerId)
    {
        $reader = Reader::find($readerId);

        if (!$reader) {
            return response()->json(['message' => 'Pembaca tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:readers,username,' . $readerId,
            'email' => 'required|email|unique:readers,email,' . $readerId,
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $reader->update($request->all());

        return response()->json($reader, 200);
    }

    // Metode untuk menghapus pembaca
    public function deleteReader($readerId)
    {
        $reader = Reader::find($readerId);

        if (!$reader) {
            return response()->json(['message' => 'Pembaca tidak ditemukan'], 404);
        }

        $reader->delete();

        return response()->json(['message' => 'Pembaca berhasil dihapus'], 200);
    }
}
