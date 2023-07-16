<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LokasiController extends Controller
{
    public function lokasikantor(){
        $lokasi_kantor = DB::table('lokasi_kantor')->where('id',1)->first();
        return view('lokasi.lokasikantor',compact('lokasi_kantor'));
    }

    public function updatelokasi(Request $request){
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $updatelokasi = DB::table('lokasi_kantor')->where('id',1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);
        if($updatelokasi){
            return Redirect::back()->with(['success'=>'Berhasil Di Ubah']);
        }else{
            return Redirect::back()->with(['error'=>'Gagal Di Ubah']);
        }

    }
}
