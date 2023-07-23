@extends('layouts.template')


@section('content')
    <!-- App Header -->
    <div class="appHeader bg-danger text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <div class="row" style="margin-top: 2rem">
        <div class="col ml-2 mr-2">
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
    </div>
    @foreach ($datas as $data)
        <div class="section ">
            <div class="section-title">Data Izin/Sakit</div>
            <div class="card">
                <div class="card-body">
                    <div><b>{{ date('d-m-Y', strtotime($data->tgl_izin)) }}</b>
                        ({{ $data->status == 's' ? 'Sakit' : 'Izin' }})</br>
                        <p>{{ $data->keterangan }}</p>
                    </div>
                    @if ($data->status_approved == 0)
                        <span class="badge badge-warning">Pending</span>
                    @elseif($data->status_approved == 1)
                        <span class="badge badge-success">Approved</span>
                    @elseif($data->status_approved == 2)
                        <span class="badge badge-danger">Rejected</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    <div class="fab-button bottom-right" style="margin-bottom:70px">
        <a href="{{ route('create-izin') }}" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection
