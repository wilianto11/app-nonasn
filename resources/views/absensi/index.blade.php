@extends('layouts.template')

@section('content')
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 10px;
        }

        #map {
            height: 180px;
        }
    </style>
    <!-- App Header -->
    <div class="appHeader">
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
    <div class="card-body">
        <div class="row">
            <div class="col">
                <input type="hidden" id="lokasi">
                <div class="webcam-capture"></div>
            </div>
        </div>
        <div class="row">
            <div class="col" style="padding-top: 30px">
                @if ($check > 0)
                    <button id="takeabsen" class="btn btn-info btn-block">
                        <ion-icon name="camera"></ion-icon>Absen Pulang
                    </button>
                @else
                    <button id="takeabsen" class="btn btn-primary btn-block">
                        <ion-icon name="camera"></ion-icon>Absen Masuk
                    </button>
                @endif
            </div>
        </div>
        <div class="row mt-3">
            <div class="col" style="padding-top: 30px">
                <div id="map" class="map"></div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        //var notif_in = document.getElementById('notif_in');
        //var notif_out = document.getElementById('notif_out');
        //var notif_radius = document.getElementById('notif_radius');

        Webcam.set({
            height: 480,
            width: 480,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            var lokasi_kantor = "{{ $lokasi_kantor->lokasi_kantor }}";
            var lok = lokasi_kantor.split(",");
            var lat_kantor = lok[0];
            var long_kantor = lok[1];
            var radius = "{{ $lokasi_kantor->radius }}";
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            //-6.517376559500617, 108.2057859
            var circle = L.circle([lat_kantor, long_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        function errorCallback() {

        }

        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });
            var lokasi = $('#lokasi').val();
            $.ajax({
                type: "POST",
                url: "/camera-snap",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split('|');
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            //
                        } else {
                            //
                        }
                        Swal.fire({
                            title: 'Success!',
                            text: status[1],
                            icon: 'success'
                        })
                        setTimeout("location.href='/dashboard'", 2500);
                    } else {
                        if (status[2] == "radius") {
                            //
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error'
                        })
                    }
                }
            });
        });
    </script>
@endpush
