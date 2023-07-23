@extends('layouts.mazer.mazer')
@section('content')
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Table Perangkat Daerah</h4>
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
                            <form action="/perangkatdaerah" method="GET" class="mb-2">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-search fs-4 lh-0"></i></span>
                                    <input type="text" name="nama_pd" id="nama_pd" class="form-control"
                                        placeholder="Nama Perangkat Daerah" aria-label="Nama Perangkat Daerah"
                                        aria-describedby="basic-icon-default-email2" />
                                </div>

                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID PERANGKAT DAERAH</th>
                                        <th>PERANGKAT DAERAH</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pd as $data)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{ $data->id_pd }}</th>
                                            <th>{{ $data->nama_pd }}</th>

                                            <th>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="edit" id="dropdown-item" href="#"
                                                            id_pd="{{ $data->id_pd }}"><i class="bi bi-pencil-square"></i>
                                                            Edit</a>
                                                        <form action="/perangkatdaerah/{{ $data->id_pd }}/delete"
                                                            method="POST">
                                                            @csrf
                                                            <a class="delete" id="dropdown-item"><i class="bi bi-trash"></i>
                                                                Delete</a>
                                                        </form>
                                                    </div>
                                                </div>
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
    <!--/ Responsive Table -->



    <!--Modal Large-->
    <!-- Large Modal -->
    <div class="modal fade text-left" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Tambah Perangkat Daerah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/perangkatdaerah/createstore" method="POST" id="frmPd">
                        @csrf
                        <div class="row g-2">
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="nik" class="form-label">ID Perangkat Daerah</label>
                                    <input type="text" id="id_pd" name="id_pd" class="form-control"
                                        placeholder="ID Perangkat Daerah" />
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="nama_pd" class="form-label">Perangkat Daerah</label>
                                    <input type="text" id="nama_pd" name="nama_pd" class="form-control"
                                        placeholder="Perangkat Daerah" />
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT Modal -->
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Edit Perangkat Daerah</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
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
                var id_pd = $(this).attr('id_pd');
                $.ajax({
                    type: 'POST',
                    url: '/perangkatdaerah/editpd',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_pd: id_pd
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
            });

            $("#frmPd").submit(function() {
                var id_pd = $("#id_pd").val();
                var nama_pd = $("#nama_pd").val();
                if (id_pd == null || id_pd == "") {
                    alert('ID Harus Diisi');
                    $("#id_pd").focus();
                    return false;
                }


            });
        });
    </script>
@endpush
