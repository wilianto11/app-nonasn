@extends('layouts.mazer.mazer')


@section('content')
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Table Absensi Non ASN</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label>Pilih Tanggal Absensi</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="text" value="{{ date('Y-m-d') }}" class="form-control"
                                            id="tanggal" name="tanggal" value="" placeholder="tanggal" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NIK</th>
                                                <th>Nama Pegawai</th>
                                                <th>Perangkat Daerah</th>

                                                <th>Jam IN</th>
                                                <th>Foto IN</th>
                                                <th>Jam OUT</th>
                                                <th>Foto OUT</th>
                                                <th>Keterangan</th>
                                                <th>Lokasi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="loadAbsensi">

                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Responsive Table -->


    </div>
    <!-- EDIT Modal -->
    <div class="modal fade" id="modal-showmap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title white" id="myModalLabel110">Lokasi Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadmap">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {

            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });

            function loadAbsensi() {
                var tanggal = $('#tanggal').val();
                //alert(tanggal);
                $.ajax({
                    type: 'POST',
                    url: '/cekdata',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                    },
                    success: function(respone) {
                        $("#loadAbsensi").html(respone);
                    }
                });
            }
            $("#tanggal").change(function(e) {
                loadAbsensi();
            });
            loadAbsensi();
        });
    </script>
@endpush
