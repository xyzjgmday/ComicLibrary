<?php

namespace App\Http\Controllers;

use App\Models\Reader;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = Reader::all()->makeHidden(['password']);
        return response()->json($readers, 200);
    }

    public function show($id)
    {
        $reader = Reader::find($id)->makeHidden(['password']);

        if (!$reader) {
            return response()->json(['message' => 'Readers tidak ditemukan'], 404);
        }

        return response()->json($reader, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:readers',
            'email' => 'required|email|unique:readers',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $hashedPassword = Hash::make($request->input('password'));

        $request->merge(['password' => $hashedPassword]);

        $reader = new Reader;
        $reader->username = $request->input('username');
        $reader->email = $request->input('email');
        $reader->password = app('hash')->make($request->input('email'));
        $reader->setAttribute('updated_at', null);
        $reader->save();

        return response()->json($reader, 201);
    }

    public function update(Request $request, $id)
    {
        $reader = Reader::find($id);

        if (!$reader) {
            return response()->json(['message' => 'Readers tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:readers,username,' . $id,
            'email' => 'required|email|unique:readers,email,' . $id,
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $hashedPassword = Hash::make($request->input('password'));

        $request->merge(['password' => $hashedPassword]);

        $data = $request->all();
        $reader->update($data);

        return response()->json($reader, 200);
    }

    public function destroy($id)
    {
        $reader = Reader::find($id);

        if (!$reader) {
            return response()->json(['message' => 'Readers tidak ditemukan'], 404);
        }

        $reader->delete();

        return response()->json(['message' => 'Readers berhasil dihapus'], 200);
    }
}
