// app/Http/Controllers/ApiController.php

namespace App\Http\Controllers;

use App\Models\Reader;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    // Metode untuk mendapatkan semua pembaca
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

    // Metode untuk mendapatkan semua komik atau komik berdasarkan pembaca
    public function getAllComics(Request $request)
    {
        $user_id = $request->input('user_id');
        $query = Comic::query();

        if ($user_id) {
            $query->where('reader_id', $user_id);
        }

        $comics = $query->get();

        return response()->json($comics, 200);
    }

    // Metode untuk mendapatkan komik berdasarkan ID
    public function getComicById($comicId)
    {
        $comic = Comic::find($comicId);

        if (!$comic) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        return response()->json($comic, 200);
    }

    // Metode untuk membuat komik baru
    public function createComic(Request $request)
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

        $comic = Comic::create($request->all());

        return response()->json($comic, 201);
    }

    // Metode untuk mengupdate komik
    public function updateComic(Request $request, $comicId)
    {
        $comic = Comic::find($comicId);

        if (!$comic) {
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

        $comic->update($request->all());

        return response()->json($comic, 200);
    }

    // Metode untuk menghapus komik
    public function deleteComic($comicId)
    {
        $comic = Comic::find($comicId);

        if (!$comic) {
            return response()->json(['message' => 'Komik tidak ditemukan'], 404);
        }

        $comic->delete();

        return response()->json(['message' => 'Komik berhasil dihapus'], 200);
    }
}
