@extends('layouts.mazer.mazer')
@section('content')
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Table Pegawai Non ASN</h4>
                    </div>
                    <div class="card-content">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Izin</th>
                                        <th>Izin/Sakit</th>
                                        <th rowspan="2">Keterangan</th>
                                        <th>Status</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($izinsakit as $data)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{ $data->nik }}</th>
                                            <th>{{ $data->nama_lengkap }}</th>
                                            <th>{{ date('d-F-Y', strtotime($data->tgl_izin)) }}</th>
                                            <th>{{ $data->status == 'i' ? 'Izin' : 'Sakit' }}</th>
                                            <th>{{ $data->keterangan }}</th>
                                            <th>
                                                @if ($data->status_approved == 1)
                                                    <span class="badge bg-light-success">Accept</span>
                                                @elseif ($data->status_approved == 2)
                                                    <span class="badge bg-light-danger">Reject</span>
                                                @else
                                                    <span class="badge bg-light-warning">Pending</span>
                                                @endif
                                            </th>
                                            <th>
                                                @if ($data->status_approved == 0)
                                                    <a href="#" id="approved"
                                                        class="approved btn btn-icon btn-primary"
                                                        id_izin="{{ $data->id }}">
                                                        <span class="bi bi-hand-index"></span>
                                                    </a>
                                                @else
                                                    <a href="/absensi/{{ $data->id }}/batalapprove"
                                                        class="btn btn-icon btn-danger">
                                                        <span class="bi bi-x-circle"></span>
                                                    </a>
                                                @endif
                                            </th>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-showaction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-showaction">Approved</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/absensi/approved" method="POST">
                        @csrf
                        <input type="hidden" id="id_izin_form" name="id_izin_form">
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-check mt-3">
                                    <input name="status_approved" class="form-check-input" type="radio" value="1"
                                        id="status_approved" />
                                    <label class="form-check-label" for="defaultRadio1"> Accept </label>
                                </div>
                                <div class="form-check">
                                    <input name="status_approved" class="form-check-input" type="radio" value="2"
                                        id="status_approved" checked />
                                    <label class="form-check-label" for="defaultRadio2"> Reject </label>
                                </div>
                            </div>
                        </div>
                        <div class="col m-3">
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $(".approved").click(function(e) {
                e.preventDefault();
                var id_izin = $(this).attr('id_izin');
                $("#id_izin_form").val(id_izin);
                $("#modal-showaction").modal("show");
            });
        });
    </script>
@endpush
