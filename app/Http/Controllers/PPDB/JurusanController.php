<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{

    public function getJurusan(Request $request){
        $jurusan = Jurusan::find($request->jurusan);
        return response()->json([
            'status' => true,
            'data' => $jurusan]);
    }

    public function getListJurusan(Request $request){
        $jurusan = Jurusan::where('sekolah_id', $request->sekolah_id)->get();
        return response()->json([
            'status' => true,
            'data' => $jurusan]);
    }
}
