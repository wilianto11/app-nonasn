<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class AbsensiController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $nik = Auth::guard('pegawai')->user()->nik;
        $check = DB::table('absensis')
            ->where([['tgl_absensi', $today], ['nik', $nik]])
            ->count();
        $lokasi_kantor = DB::table('lokasi_kantor')
            ->where('id', 1)
            ->first();
        return view('absensi.index', compact('check', 'lokasi_kantor'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $tgl_absensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lokasi = $request->lokasi;
        $image = $request->image;
        $folderPath = 'public/uploads/absensi/';
        $lokasi_kantor = DB::table('lokasi_kantor')
            ->where('id', 1)
            ->first();
        $lok = explode(',', $lokasi_kantor->lokasi_kantor);
        $check = DB::table('absensis')
            ->where([['tgl_absensi', $tgl_absensi], ['nik', $nik]])
            ->count();

        # To store different file name
        if ($check > 0) {
            $writeName = 'out';
        } else {
            $writeName = 'in';
        }

        $formatName = $nik . '-' . $tgl_absensi . '-' . $writeName;
        $image_parts = explode(';base64', $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . '.png';
        $file = $folderPath . $fileName;

        # Data Radius

        $latOffice = $lok[0];
        $longOffice = $lok[1];
        $locUser = explode(',', $lokasi);
        $latUser = $locUser[0];
        $longUser = $locUser[1];

        $dis = $this->distance($latOffice, $longOffice, $latUser, $longUser);
        $radius = round($dis['meters']);

        # Check radius
        if ($radius > $lokasi_kantor->radius) {
            echo "error|Sorry, you're out of radius " . $radius . ' meters|radius';
        } else {
            # Check data exist or not
            if ($check > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'location_out' => $lokasi,
                ];
                $post = DB::table('absensis')
                    ->where([['tgl_absensi', $tgl_absensi], ['nik', $nik]])
                    ->update($data_pulang);
                if ($post) {
                    echo 'success|Good bye, take care!|out';
                    Storage::put($file, $image_base64);
                } else {
                    echo 'error|Oops, data failed to save!|out';
                }
            } else {
                $data_masuk = [
                    'nik' => $nik,
                    'tgl_absensi' => $tgl_absensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'location_in' => $lokasi,
                ];
                $post = DB::table('absensis')->insert($data_masuk);
                if ($post) {
                    echo 'success|Thank you, happy working!|in';
                    Storage::put($file, $image_base64);
                } else {
                    echo 'error|Oops, data failed to save!|in';
                }
            }
        }
    }

    # Count the Radius
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    # Edit Profile
    public function editProfile()
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $staf = DB::table('pegawais')
            ->where('nik', $nik)
            ->first();
        return view('absensi.edit-profile', compact('staf'));
    }

    public function updateProfile(Request $request)
    {
        $nik = Auth::guard('pegawai')->user()->nik;

        # Get previous photo in database, if photo is not updated
        $getData = DB::table('pegawais')
            ->where('nik', $nik)
            ->first();

        if ($request->hasFile('foto')) {
            $foto = $nik . '.' . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $getData->foto;
        }

        if (!empty($request->password)) {
            $post = [
                'nik_pegawai' => $request->nik_pegawai,
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'password' => Hash::make($request->password),
                'foto' => $foto,
            ];
        } else {
            $post = [
                'nik_pegawai' => $request->nik_pegawai,
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'foto' => $foto,
            ];
        }

        $update = DB::table('pegawais')
            ->where('nik', Auth::guard('pegawai')->user()->nik)
            ->update($post);
        if ($update) {
            # Store the updated photo
            if ($request->hasFile('foto')) {
                $folderPath = 'public/uploads/pegawai/';
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()
                ->back()
                ->with(['success' => 'Data berhasil diubah!']);
        } else {
            return redirect()
                ->back()
                ->with(['error' => 'Data gagal diubah!']);
        }
    }

    public function history()
    {
        $monthName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return view('absensi.history', compact('monthName'));
    }

    public function getHistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('pegawai')->user()->nik;

        $history = DB::table('absensis')
            ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_absensi')
            ->get();

        return view('absensi.get-history', compact('history'));
    }

    public function izin()
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $datas = DB::table('pengajuan_izins')
            ->where('nik', $nik)
            ->get();
        return view('absensi.izin', compact('datas'));
    }

    public function createizin()
    {
        return view('absensi.create-izin');
    }

    public function storeizin(Request $request)
    {
        $post = DB::table('pengajuan_izins')->insert([
            'nik' => Auth::guard('pegawai')->user()->nik,
            'tgl_izin' => $request->tgl_izin,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'status_approved' => 0,
        ]);

        if ($post) {
            return redirect()
                ->route('absensi-izin')
                ->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect()
                ->route('absensi-izin')
                ->with(['error' => 'Data gagal disimpan!']);
        }
    }

    public function cekabsensi()
    {
        return view('absensi.cekabsensi');
    }

    public function cekdata(Request $request)
    {
        $tanggal = $request->tanggal;
        $absensi = DB::table('absensis')
            ->select('absensis.*', 'nama_lengkap', 'nama_pd')
            ->join('pegawais', 'absensis.nik', '=', 'pegawais.nik')
            ->join('pd', 'pegawais.id_pd', '=', 'pd.id_pd')
            ->where('tgl_absensi', $tanggal)
            ->get();
        return view('absensi.cekdata', compact('absensi'));
    }
    public function showmap(Request $request)
    {
        $id = $request->id;
        $absensi = DB::table('absensis')
            ->where('id', $id)
            ->join('pegawais', 'absensis.nik', '=', 'pegawais.nik')
            ->first();
        return view('absensi.showmap', compact('absensi'));
    }

    public function laporan()
    {
        $monthName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $pegawai = DB::table('pegawais')
            ->orderBy('nama_lengkap')
            ->get();
        return view('absensi.laporan', compact('monthName', 'pegawai'));
    }

    public function printlaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $monthName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $pegawai = DB::table('pegawais')
            ->where('nik', $nik)
            ->join('pd', 'pegawais.id_pd', '=', 'pd.id_pd')
            ->first();

        $absensi = DB::table('absensis')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
            ->orderBy('tgl_absensi')
            ->get();

        return view('absensi.printlaporan', compact('bulan', 'tahun', 'monthName', 'pegawai', 'absensi'));
    }
    public function laporanabsensi()
    {
        $monthName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('absensi.laporanabsensi', compact('monthName'));
    }
    public function printlaporanabsen(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $printabsensi = DB::table('absensis')
            ->selectRaw(
                'absensis.nik,nik_pegawai,nama_lengkap,
        max(if(day(tgl_absensi) = 1,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_1,
        max(if(day(tgl_absensi) = 2,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_2,
        max(if(day(tgl_absensi) = 3,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_3,
        max(if(day(tgl_absensi) = 4,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_4,
        max(if(day(tgl_absensi) = 5,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_5,
        max(if(day(tgl_absensi) = 6,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_6,
        max(if(day(tgl_absensi) = 7,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_7,
        max(if(day(tgl_absensi) = 8,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_8,
        max(if(day(tgl_absensi) = 9,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_9,
        max(if(day(tgl_absensi) = 10,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_10,
        max(if(day(tgl_absensi) = 11,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_11,
        max(if(day(tgl_absensi) = 12,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_12,
        max(if(day(tgl_absensi) = 13,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_13,
        max(if(day(tgl_absensi) = 14,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_14,
        max(if(day(tgl_absensi) = 15,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_15,
        max(if(day(tgl_absensi) = 16,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_16,
        max(if(day(tgl_absensi) = 17,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_17,
        max(if(day(tgl_absensi) = 18,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_18,
        max(if(day(tgl_absensi) = 19,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_19,
        max(if(day(tgl_absensi) = 20,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_20,
        max(if(day(tgl_absensi) = 21,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_21,
        max(if(day(tgl_absensi) = 22,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_22,
        max(if(day(tgl_absensi) = 23,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_23,
        max(if(day(tgl_absensi) = 24,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_24,
        max(if(day(tgl_absensi) = 25,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_25,
        max(if(day(tgl_absensi) = 26,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_26,
        max(if(day(tgl_absensi) = 27,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_27,
        max(if(day(tgl_absensi) = 28,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_28,
        max(if(day(tgl_absensi) = 29,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_29,
        max(if(day(tgl_absensi) = 30,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_30,
        max(if(day(tgl_absensi) = 31,concat(jam_in,"-",ifnull(jam_out,"00:00:00")),"")) as tgl_31',
            )
            ->join('pegawais', 'absensis.nik', '=', 'pegawais.nik')
            ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
            ->groupByRaw('absensis.nik,nik_pegawai,nama_lengkap')
            ->get();

        if (isset($_POST['exportexcel'])) {
            $date = date('d-m-Y');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=Laporan absen $date.xls");
            header("Cache-Control: max-age=0");
        }

        //dd($printabsensi);
        return view('absensi.printlaporanabsen', compact('printabsensi'));
    }

    public function izinadmin()
    {
        $izinsakit = DB::table('pengajuan_izins')
            ->join('pegawais', 'pengajuan_izins.nik', '=', 'pegawais.nik')
            ->orderBy('tgl_izin', 'desc')
            ->get();
        return view('absensi.izinadmin', compact('izinsakit'));
    }
    public function approved(Request $request)
    {
        $status_approved = $request->status_approved;
        $id_izin_form = $request->id_izin_form;
        $approved = DB::table('pengajuan_izins')
            ->where('id', $id_izin_form)
            ->update([
                'status_approved' => $status_approved,
            ]);
        if ($approved) {
            return Redirect::back()->with(['success' => 'Success']);
        } else {
        }
        return Redirect::back()->with(['error' => 'Gagal']);
    }

    public function batalapprove($id)
    {
        $approved = DB::table('pengajuan_izins')
            ->where('id', $id)
            ->update([
                'status_approved' => 0,
            ]);
        if ($approved) {
            return Redirect::back()->with(['success' => 'Success']);
        } else {
        }
        return Redirect::back()->with(['error' => 'Gagal']);
    }
}
