<style>
    #map {
        height: 500px;
    }
</style>
<div id="map"></div>
<script>
    var lokasi = "{{ $absensi->location_in }}";
    var lok = lokasi.split(",");
    var lat = lok[0];
    var long = lok[1];
    var map = L.map('map').setView([lat, long], 16);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([lat, long]).addTo(map);
    var circle = L.circle([-6.517376559500617, 108.2057859], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 110
    }).addTo(map);
    var popup = L.popup()
        .setLatLng([lat, long])
        .setContent("{{ $absensi->nama_lengkap }}")
        .openOn(map);
</script>
