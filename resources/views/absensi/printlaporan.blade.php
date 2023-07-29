
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Absensi {{ $pegawai->nama_lengkap }} {{ date('d-F-y') }}</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
  @page { size: legal
}
.sheet.padding-5mm{
    padding:5mm 10mm 10mm 10mm ;
    font-family: Arial, Helvetica, sans-serif;
}
    .table {
        border-collapse: collapse;
        width: 100%;


    }

    .table th {
        padding: 8px 8px;
        border:1px solid #000000;
        text-align: center;
    }

    .table td {
        padding: 4px 4px;

    }

    .text-center {
        text-align: center;
    }
    .ttd{
        margin: 25px 20px 75px 100px;

    }
</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="legal">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-5mm">

    <!-- Write HTML just like a web page -->
    <table style="font-family: Arial, Helvetica, sans-serif;vertical-align: top;width:100%">
        <tr >
            <td>
                <img style="padding-left: 20px" src="{{ asset('assets/img/icon/bekasi.png') }}" width="130px" height="130px" alt="" >
            </td>
            <td align=center >

                <p  style="padding-right: 50px; font-size: 20px;valign:top">PEMERINTAH KABUPATEN BEKASI<br>
                <b style="font-size: 26px">SEKRETARIAT DAERAH</b><br>
                Komplek Perkantoran Pemerintah Kabupaten Bekasi<br>
                di Desa Sukamahi Kecamatan Cikarang Pusat <br>
                <b> BEKASI</b></p>
            </td>
        </tr>
    </table>
    <hr style="border-bottom: 5px solid black">
    <table class="table">
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $pegawai->nik_pegawai }}</td>
            <td style="padding-left: 150px">Perangkat Daerah</td>
            <td>:</td>
            <td>{{ $pegawai->nama_pd }}</td>

        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $pegawai->nama_lengkap }}</td>
            <td style="padding-left: 150px">Bagian</td>
            <td>:</td>
            <td>{{ $pegawai->bagian }}</td>
        </tr>
    </table>
    <h3 style="margin-top: 70px;font-family: Arial, Helvetica, sans-serif">LAPORAN ABSENSI NON ASN</h3>
    <table  class="table" style="margin-top: 10px;text-align:center" border="1px solid">
        <thead>
        <tr style="background-color: AliceBlue; font-weight:bold">
            <td>#</td>
            <td>Tanggal</td>
            <td>Jam Masuk</td>
            <td>Jam Pulang</td>
            <td>Keterangan</td>
        </tr>
    </thead>
        @foreach ($absensi as $item)
        <tbody>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('Y-m-d',strtotime($item->tgl_absensi)) }}</td>
                <td>{{ $item->jam_in }}</td>
                <td>{{ $item->jam_out }}</td>
                <td>
                    @if ($item->jam_in > '07:30')
                        Terlambat
                        @else
                        Tepat Waktu
                    @endif
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
    <table class="ttd" style="float: right">
        <tr>
            <td >
                Cikarang Pusat: {{ date('d-F-Y') }}
            </td>
        </tr>
        <tr>
            <td >
                KEPALA BAGIAN UMUM
            </td>
        </tr>
        <tr>
            <td style="height: 27mm;vertical-align:bottom">
               KHAERUL HAMID.S.IP.,M.M
            </td>
        </tr>
        <tr>
            <td>Pembina IV.a</td>
        </tr>
        <tr>
            <td>
                NIP.198807182006041006
            </td>
        </tr>
    </table>




  </section>

</body>

</html>

