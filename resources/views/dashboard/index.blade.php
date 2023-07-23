@extends('layouts.template')

@section('content')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            <img src="assets/img/absensi logo.png" alt="logo" class="logo">
        </div>
        <div class="right">
            <a class="headerButton">
                @if (!empty(Auth::guard('pegawai')->user()->foto))
                    @php
                        $path = Storage::url('uploads/pegawai/' . Auth::guard('pegawai')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w40">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w38">
                @endif
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- Wallet Card -->
    <div class="section wallet-card-section pt-1">
        <div class="wallet-card">
            <!-- Balance -->
            <div class="balance">
                <div class="left">
                    <span class="title" style="color:MediumBlue">Bagian {{ Auth::guard('pegawai')->user()->bagian }}</span>
                    <h1 class="total">{{ Auth::guard('pegawai')->user()->nama_lengkap }}</h1>
                </div>

            </div>
            <!-- * Balance -->
            <!-- Wallet Footer -->
            <div class="wallet-footer">
                <div class="col-3">
                    <div class="card bg-success">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-light text-dark"
                                style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">{{ $recapData->sum_presence }}</span>
                            <ion-icon name="checkbox" style="font-size: 1.4rem" class="text-light"></ion-icon><br>
                            <span style="font-size: 0.5rem" class="text-light">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-primary">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-light text-dark"
                                style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">{{ $recapizin->jmlizin }}</span>
                            <ion-icon name="close-circle" style="font-size: 1.4rem" class="text-light"></ion-icon><br>
                            <span style="font-size: 0.5rem" class="text-light">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-warning">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-light text-dark"
                                style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">{{ $recapizin->jmlsakit }}</span>
                            <ion-icon name="sad" style="font-size: 1.4rem" class="text-light"></ion-icon><br>
                            <span class="text-light" style="font-size: 0.5rem">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-danger">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-light text-dark"
                                style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">{{ $recapData->sum_late }}</span>
                            <ion-icon name="timer" style="font-size: 1.4rem" class="text-light"></ion-icon><br>
                            <span class="text-light" style="font-size: 0.5rem">Telat</span>
                        </div>
                    </div>
                </div>

            </div>
            <!-- * Wallet Footer -->
        </div>
    </div>
    <!-- Wallet Card -->
    <!-- Stats -->
    <div class="section">
        <div class="row mt-2">
            <div class="col-6">
                <div class="stat-box">
                    <center>
                        <div class="value text-success">
                            <div class="presencedetail">
                                <h4 class="presencetitle">Masuk</h4>
                                <span
                                    style="font-size: 16px">{{ $todayPresence != null ? $todayPresence->jam_in : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <center>
                        <div class="value text-danger">
                            <div class="presencedetail">
                                <h4 class="presencetitle">Pulang</h4>
                                <span
                                    style="font-size: 16px">{{ $todayPresence != null && $todayPresence->jam_out != null ? $todayPresence->jam_out : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- * Stats -->
    <div class="section">
        <div class="row mt-2">
            <div class="col-6">
                <div class="stat-box">
                    <center>
                        <div class="iconpresence">
                            @if ($todayPresence != null)
                                @php
                                    $path = Storage::url('uploads/absensi/' . $todayPresence->foto_in);
                                @endphp
                                <img src="{{ url($path) }}" alt="avatar" class="imaged w100">
                            @else
                                <a href="{{ route('camera') }}" class="item">
                                    <ion-icon style="font-size: 100px" name="camera"></ion-icon>
                                </a>
                            @endif
                        </div>

                    </center>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <center>
                        <div class="iconpresence">
                            @if ($todayPresence != null && $todayPresence->jam_out != null)
                                @php
                                    $path = Storage::url('uploads/absensi/' . $todayPresence->foto_out);
                                @endphp
                                <img src="{{ url($path) }}" alt="avatar" class="imaged w100">
                            @else
                                <a href="{{ route('camera') }}" class="item">
                                    <ion-icon style="font-size: 97px" name="camera"></ion-icon>
                                </a>
                            @endif
                        </div>

                    </center>
                </div>
            </div>
        </div>
    </div>
@endsection
