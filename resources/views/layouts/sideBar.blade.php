 <!-- App Sidebar -->
 <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-body p-0">
                 <!-- profile box -->
                 <div class="profileBox pt-2 pb-2">
                     <div class="image-wrapper">
                         @if (!empty(Auth::guard('pegawai')->user()->foto))
                             @php
                                 $path = Storage::url('uploads/pegawai/' . Auth::guard('pegawai')->user()->foto);
                             @endphp
                             <img src="{{ url($path) }}" alt="avatar" class="imaged w64" style="height:62px;">
                         @else
                             <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged w36">
                         @endif
                     </div>
                     <div class="in">
                         <strong></strong>
                         <div class="text-muted"></div>
                     </div>
                     <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
                         <ion-icon name="close-outline"></ion-icon>
                     </a>
                 </div>
                 <!-- * profile box -->
                 <!-- balance -->
                 <div class="sidebar-balance">
                     <div class="listview-title">{{ Auth::guard('pegawai')->user()->bagian }}</div>
                     <div class="in">
                         <h1 class="amount">{{ Auth::guard('pegawai')->user()->nama_lengkap }}</h1>
                     </div>
                 </div>
                 <!-- * balance -->

                 <!-- action group -->
                 <div class="action-group">

                 </div>
                 <!-- * action group -->

                 <!-- menu -->
                 <div class="listview-title mt-1">Menu</div>
                 <ul class="listview flush transparent no-line image-listview">
                     <li>
                         <a href="{{ route('dashboard') }}"class="item">
                             <div class="icon-box bg-primary">
                                 <ion-icon name="home-outline"></ion-icon>
                             </div>
                             <div class="in">
                                 Dashboard
                             </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('absensi-history') }}" class="item">
                             <div class="icon-box bg-primary">
                                 <ion-icon name="calendar-number-outline"></ion-icon>
                             </div>
                             <div class="in">
                                 History
                             </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('absensi-izin') }}" class="item">
                             <div class="icon-box bg-primary">
                                 <ion-icon name="document-text-outline"></ion-icon>
                             </div>
                             <div class="in">
                                 Izin
                             </div>
                         </a>
                     </li>

                 </ul>
                 <!-- * menu -->

                 <!-- others -->
                 <div class="listview-title mt-1">Others</div>
                 <ul class="listview flush transparent no-line image-listview">
                     <li>
                         <a href="{{ route('edit-profile') }}" class="item">
                             <div class="icon-box bg-primary">
                                 <ion-icon name="settings-outline"></ion-icon>
                             </div>
                             <div class="in">
                                 Settings
                             </div>
                         </a>
                     </li>

                     <li>
                         <a href="{{ route('Logout') }}" id="logout" class="item">
                             <div class="icon-box bg-primary">
                                 <ion-icon name="log-out-outline"></ion-icon>
                             </div>
                             <div class="in">
                                 Log out
                             </div>
                         </a>
                     </li>


                 </ul>
                 <!-- * others -->



             </div>
         </div>
     </div>
 </div>
 <!-- * App Sidebar -->
