<form action="/perangkatdaerah/{{ $pd->id_pd }}/update" method="POST" id="frmPd" >
    @csrf
    <div class="row g-2">
    <div class="row g-2">
        <div class="col mb-0">
            <label for="id_pd" class="form-label">ID Perangkat Daerah</label>
            <input type="text" value="{{ $pd->id_pd }}" id="id_pd" name="id_pd" class="form-control" readonly
                />
        </div>
    </div>
</div>
        <div class="row g-2">
            <div class="row g-2">
        <div class="col mb-0">
            <label class="form-label">Perangkat Daerah</label>
            <input type="text" value="{{ $pd->nama_pd }}" id="nama_pd" name="nama_pd" class="form-control"
                 />
        </div>
            </div>
    </div>

    <div class="row g-2">

        <div class="modal-footer">

            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
