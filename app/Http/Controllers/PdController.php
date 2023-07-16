<?php

namespace App\Http\Controllers;

use App\Models\Pd;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\TryCatch;

class PdController extends Controller
{
    public function index(Request $request){
        $nama_pd =$request->nama_pd;
        $q= Pd::query();
        $q->select('*');
        if(!empty($nama_pd)){
            $q->where('nama_pd','like','%'.$nama_pd.'%');
        }
        $pd=$q->get();
        //$pd=DB::table('pd')->orderBy('id_pd')->get();
        return view('perangkatdaerah.index',compact('pd'));
    }

    public function createstore(Request $request){
        $id_pd= $request->id_pd;
        $nama_pd= $request->nama_pd;
        $d=[
            'id_pd'=>$id_pd,
            'nama_pd'=>$nama_pd
        ];
        $save=DB::table('pd')->insert($d);
        if($save){
            return Redirect::back()->with(['success'=>'Berhasil Di Simpan']);
        }else {
            return Redirect::back()->with(['error'=>'Gagal Di Simpan']);
        }
    }

    public function edit(Request $request){
        $id_pd=$request->id_pd;
        $pd=DB::table('pd')->where('id_pd',$id_pd)->first();
        return view('perangkatdaerah.editpd',compact('pd'));

    }

   // public function update($id_pd, Request $request){
   //     $nama_pd = $request->nama_pd;
   //     $d=[
   //         'nama_pd'=>$nama_pd
   //     ];
   //     $ubah = DB::table('pd')->where('id_pd',$id_pd)->update($d);
   //     if($ubah){
   //         return Redirect::back()->with(['success'=>'Data Berhasil Di Ubah']);
   //     }else{
   //         return Redirect::back()->with(['error'=>'Data Gagal Di Ubah']);
   //     }
  //  }
  public function update($id_pd, Request $request){
        $nama_pd = $request->nama_pd;
    try {
        $d=[
                     'nama_pd'=>$nama_pd
                 ];
                 $ubah = DB::table('pd')->where('id_pd',$id_pd)->update($d);
                     if($ubah){
                       return Redirect::back()->with(['success'=>'Data Berhasil Di Ubah']);
                      }
    } catch (\Throwable $th) {
        //dd($th);
        return Redirect::back()->with(['success'=>'Data Gagal Di Ubah']);
    }
  }

    public function delete($id_pd){
        $delete = DB::table('pd')->where('id_pd',$id_pd)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['error'=>'Gagal Di Hapus']);
        }
    }



}
