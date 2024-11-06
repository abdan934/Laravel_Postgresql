<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Login - Sistem Informasi Akademik</title>

    <link rel="icon" href="{{ asset('asset/img/pnc-nobg.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap1.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/tagsinput/tagsinput.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/themefy_icon/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/vendors/font_awesome/css/all.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendors/scroll/scrollable.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/css/metisMenu.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/vendors/gijgo/gijgo.min.css') }}" />

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
            background-color: rgba(255, 255, 255, 0.8);
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
    </style>

    <link rel="stylesheet" href="{{ asset('asset/css/style1.css') }}" />
    @livewireStyles

</head>

<body class="crm_body_bg">



    <div class="loader-background"></div>
    <div class="loader-container">
        <div class="loader--facebook colord_bg_1 mb_30">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>


    @yield('content')

    <script src="{{ asset('asset/js/jquery1-3.4.1.min.js') }}"></script>

    <script src="{{ asset('asset/js/popper1.min.js') }}"></script>

    <script src="{{ asset('asset/js/metisMenu.js') }}"></script>

    <script src="{{ asset('asset/vendors/scroll/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/scroll/scrollable-custom.js') }}"></script>

    <script src="{{ asset('asset/js/custom.js') }}"></script>

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

    @livewireScripts

</body>

</html>
