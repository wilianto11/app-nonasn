<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hari_ini = date("Y-m-d");
        $bulan_ini = date("m")*1;
        $tahun_ini = date("Y");
        $nik = Auth::guard('pegawai')->user()->nik;
        $todayPresence = DB::table('absensis')->where([['tgl_absensi',date('Y-m-d')],['nik',Auth::guard('pegawai')->user()->nik]])->first();
        $historyPerMonth = DB::table('absensis')
            ->whereRaw('MONTH(tgl_absensi)="'.date('m').'"')
            ->whereRaw('YEAR(tgl_absensi)="'.date('Y').'"')
            ->where('nik',Auth::guard('pegawai')->user()->nik)
            ->orderBy('tgl_absensi','DESC')
            ->get();
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $yearNow = date('Y');

        # Recap data absensi
        $recapData = DB::table('absensis')->selectRaw('COUNT(nik) as sum_presence, SUM(IF(jam_in > "07:00",1,0)) as sum_late')
            ->where('nik',Auth::guard('pegawai')->user()->nik)
            ->whereRaw('MONTH(tgl_absensi)="'.date('m').'"')
            ->whereRaw('YEAR(tgl_absensi)="'.date('Y').'"')
            ->first();

        # Leaderboard
        $leaderBoard = DB::table('absensis')->leftJoin('pegawais','pegawais.nik','=','absensis.nik')->where('absensis.tgl_absensi',date('Y-m-d'))->get();

        #rekapizin
        $recapizin = DB::table('pengajuan_izins')->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')->where('nik', $nik)->whereRaw('MONTH(tgl_izin)="'. $bulan_ini .'"')->whereRaw('YEAR(tgl_izin)="'. $tahun_ini .'"')->where('status_approved',1) ->first();

        return view('dashboard.index', compact('todayPresence','historyPerMonth','monthName','yearNow','recapData','leaderBoard','recapizin'));
    }
    public function adminindex(){
        # Recap data absensi
        $hari_ini = date("Y-m-d");
        $recapData = DB::table('absensis')
        ->selectRaw('COUNT(nik) as sum_presence, SUM(IF(jam_in > "08:00",1,0)) as sum_late')
            ->where('tgl_absensi', $hari_ini)
            ->first();

        $recapizin = DB::table('pengajuan_izins')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')->where('tgl_izin', $hari_ini)->where('status_approved',1)->first();

        return view('dashboard.adminindex', compact('recapData','recapizin'));
    }

    public function eror404(){
        return view('dashboard.404');
    }
}
