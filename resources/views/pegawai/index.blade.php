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


            </div>
            <div class="card-body">
                <div class="mt-3">
                    <button style="float: right" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#largeModal">
                        +
                    </button>
                </div>
                <div class="col-6">
                    <form action="/pegawai" method="GET" class="mb-2">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-search fs-4 lh-0"></i></span>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                placeholder="Search...." aria-label="Search...."
                                aria-describedby="basic-icon-default-email2" />
                        </div>

                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIK</th>
                                <th>NAMA LENGKAP</th>
                                <th>JENIS KELAMIN</th>
                                <th>TANGGAL LAHIR</th>
                                <th>PERANGKAT DAERAH</th>
                                <th>BAGIAN</th>
                                <th>NO.HP</th>
                                <th>FOTO</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $data)
                                @php
                                    $path = Storage::url('uploads/pegawai/' . $data->foto);
                                @endphp
                                <tr>
                                    <th>{{ $loop->iteration + $pegawai->firstItem() - 1 }}</th>
                                    <th>{{ $data->nik_pegawai }}</th>
                                    <th>{{ $data->nama_lengkap }}</th>
                                    <th>{{ $data->nama_kelamin }}</th>
                                    <th>{{ $data->tgl_lahir }}</th>
                                    <th>{{ $data->nama_pd }}</th>
                                    <th>{{ $data->bagian }}</th>
                                    <th>{{ $data->no_telp }}</th>
                                    <th>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            @if (empty($data->foto))
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" class="avatar avatar-x pull-up"
                                                    title="wilianto">
                                                    <img src="{{ asset('assets/img/wili.png') }}" alt="avatar"
                                                        class="rounded-circle">
                                                </li>
                                            @else
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" class="avatar avatar-x pull-up"
                                                    title="wilianto">
                                                    <img src="{{ url($path) }}" alt="avatar" class="rounded-circle">
                                                </li>
                                            @endif
                                        </ul>
                                    </th>
                                    <th>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="edit" id="dropdown-item" href="#"
                                                    nik="{{ $data->nik }}"><i class="bx bx-edit me-1"></i> Edit</a>
                                                <form action="/pegawai/{{ $data->nik }}/hapus" method="POST" >
                                                    @csrf

                                                    <a class="delete" id="dropdown-item"
                                                    ><i
                                                        class="bx bx-trash me-1"></i> Delete</a>
                                                </form>
                                            </div>
                                        </div>
                                    </th>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $pegawai->links('pagination::bootstrap-5') }}
            </div>
        </div>
        </div>
    </div>
</section>
        <!--/ Responsive Table -->


    </div>
    <!--Modal Large-->
    <!-- Large Modal -->
    <div class="modal fade text-left" id="largeModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
    role="document">
    <div class="modal-content">
        <div class="modal-header bg-success">
            <h5 class="modal-title white" id="myModalLabel110">Tambah pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/pegawai/store" method="POST" id="frmPegawai" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="nik_pegawai" class="form-label">NIK</label>
                                <input type="text" id="nik_pegawai" name="nik_pegawai" class="form-control"
                                    placeholder="NIK" />
                            </div>
                            <div class="col mb-0">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                                    placeholder="Nama Lengkap" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="user_name" class="form-label">Username</label>
                                <input type="text" id="user_name" name="user_name" class="form-control"
                                    placeholder="username" />
                            </div>

                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="id_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="id_kelamin" id="id_kelamin" class="form-select">
                                    <option>Jenis Kelamin</option>
                                    @foreach ($jenis_kelamin as $data)
                                        <option {{ Request('id_kelamin') == $data->id_kelamin ? 'selected' : '' }}
                                            value="{{ $data->id_kelamin }}">{{ $data->nama_kelamin }}</option>
                                    @endforeach


                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                    placeholder="tgl_lahir" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="id_pd" class="form-label">Perangkat Daerah</label>
                                <select name="id_pd" id="id_pd" class="form-select">
                                    <option>Perangkat Daerah</option>
                                    @foreach ($pd as $data)
                                        <option {{ Request('id_pd') == $data->id_pd ? 'selected' : '' }}
                                            value="{{ $data->id_pd }}">{{ $data->nama_pd }}</option>
                                    @endforeach


                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="bagian" class="form-label">Bagian</label>
                                <input type="text" id="bagian" name="bagian" class="form-control"
                                    placeholder="Bagian" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="no_telp" class="form-label">No Telp</label>
                                <input type="text" id="no_telp" name="no_telp" class="form-control"
                                    placeholder="+62" />
                            </div>
                            <div class="col mb-0">
                                <label for="foto" class="form-label">Uploads Foto</label>
                                <input class="form-control" type="file" id="foto" name="foto" />
                            </div>
                        </div>
                        <div class="row g-2">

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-success ml-1">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT Modal -->
    <div class="modal fade  text-left" id="editModal"tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel110" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
    role="document">
    <div class="modal-content">
        <div class="modal-header bg-success">
            <h5 class="modal-title white" id="myModalLabel110">Edit pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditform">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $(".edit").click(function() {
                var nik = $(this).attr('nik');
                $.ajax({
                    type: 'POST',
                    url: '/pegawai/editpegawai',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nik: nik
                    },
                    success: function(respone) {
                        $("#loadeditform").html(respone);
                    }
                });
                $("#editModal").modal("show");
            });
            $(".delete").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })

            $("#frmPegawai").submit(function() {
                var nik = $("#nik").val();
                var nama_lengkap = $("#nama_lengkap").val();
                var id_pd = $("frmPegawai").find("#id_pd").val();
                var bagian = $("#bagian").val();
                var no_telp = $("#no_telp").val();
                var foto = $("#foto").val();
                if (nik == "") {
                    alert('NIK Harus Diisi');
                    $("#nik").focus();
                    return false;
                } else if (bagian == "") {
                    alert('Bagian Harus Diisi');
                    $("#bagian").focus();
                    return false;
                } else if (no_telp == "") {
                    alert('No Telp Harus Diisi');
                    $("#no_telp").focus();
                    return false;
                } else if (id_pd == "") {
                    alert('Perangkat Daerah Harus Diisi');
                    $("#id_pd").focus();
                    return false;
                }


            });
        });
    </script>
@endpush
