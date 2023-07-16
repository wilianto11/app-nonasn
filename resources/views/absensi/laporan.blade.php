@extends('layouts.mazer.mazer')
@section('content')
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Absensi Pegawai Non ASN</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="/absensi/printlaporan" target="_blank" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-4 mt-3">
                                        <div class="form-group">
                                            <select name="bulan" id="bulan" class="form-select form-select-sm">
                                                <option value="">Bulan</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ date('m') == $i ? 'selected' : '' }}>{{ $monthName[$i] }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="tahun" id="tahun" class="form-select form-select-sm">
                                                <option value="">Tahun</option>
                                                @php
                                                    $startYear = 2022;
                                                    $endYear = date('Y');
                                                @endphp
                                                @for ($tahun = $startYear; $tahun <= $endYear; $tahun++)
                                                    <option value="{{ $tahun }}"
                                                        {{ date('Y') == $tahun ? 'selected' : '' }}>{{ $tahun }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="nik" id="nik" class="form-select form-select-sm">
                                                <option value="">Pilih Karyawan</option>
                                                @foreach ($pegawai as $item)
                                                    <option value="{{ $item->nik }}">{{ $item->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3" style="padding-left: 70px">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-secondary">
                                                <span class="bi bi-printer-fill"> -Print-</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
