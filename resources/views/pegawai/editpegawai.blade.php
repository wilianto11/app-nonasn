<form action="/pegawai/{{ $pegawai->nik }}/updatepegawai" method="POST" id="frmPegawai" enctype="multipart/form-data">
    @csrf
    <div class="row g-2">
        <div class="col mb-0">
            <label for="nik_pegawai" class="form-label">NIK</label>
            <input type="text" value="{{ $pegawai->nik_pegawai }}" id="nik_pegawai" name="nik_pegawai"
                class="form-control" />
        </div>
        <div class="col mb-0">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" value="{{ $pegawai->nama_lengkap }}" id="nama_lengkap" name="nama_lengkap"
                class="form-control" />
        </div>
    </div>
    <div class="row g-2">
        <div class="col mb-0">
            <label for="user_name" class="form-label">Username</label>
            <input type="text" id="user_name" value="{{ $pegawai->user_name }}" name="user_name" class="form-control"
                placeholder="username" />
        </div>

    </div>
    <div class="row g-2">
        <div class="col mb-0">
            <label for="id_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="id_kelamin" id="id_kelamin" class="form-select">
                <option>Jenis Kelamin</option>
                @foreach ($jenis_kelamin as $data)
                    <option {{ $pegawai->id_kelamin == $data->id_kelamin ? 'selected' : '' }}
                        value="{{ $data->id_kelamin }}">{{ $data->nama_kelamin }}</option>
                @endforeach


            </select>
        </div>
        <div class="col mb-0">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="text" value="{{ $pegawai->tgl_lahir }}" id="tgl_lahir" name="tgl_lahir"
                class="form-control" />
        </div>
    </div>
    <div class="row g-2">
        <div class="col mb-0">
            <label for="id_pd" class="form-label">Perangkat Daerah</label>
            <select name="id_pd" id="id_pd" class="form-select">
                <option>Perangkat Daerah</option>
                @foreach ($pd as $data)
                    <option {{ $pegawai->id_pd == $data->id_pd ? 'selected' : '' }} value="{{ $data->id_pd }}">
                        {{ $data->nama_pd }}</option>
                @endforeach


            </select>
        </div>
        <div class="col mb-0">
            <label for="bagian" class="form-label">Bagian</label>
            <input type="text" value="{{ $pegawai->bagian }}" id="bagian" name="bagian" class="form-control" />
        </div>
    </div>
    <div class="row g-2">
        <div class="col mb-0">
            <label for="no_telp" class="form-label">No Telp</label>
            <input type="text" value="{{ $pegawai->no_telp }}" id="no_telp" name="no_telp" class="form-control" />
        </div>
        <div class="col mb-0">
            <label for="foto" class="form-label">Uploads Foto</label>
            <input class="form-control" type="file" id="foto" name="foto" />
            <input type="hidden" name="foto_dulu" value="{{ $pegawai->foto }}" />
        </div>
    </div>
    <div class="row g-2">

        <div class="modal-footer">

            <button type="submit" class="btn btn-success ml-1">Save</button>
        </div>
    </div>
</form>
