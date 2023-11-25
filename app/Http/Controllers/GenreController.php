<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $res['success'] = true;
        $res['result'] = Genre::all();

        return response($res);
    }

    public function show($id)
    {
        $reader = Genre::find($id);

        if (!$reader) {
            return response()->json(['success' => false, 'message' => 'Genre tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $reader], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $reader = Genre::create($request->all());
        return response()->json($reader, 201);
    }

    public function update(Request $request, $id)
    {
        $reader = Genre::find($id);

        if (!$reader) {
            return response()->json(['message' => 'Genre tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();
        $data['updated_at'] = Carbon::now();

        $reader->update($data);
        return response()->json($reader, 200);
    }

    public function destroy($id)
    {
        $reader = Genre::find($id);

        if (!$reader) {
            return response()->json(['message' => 'Pembaca tidak ditemukan'], 404);
        }

        $reader->delete();

        return response()->json(['message' => 'Pembaca berhasil dihapus'], 200);
    }
}
