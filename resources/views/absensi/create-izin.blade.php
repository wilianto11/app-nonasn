@extends('layouts.template')

<style type="text/css">
    .datepicker {
        font-size: 1em;
    }

    table.table-condensed {
        margin-top: 20px !important;
    }

    /* solution 2: the original datepicker use 20px so replace with the following:*/

    .datepicker td,
    .datepicker th {
        width: 1.5em;
        height: 1.5em;
    }
</style>

@section('content')
    <!-- App Header -->
    <div class="appHeader bg-info teks-light">
        <div class="left">
            <a href="/dashboard" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Absensi Non ASN
        </div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->
    <div class="section mt-2 mb-2">
        <div class="section-title">Form Izin</div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('store-izin') }}" method="POST" class="ml-2 mr-2" id="formIzin">
                    @csrf
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="tgl_izin">Tanggal Izin</label>
                            <input type="text" name="tgl_izin" id="tgl_izin" data-date-format="yyyy/mm/dd"
                                class="form-control datepicker" placeholder=" Tanggal">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="status">Izin/Sakit</label>
                            <select name="status" id="status" class="form-control custom-select">
                                <option value="" class="text-muted">- Pilih -</option>
                                <option value="i">Izin</option>
                                <option value="s">Sakit</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"
                                placeholder="Tulis keterangan"></textarea>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <button class="btn btn-primary w-100">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $('.datepicker').datepicker({
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker').datepicker("setDate", new Date());

        $('#formIzin').submit(function() {
            var tgl_izin = $('#tgl_izin').val();
            var status = $('#status').val();
            var keterangan = $('#keterangan').val();

            if (tgl_izin == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Tanggal harus diisi',
                    icon: 'warning'
                });
                return false;
            } else if (status == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Jenis izin harus diisi',
                    icon: 'warning'
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Keterangan harus diisi',
                    icon: 'warning'
                });
                return false;
            }
        });
    </script>
@endpush
