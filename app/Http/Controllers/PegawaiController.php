<?php

namespace App\Http\Controllers;


use DB;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;





class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $q = Pegawai::query();
        $q->select('pegawais.*', 'nama_pd', 'nama_kelamin');
        $q->join('pd', 'pegawais.id_pd', '=', 'pd.id_pd')
            ->join('jenis_kelamin', 'pegawais.id_kelamin', '=', 'jenis_kelamin.id_kelamin');
        $q->orderBy('nama_lengkap');
        if (!empty($request->nama_lengkap)) {
            $q->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if (!empty($request->id_pd)) {
            $q->where('id_pd', 'like', '%' . $request->id_pd . '%');
        }
        $pegawai = $q->paginate(10);

        $pd = DB::table('pd')->get();
        $jenis_kelamin = DB::table('jenis_kelamin')->get();

        return view('pegawai.index', compact('pegawai', 'pd', 'jenis_kelamin'));
    }

    public function createstore(Request $request)
    {
        $nik = $request->nik;
        $nik_pegawai = $request->nik_pegawai;
        $user_name = $request->user_name;
        $nama_lengkap = $request->nama_lengkap;
        $id_kelamin = $request->id_kelamin;
        $tgl_lahir = $request->tgl_lahir;
        $id_pd = $request->id_pd;
        $bagian = $request->bagian;
        $no_telp = $request->no_telp;
        $password = Hash::make('wilianto11');


        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }
        try {
            $d = [
                'nik_pegawai' => $nik_pegawai,
                'user_name' => $user_name,
                'nama_lengkap' => $nama_lengkap,
                'id_kelamin' => $id_kelamin,
                'tgl_lahir' => $tgl_lahir,
                'id_pd' => $id_pd,
                'bagian' => $bagian,
                'no_telp' => $no_telp,
                'foto' => $foto,
                'password' => $password
            ];
            $save = DB::table('pegawais')->insert($d);
            if ($save) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/pegawai/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Pegawai Berhasil Di Tambahkan']);
            }
        } catch (\Throwable $th) {
            dd($th);
            //return Redirect::back()->with(['error'=>'Gagal Menambahkan Pegawai']);
        }
    }

    public function editpegawai(Request $request)
    {
        $nik = $request->nik;
        $pd = DB::table('pd')->get();
        $jenis_kelamin = DB::table('jenis_kelamin')->get();
        $pegawai = DB::table('pegawais')->where('nik', $nik)->first();
        return view('pegawai.editpegawai', compact('pd', 'pegawai', 'jenis_kelamin'));
    }
    public function updatepegawai($nik, Request $request)
    {
        $nik_pegawai = $request->nik_pegawai;
        $user_name = $request->user_name;
        $nama_lengkap = $request->nama_lengkap;
        $id_pd = $request->id_pd;
        $id_kelamin = $request->id_kelamin;
        $tgl_lahir = $request->tgl_lahir;
        $bagian = $request->bagian;
        $no_telp = $request->no_telp;


        $foto_dulu = $request->foto_dulu;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $foto_dulu;
        }
        try {
            $d = [
                'nik_pegawai' => $nik_pegawai,
                'user_name' => $user_name,
                'nama_lengkap' => $nama_lengkap,
                'id_kelamin' => $id_kelamin,
                'tgl_lahir' => $tgl_lahir,
                'id_pd' => $id_pd,
                'bagian' => $bagian,
                'no_telp' => $no_telp,
                'foto' => $foto,
            ];
            $update = DB::table('pegawais')->where('nik', $nik)->update($d);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/pegawai/";
                    $folderPathdulu = "public/uploads/pegawai/" . $foto_dulu;
                    Storage::delete($folderPathdulu);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Berhasil Di Perbarui']);
            }
        } catch (\Throwable $th) {
            dd($th);
            //return Redirect::back()->with(['error'=>'Gagal Di Perbarui']);
        }
    }
    public function deletepegawai($nik)
    {
        $delete = DB::table('pegawais')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Berhasil Di Hapus']);
        } else {

            return Redirect::back()->with(['error' => 'Gagal Di Hapus']);
        }
    }
}
