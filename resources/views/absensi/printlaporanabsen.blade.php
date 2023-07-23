<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Non PNS {{ date('d-F-y') }}</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: legal landscape
        }

        .sheet.padding-5mm {
            padding: 2mm 10mm 10mm 10mm;
            font-family: Arial, Helvetica, sans-serif;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            font-size: 8px;


        }

        .table th {
            padding: 4px 4px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table td {
            padding: 4px 4px;
            border: 1px solid #000000;
            text-align: center;

        }

        .text-center {
            text-align: center;
        }

        .ttd {
            margin: 25px 20px 75px 100px;
            font-size: 10px;
            float: right
        }

        .fotopem {
            padding-left: 50px;

        }

        img {
            width: 75px;
            height: 75px;

        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="legal landscape">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-5mm">

        <!-- Write HTML just like a web page -->
        <table style="font-family: Arial, Helvetica, sans-serif;vertical-align: top;width:100%">
            <tr>
                <td class="fotopem">
                    <img src="{{ asset('assets/img/icon/bekasi.png') }}" alt="">
                </td>
                <td align=center>

                    <p style="padding-right: 22cm; font-size: 12px;valign:top">PEMERINTAH KABUPATEN BEKASI<br>
                        <b style="font-size: 16px">SEKRETARIAT DAERAH</b><br>
                        Komplek Perkantoran Pemerintah Kabupaten Bekasi<br>
                        di Desa Sukamahi Kecamatan Cikarang Pusat <br>
                        <b> BEKASI</b>
                    </p>
                </td>
            </tr>
        </table>
        <hr style="border-bottom: 1px solid black">
        <table class="table">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Lengkap</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">Jml Hadir</th>
                <th rowspan="2">Jml Tlt</th>
            </tr>
            <tr>
                <?php
                for ($i=1; $i <= 31 ; $i++) {
                ?><th>{{ $i }}</th>
                <?php
                }
               ?>
            </tr>
            @foreach ($printabsensi as $item)
                <tr>

                    <td>{{ $item->nik_pegawai }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <?php
            $totalhadir = 0;
            $totaltelat = 0;
                for ($i=1; $i <= 31 ; $i++) {
                    $tanggal = "tgl_".$i;
                    if (empty($item->$tanggal)) {
                        $h = ['',''];
                        $totalhadir += 0;
                    }else {
                        $h = explode("-",$item->$tanggal);
                        $totalhadir += 1;
                        if ($h[0]>"07:30:00") {
                            $totaltelat += 1;
                        }
                    }
                ?>
                    <td>
                        <span
                            style="color:{{ $h[0] > '07:30:00' ? 'red' : '' }}">{{ !empty($h[0]) ? $h[0] : 'null' }}</span><br>
                        <span style="color:{{ $h[1] < '15:30:00' ? 'red' : '' }}">{{ $h[1] }}</span><br>
                    </td>
                    <?php
                }
               ?>
                    <td>{{ $totalhadir }}</td>
                    <td>{{ $totaltelat }}</td>




                </tr>
            @endforeach
        </table>

        <table class="ttd">
            <tr>
                <td>
                    Cikarang Pusat: {{ date('d-F-Y') }}
                </td>
            </tr>
            <tr>
                <td>
                    KEPALA BAGIAN UMUM SETDA<br>
                    KABUPATEN BEKASI
                </td>
            </tr>
            <tr>
                <td style="height: 20mm;vertical-align:bottom">
                    KHAERUL HAMID, S.H.,M.M.
                </td>
            </tr>
            <tr>
                <td>Pembina IV/a</td>
            </tr>
            <tr>
                <td>
                    NIP.19880718 200701 1 001
                </td>
            </tr>
        </table>




    </section>

</body>

</html>
