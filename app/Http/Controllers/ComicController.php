<?php

namespace App\Http\Controllers;
use App\Models\Comics;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ComicController extends Controller
{
    public function index(Request $request)
    {
        try {
            $readerId = $request->input('reader_id');
            $query = Comic::query();

            if ($readerId) {
                $query->where('reader_id', $readerId);
            }

            $comics = $query->get();

            return response()->json([
                'success' => true,
                'data' => $comics,
                'message' => $readerId ? 'Daftar komik dari pembaca tertentu berhasil diambil.' : 'Daftar semua komik berhasil diambil.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar komik. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($ComicsId)
    {
        $Comics = Comics::find($ComicsId);

        if (!$Comics) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        return response()->json($Comics, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'genre' => 'required',
            'description' => 'required',
            'release_date' => 'required|date',
            'language' => 'required',
            'average_rating' => 'required|numeric',
            'number_of_chapters' => 'required|integer',
            'status' => 'required',
            'reader_id' => 'required|exists:readers,reader_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $Comics = Comics::create($request->all());

        return response()->json($Comics, 201);
    }

    // Metode untuk mengupdate komik
    public function update(Request $request, $ComicsId)
    {
        $Comics = Comics::find($ComicsId);

        if (!$Comics) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'genre' => 'required',
            'description' => 'required',
            'release_date' => 'required|date',
            'language' => 'required',
            'average_rating' => 'required|numeric',
            'number_of_chapters' => 'required|integer',
            'status' => 'required',
            'reader_id' => 'required|exists:readers,reader_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $Comics->update($request->all());

        return response()->json($Comics, 200);
    }

    // Metode untuk menghapus komik
    public function destroy($ComicsId)
    {
        $Comics = Comics::find($ComicsId);

        if (!$Comics) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        $Comics->delete();

        return response()->json(['message' => 'Komik berhasil dihapus'], 200);
    }
}
