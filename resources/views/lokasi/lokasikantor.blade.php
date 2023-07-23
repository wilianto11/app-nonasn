@extends('layouts.mazer.mazer')
@section('content')
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">


                        @if (Session::get('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}

                            </div>
                        @endif
                        @if (Session::get('error'))
                            <div class="alert alert-danger" role="alert">

                                {{ Session::get('error') }}

                            </div>
                        @endif
                        <h5 class="card-header">Update Lokasi Kantor</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <form action="/lokasi/updatelokasi" method="POST">
                                @csrf
                                <div class="col-sm-6">
                                    <h6>Lokasi Kantor/lat,long</h6>
                                    <div class="form-group position-relative has-icon-right">
                                        <input type="text" name="lokasi_kantor" id="lokasi_kantor"
                                            value="{{ $lokasi_kantor->lokasi_kantor }}" class="form-control"
                                            placeholder="lat,long">
                                        <div class="form-control-icon">
                                            <i class="bi bi-bookmarks"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h6>Radius/m</h6>
                                    <div class="form-group position-relative has-icon-right">
                                        <input type="text" name="radius" id="radius"
                                            value="{{ $lokasi_kantor->radius }}" class="form-control" placeholder="Radius">
                                        <div class="form-control-icon">
                                            <i class="bi bi-bookmarks"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="demo-inline-spacing">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="tf-icons bx bx-pie-chart-alt"></span>Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
