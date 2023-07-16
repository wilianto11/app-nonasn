    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            <img src="assets/img/absensi logo.png" alt="logo" class="logo">
        </div>
        <div class="right">
            <a class="headerButton">
                @if(!empty(Auth::guard('pegawai')->user()->foto))
                @php
                    $path = Storage::url('uploads/pegawai/'.Auth::guard('pegawai')->user()->foto);
                @endphp
                <img src="{{url($path)}}" alt="avatar" class="imaged w40">
                @else
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w38">
                @endif
            </a>
        </div>
    </div>
    <!-- * App Header -->
