<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>LARAVEL - POS</title>
    <!-- Favicon icon -->
    <link rel="{{ asset('asset') }}/dist/icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('asset') }}/dist/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('asset') }}/dist/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('quixlab/plugins/morris/morris.css') }}">
    <style>
        .nk-sidebar .menu-icon {
            vertical-align: middle !important;
            font-size: 18px !important;
        }

        .nk-sidebar .nav-text {
            vertical-align: middle !important;
            font-size: 16px !important;
            line-height: 1.5 !important;
        }

        .nk-sidebar a {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
    </style>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="index.html" style="display: flex; align-items: center; text-decoration: none;">
                    <b class="logo-abbr" style="font-size: 22px; color: white; font-weight: bold;">POS</b>
                    <span class="logo-compact"
                        style="margin-left: 10px; font-size: 18px; color: white; font-weight: 500;">P.O.S</span>
                    <span class="brand-title"
                        style="margin-left: 10px; font-size: 20px; color: white; font-weight: bold;">
                        POINT OF SALES
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    <div class="input-group icons">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i
                                    class="mdi mdi-magnify"></i></span>
                        </div>
                        <input type="search" class="form-control" placeholder="Search Dashboard"
                            aria-label="Search Dashboard">
                        <div class="drop-down   d-md-none">
                            <form action="#">
                                <input type="text" class="form-control" placeholder="Search">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-email-outline"></i>
                                <span class="badge gradient-1 badge-pill badge-primary">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">3 New Messages</span>

                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/1.jpg"
                                                    alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Saiful Islam</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/2.jpg"
                                                    alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Adam Smith</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Can you do me a favour?</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/3.jpg"
                                                    alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Barak Obama</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/4.jpg"
                                                    alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Hilari Clinton</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hello</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li>
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2 badge-primary">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">2 New Notifications</span>

                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i
                                                        class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events near you</h6>
                                                    <span class="notification-text">Within next 5 days</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i
                                                        class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Started</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i
                                                        class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Ended Successfully</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i
                                                        class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events to Join</h6>
                                                    <span class="notification-text">After two days</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li>
                        <li class="icons d-none d-md-flex">
                            <h4>{{ Auth::user()->user_nama }}</h4>
                        </li>
                        
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="images/user/1.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="app-profile.html"><i class="icon-user"></i>
                                                <span>Profile</span></a>
                                        </li>
                                        <li>
                                            <a href="email-inbox.html"><i class="icon-envelope-open"></i>
                                                <span>Inbox</span>
                                                <div class="badge gradient-3 badge-pill badge-primary">3</div>
                                            </a>
                                        </li>

                                        <hr class="my-2">
                                        <li>
                                            <a href="page-lock.html"><i class="icon-lock"></i> <span>Lock
                                                    Screen</span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" id="logout-button">
                                                <i class="icon-key"></i> <span>Logout</span>
                                            </a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>

                        </li>
                    </ul>
                </div>
            </div>
            </li>
            </ul>
        </div>
    </div>
    </div>
    <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

    <!--**********************************
            Sidebar start
        ***********************************-->
    <div class="nk-sidebar">
        <div class="nk-nav-scroll">
            <ul class="metismenu" id="menu" style="margin-top: 20px">

                {{-- DASHBOARD --}}
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home menu-icon"></i><span class="nav-text">Dashboard</span>
                    </a>
                </li>

                {{-- PRODUK --}}
                @if (in_array(Auth::user()->user_hak, ['admin', 'kasir', 'owner']))
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Produk</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('kategori.index') }}">Kategori</a></li>
                            <li><a href="{{ route('produk.index') }}">Produk</a></li>
                            <li><a href="{{ route('pengajuanBarang.index') }}">Pengajuan Barang</a></li>
                        </ul>
                    </li>
                @endif

                {{-- TRANSAKSI --}}
                @if (Auth::user()->user_hak === 'kasir')
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-basket-loaded menu-icon"></i><span class="nav-text">Transaksi</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('transaksi.create') }}">Penjualan</a></li>
                        </ul>
                    </li>
                @elseif (in_array(Auth::user()->user_hak, ['admin', 'owner']))
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-basket menu-icon"></i><span class="nav-text">Transaksi</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('penerimaan_barang.index') }}">Penerimaan Barang</a></li>
                            @if (Auth::user()->user_hak === 'owner')
                                <li><a href="{{ route('transaksi.create') }}">Penjualan</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- LAPORAN - untuk semua role --}}
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-docs menu-icon"></i><span class="nav-text">Laporan</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('transaksi.index') }}">Daftar Transaksi</a></li>
                        <li><a href="{{ route('produk_varian.index') }}">Varian Produk</a></li>
                    </ul>
                </li>

                {{-- REFERENSI --}}
                @if (in_array(Auth::user()->user_hak, ['admin', 'kasir', 'owner']))
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-people menu-icon"></i><span class="nav-text">Referensi</span>
                        </a>
                        <ul aria-expanded="false">
                            @if (in_array(Auth::user()->user_hak, ['admin', 'owner']))
                                <li><a href="{{ route('user.index') }}">User</a></li>
                                <li><a href="{{ route('supplier.index') }}">Supplier</a></li>
                            @endif
                            <li><a href="{{ route('member.index') }}">Member</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </div>

    <!--**********************************
            Sidebar end
        ***********************************-->

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid mt-3">
            @yield('content')
        </div>
    </div>
    <!--**********************************
            Content body end
        ***********************************-->


    <!--**********************************
            Footer start
        ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a>
                2018</p>
        </div>
    </div>
    <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('asset') }}/dist/plugins/common/common.min.js"></script>
    <script src="{{ asset('asset') }}/dist/js/custom.min.js"></script>
    <script src="{{ asset('asset') }}/dist/js/settings.js"></script>
    <script src="{{ asset('asset') }}/dist/js/gleek.js"></script>
    <script src="{{ asset('asset') }}/dist/js/styleSwitcher.js"></script>

    <script src="{{ asset('asset') }}/dist/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('asset') }}/dist/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('asset') }}/dist/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <!-- Morris.js and Raphael.js -->
    <script src="{{ asset('quixlab/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('quixlab/plugins/morris/morris.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function($) {
            "use strict"

            new quixSettings({
                headerPosition: "fixed",
                sidebarPosition: "fixed"
            });

        })(jQuery);
    </script>
    <script>
        document.getElementById('logout-button').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan logout dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
