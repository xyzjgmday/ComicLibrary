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
            $readerId = $request->input('rd');

            $comics = Comics::when($readerId, function ($query) use ($readerId) {
                return $query->where('reader_id', $readerId);
            })->get();

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


    public function show($id)
    {
        $Comics = Comics::with(['genres', 'readers:id,username,email,created_at'])->find($id);

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
            'description' => 'required',
            'release_date' => 'required|date',
            'status' => 'required',
            'genre_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $comics = new Comics;
        $comics->title = $request->input('title');
        $comics->author = $request->input('author');
        $comics->description = $request->input('description');
        $comics->release_date = $request->input('release_date');
        $comics->status = $request->input('status');
        $comics->genre_id = $request->input('genre_id');
        $comics->setAttribute('updated_at', null);
        $comics->save();

        return response()->json($comics, 201);
    }

    // Metode untuk mengupdate komik
    public function update(Request $request, $id)
    {
        $Comics = Comics::find($id);

        if (!$Comics) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'release_date' => 'required|date',
            'status' => 'required',
            'genre_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $Comics->update($request->all());

        return response()->json($Comics, 200);
    }

    public function destroy($id)
    {
        $Comics = Comics::find($id);

        if (!$Comics) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        $Comics->delete();

        return response()->json(['message' => 'Komik berhasil dihapus'], 200);
    }
}