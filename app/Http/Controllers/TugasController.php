<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index(){
        $title = "List Tugas";
        $data = [
            "title" => $title
        ];

        return view('tugas.index', $data);
    }

    public function data(Request $request){
        if($request->key){
            $tugas = Tugas::where('judul', 'like', '%'. $request->key.'%')
            ->orWhere('deskripsi', 'like', '%'. $request->key.'%')
            ->get();

            return response()->json(['tugas' => $tugas]);
        }
        $tugas = Tugas::get(); //sama dgn select * from tugas | bisa menggunakan all
        return response()->json(['tugas' => $tugas]);
    }

    public function store(Request $request){
        $tugas = new Tugas();
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->save();

        return response()->json([
            'status' => 200
        ]);
    }

    public function updateStatus(Request $request, $id_tugas){
        $tugas = Tugas::find($id_tugas);
        $tugas->status = $tugas->status == 1 ? 0 : 1;

        if($tugas){
            $tugas->save();
            $tugas->delete();
            return response()->json([
                "status" => 200
            ]);
        } else {
            return response()->json([
                "status" => 500
            ]);
        }
    }

    public function destroy($id_tugas){
        $tugas = Tugas::find($id_tugas);

        if($tugas){
            $tugas->delete();
            return response()->json([
                "status" => 200
            ]);
        } else {
            return response()->json([
                "status" => 500
            ]);
        }
    }
}
