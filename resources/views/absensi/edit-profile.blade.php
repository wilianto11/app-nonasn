@extends('layouts.template')





@section('content')
    <!-- App Header -->
    <div class="appHeader bg-success text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profile</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <div class="section mt-2">
        <div class="row" style="margin-top: 4rem;">
            <div class="col">
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                @if (Session::get('error'))
                    <div class="alert alert-danger">
                        {{Session::get('error')}}
                    </div>
                @endif
            </div>
        </div>
        <div class="section-title">Edit Profile</div>
        <div class="card">
            <div class="card-body">

                <form action="/update/{{$staf->nik}}/profile" method="POST" enctype="multipart/form-data" class="ml-2 mr-2">
                    @csrf
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="user_name">NIK</label>
                            <input type="text" name="nik_pegawai" class="form-control" value="{{$staf->nik_pegawai}}" id="nik_pegawai" placeholder="User Name">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="user_name">User Name</label>
                            <input type="text" name="user_name" class="form-control" value="{{$staf->user_name}}" id="user_name" placeholder="User Name">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{$staf->nama_lengkap}}" id="nama_lengkap" placeholder="nama lengkap">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="no_telp">No Telp</label>
                            <input type="text" name="no_telp" value="{{$staf->no_telp}}" class="form-control" id="no_telp" placeholder="No telp">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="no_password">Password</label>
                            <input type="text" name="password" value="" class="form-control" id="no_password" placeholder="Password">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="custom-file-upload" id="fileUpload1">
                        <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                        <label for="fileuploadInput">
                            <span>
                                <strong>
                                    <ion-icon name="arrow-up-circle-outline"></ion-icon>
                                    <i>Upload a Photo</i>
                                </strong>
                            </span>
                        </label>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <button type="submit" class="btn btn-primary btn-block">
                                <ion-icon name="refresh-outline"></ion-icon>
                                Update
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

