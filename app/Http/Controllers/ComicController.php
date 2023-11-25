<?php

namespace App\Http\Controllers;
use App\Models\Comics;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ComicController extends Controller
{
    // Metode untuk mendapatkan semua komik atau komik berdasarkan pembaca
    public function getAllComics(Request $request)
    {
        $user_id = $request->input('user_id');
        $query = Comics::query();

        if ($user_id) {
            $query->where('reader_id', $user_id);
        }

        $comics = $query->get();

        return response()->json($comics, 200);
    }

    // Metode untuk mendapatkan komik berdasarkan ID
    public function getComicById($ComicsId)
    {
        $Comics = Comics::find($ComicsId);

        if (!$Comics) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        return response()->json($Comics, 200);
    }

    // Metode untuk membuat komik baru
    public function createComics(Request $request)
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
    public function updateComics(Request $request, $ComicsId)
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
    public function deleteComics($ComicsId)
    {
        $Comics = Comics::find($ComicsId);

        if (!$Comics) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        $Comics->delete();

        return response()->json(['message' => 'Komik berhasil dihapus'], 200);
    }
}
