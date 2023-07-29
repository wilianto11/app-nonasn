<?php
function selisih($jam_masuk, $jam_keluar)
{
    [$h, $m, $s] = explode(':', $jam_masuk);
    $dtAwal = mktime($h, $m, $s, '1', '1', '1');
    [$h, $m, $s] = explode(':', $jam_keluar);
    $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
    $dtselisih = $dtAkhir - $dtAwal;
    $totalmenit = $dtselisih / 60;
    $jam = explode('.', $totalmenit / 60);
    $sisamenit = $totalmenit / 60 - $jam[0];
    $sisamenit2 = $sisamenit = 60;
    $jml_jam = $jam[0];
    return $jml_jam . ':' . round($sisamenit2);
}
?>
@foreach ($absensi as $item)
    @php
        $foto_in = Storage::url('uploads/absensi/' . $item->foto_in);
        $foto_out = Storage::url('uploads/absensi/' . $item->foto_out);
    @endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nik_pegawai }}</td>
        <td>{{ $item->nama_lengkap }}</td>
        <td>{{ $item->nama_pd }}</td>
        <td>{{ $item->jam_in }}</td>
        <td>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                @if (empty($item->foto_in))
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar avatar-x pull-up" title="wilianto">
                        <img src="{{ asset('assets/img/camoff.png') }}" alt="avatar"
                            class="rounded-circle d-flex align-items-center">
                    </li>
                @else
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar avatar-x pull-up" title="wilianto">
                        <img src="{{ url($foto_in) }}" alt="avatar" class="rounded-circle">
                    </li>
                @endif
            </ul>
        </td>
        <td>{!! $item->jam_out != null ? $item->jam_out : '<span class="badge bg-label-warning">Belum Absen</span>' !!}</td>
        <td>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                @if ($item->jam_out != null)
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar avatar-x pull-up" title="wilianto">
                        <img src="{{ url($foto_out) }}" alt="avatar" class="rounded-circle">
                    </li>
                @else
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar avatar-x pull-up" title="wilianto">
                        <img src="{{ asset('assets/img/camoff.png') }}" alt="avatar"
                            class="rounded-circle d-flex align-items-center">
                    </li>
                @endif
            </ul>
        </td>
        <td>
            @if ($item->jam_in >= '07:30:00')
                @php
                    $telat = selisih('07:30:00', $item->jam_in);
                @endphp
                <button type="button" class="btn btn-danger">Terlambat <span
                        class="badge bg-transparent">{{ $telat }}</span></button>
            @else
                <button type="button" class="btn btn-success">Tepat Waktu</button>
            @endif
        </td>
        <td>
            <a href="#" class="btn rounded-pill btn-icon btn-primary showmap" id="{{ $item->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    style="fill: rgb(252, 250, 250);transform: ;msFilter:;">
                    <path
                        d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z">
                    </path>
                    <path
                        d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z">
                    </path>
                </svg>
            </a>
        </td>


    </tr>
@endforeach
<script>
    $(function() {
        $(".showmap").click(function(e) {
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/showmap',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(respone) {
                    $("#loadmap").html(respone);
                }
            })
            $("#modal-showmap").modal("show");
        });
    });
</script>
