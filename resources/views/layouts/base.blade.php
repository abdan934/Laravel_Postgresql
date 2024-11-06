<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('asset/img/pnc-nobg.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap1.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/themefy_icon/themify-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/niceselect/css/nice-select.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/owl_carousel/css/owl.carousel.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/gijgo/gijgo.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/font_awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/vendors/tagsinput/tagsinput.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/datepicker/date-picker.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/scroll/scrollable.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/text_editor/summernote-bs4.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/morris/morris.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/vendors/material_icon/material-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/css/metisMenu.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/css/style1.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    @livewireStyles
    <style type="text/css">
        .loader-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            display: none;
        }

        .loader-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 1);
            /* Putih dengan opacity 0.8 */
            z-index: 9999;
            /* Atur di belakang loader */
            display: none;
            /* Disembunyikan secara default */
        }

        @keyframes spinloader {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spinlogo {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .divider-label-container {
            display: flex;
            align-items: center;
        }

        .divider-label {
            margin: 0 5px;
        }
    </style>

</head>

<body class="crm_body_bg">

    <div class="loader-background" style="display: none"></div>
    <div class="loader-container" style="display: none">
        <div class="loader--facebook colord_bg_1 mb_30">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <nav class="sidebar vertical-scroll dark_sidebar ps-container ps-theme-default ps-active-y">
        <div class="logo d-flex justify-content-between">
            <ul>
                <li>
                    <a href="/dashboard" aria-expanded="false">
                        <div class="row d-flex">
                            <div class="text-center col-lg-12">
                                <img src="{{ asset('asset/img/pnc-nobg.png') }}" style="height: 10dvh;width:auto;" alt>
                            </div>
                            <div class="mt-2 text-center col-lg-12 d-flex justify-content-center align-items-center">
                                <span class="text-light f_s_30 f_w_700" style="font-size: 15px">Sistem
                                    Informasi
                                    Akademik</span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="sidebar_close_icon d-lg-none">
                <i class="ti-close"></i>
            </div>
        </div>
        @if ($user->default_pass == 1)
            <ul id="sidebar_menu">
                <li class>
                    <a class href="{{ url('/dashboard') }}" aria-expanded="false">
                        <div class="icon_menu">
                            <i class="ti-home"></i>
                        </div>
                        <span style="font-size: 15px">Dashboard</span>
                    </a>
                </li>
                @if ($user->id_role == 1)
                    <li class>
                        <a class href="{{ url('/struktur-akademik') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-book"></i>
                            </div>
                            <span style="font-size: 15px">Struktur Akademik</span>
                        </a>
                    </li>
                    <li class>
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-files"></i>
                            </div>
                            <span style="font-size: 15px">Data</span>
                        </a>
                        <ul>
                            <li><a href="{{ url('/data/admin-jurusan') }}">Admin Jurusan</a></li>
                            <li><a href="{{ url('/data/dosen') }}">Dosen</a></li>
                            <li><a href="{{ url('/data/mahasiswa') }}">Mahasiswa</a></li>
                        </ul>
                    </li>
                    <li class>
                        <a class href="{{ url('/data/baak/jadwal-kuliah') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-calendar"></i>
                            </div>
                            <span style="font-size: 15px">Jadwal Kuliah</span>
                        </a>
                    </li>
                @endif
                @if ($user->id_role == 2)
                    <li class>
                        <a class href="{{ url('/data/jurusan') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-files"></i>
                            </div>
                            <span style="font-size: 15px">Data</span>
                        </a>
                    </li>
                    <li class>
                        <a class href="{{ url('/data/mata-kuliah') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-bookmark-alt"></i>
                            </div>
                            <span style="font-size: 15px">Mata Kuliah</span>
                        </a>
                    </li>
                    <li class>
                        <a class href="{{ url('/data/jadwal-kuliah') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-calendar"></i>
                            </div>
                            <span style="font-size: 15px">Jadwal Kuliah</span>
                        </a>
                    </li>
                @endif
                @if ($user->id_role == 3)
                    <li class>
                        <a class href="{{ url('/dosen/mata-kuliah') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-bookmark-alt"></i>
                            </div>
                            <span style="font-size: 15px">Mata Kuliah</span>
                        </a>
                    </li>
                    <li class>
                        <a class href="{{ url('/dosen/jadwal-kuliah') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-calendar"></i>
                            </div>
                            <span style="font-size: 15px">Jadwal Kuliah</span>
                        </a>
                    </li>
                @endif
                @if ($user->id_role == 4)
                    <li class>
                        <a class href="{{ url('/mahasiswa/nilai-mata-kuliah') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="bi bi-list-ol"></i>
                            </div>
                            <span style="font-size: 15px">Nilai</span>
                        </a>
                    </li>
                    <li class>
                        <a class href="{{ url('/mahasiswa/jadwal-kuliah') }}" aria-expanded="false">
                            <div class="icon_menu">
                                <i class="ti-calendar"></i>
                            </div>
                            <span style="font-size: 15px">Jadwal Kuliah</span>
                        </a>
                    </li>
                @endif
            </ul>
        @endif
    </nav>

    <section class="main_content dashboard_part large_header_bg">

        <div class="container-fluid g-0">
            <div class="row">
                <div class="p-0 col-lg-12 ">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="serach_field-area d-flex align-items-center">
                        </div>
                        <div class="header_right d-flex justify-content-between align-items-center">
                            @if ($user->default_pass == 1)
                                {{-- <div class="header_notification_warp d-flex align-items-center">
                                    <li>
                                        <a class="bell_notification_clicker nav-link-notify" href="#"> <img
                                                src="{{ asset('asset/img/icon/bell.svg') }}" alt>
                                        </a>

                                        <div class="Menu_NOtification_Wrap">
                                            <div class="notification_Header">
                                                <h4>Notifications</h4>
                                            </div>
                                            <div class="Notification_body">

                                                <div class="single_notify d-flex align-items-center">
                                                    <div class="notify_thumb">
                                                        <a href="#"><img
                                                                src="{{ asset('asset/img/staf/2.png') }}" alt></a>
                                                    </div>
                                                    <div class="notify_content">
                                                        <a href="#">
                                                            <h5>Cool Marketing </h5>
                                                        </a>
                                                        <p>Lorem ipsum dolor sit amet</p>
                                                    </div>
                                                </div>
                                            </div>

                                    </li>
                                </div> --}}
                                <div class="profile_info">
                                    <img src="{{ asset('photo/pp/' . $user->photo_profile) }}" alt="#">
                                    <div class="profile_info_iner">
                                        <div class="profile_author_name">
                                            <p>{{ $user->username }}</p>
                                            <h6 class="text-light">{{ $user->name_user }}</h6>
                                        </div>
                                        <div class="profile_info_details">
                                            <a href="{{ url('/profile') }}">Profil </a>
                                            <a href="/logout">Keluar</a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="profile_info">
                                    <img src="{{ asset('photo/pp/' . $user->photo_profile) }}" alt="#">
                                    <div class="profile_info_iner">
                                        <div class="profile_author_name">
                                            <p>{{ $user->username }}</p>
                                            <h6 class="text-light">{{ $user->name_user }}</h6>
                                        </div>
                                        <div class="profile_info_details">
                                            <a href="/logout">Keluar</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

        <div class="footer_part">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center footer_iner">
                            <p>@php echo date('Y') @endphp © build by Isnaeni Abdan Syakuro</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('asset/js/jquery1-3.4.1.min.js') }}"></script>

    <script src="{{ asset('asset/js/popper1.min.js') }}"></script>

    <script src="{{ asset('asset/js/metisMenu.js') }}"></script>

    <script src="{{ asset('asset/vendors/count_up/jquery.waypoints.min.js') }}"></script>

    <script src="{{ asset('asset/vendors/chartlist/Chart.min.js') }}"></script>

    <script src="{{ asset('asset/vendors/count_up/jquery.counterup.min.js') }}"></script>

    <script src="{{ asset('asset/vendors/niceselect/js/jquery.nice-select.min.js') }}"></script>

    <script src="{{ asset('asset/vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('asset/vendors/datepicker/datepicker.js') }}"></script>
    <script src="{{ asset('asset/vendors/datepicker/datepicker.en.js') }}"></script>
    <script src="{{ asset('asset/vendors/datepicker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('asset/js/chart.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/chartjs/roundedBar.min.js') }}"></script>

    <script src="{{ asset('asset/vendors/progressbar/jquery.barfiller.js') }}"></script>

    <script src="{{ asset('asset/vendors/tagsinput/tagsinput.js') }}"></script>

    <script src="{{ asset('asset/vendors/text_editor/summernote-bs4.js') }}"></script>

    <script src="{{ asset('asset/vendors/scroll/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/scroll/scrollable-custom.js') }}"></script>

    <script src="{{ asset('asset/js/custom.js') }}"></script>

    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.loader-background').style.display = 'block';
            document.querySelector('.loader-container').style.display = 'block';

            setTimeout(function() {
                document.querySelector('.loader-background').style.display = 'none';
                document.querySelector('.loader-container').style.display = 'none';
            }, 3000);
        });
    </script>



    @stack('scripts')
    @livewireScripts

</body>

</html>
