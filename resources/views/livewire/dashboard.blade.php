<div>
    <div class="main_content_iner overly_inner">
        <div class="p-0 container-fluid ">
            @if ($user->default_pass == 0)
                <div class="row">
                    <div class="col-lg-9">
                        <div class="white_card card_height_100 mb_20">
                            <div class="white_card_header">
                                <h3>Ubah Kata Sandi Default</h3>
                            </div>
                            <div class="white_card_body" style="height: 100%;">
                                <p class="mb-3">Silakan ubah kata sandi default Anda di bawah ini. Setelah
                                    mengubahnya,
                                    kata sandi
                                    baru akan menjadi kata sandi yang berlaku untuk masuk ke akun Anda.</p>
                                <form wire:submit.prevent="default_pass">
                                    <div class="mb-3 row">
                                        <div class="col-md-12">
                                            <label class="form-label">Password Sekarang</label>
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                placeholder="Password" required wire:model.defer="current_password">
                                            @error('current_password')
                                                <label class="form-label text-danger"
                                                    for="inputPassword4">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Password Baru</label>
                                            <input type="password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                placeholder="Password Baru" required wire:model.defer="new_password">
                                            @error('new_password')
                                                <label class="form-label text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Ulangi Password Baru</label>
                                            <input type="password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                placeholder="Ulangi Password" required
                                                wire:model.defer="confirm_password">
                                            @error('new_password')
                                                <label class="form-label text-danger"
                                                    for="inputPassword4">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($user->default_pass == 1)
                <div>
                    <div class="row">
                        <div class="col-12">
                            <div class="page_title_box d-flex align-items-center justify-content-between">
                                <div class="page_title_left">
                                    <h3 class="f_s_30 f_w_700 text_white">DASHBOARD</h3>
                                    <ol class="mb-0 breadcrumb page_bradcam">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        @if ($user->id_role == 1)
                            {{-- for Bagian akademik --}}
                            {{-- <div class="col-lg-8">
                                <div class="white_card card_height_100 mb_20">
                                    <div class="white_card_header">
                                        <div class="m-0 box_header">
                                            <div class="main-title">
                                                <h3 class="m-0">Data</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white_card_body" style="height: 100%;">
                                        <div id="reportdata"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="white_card">
                                    <div class="white_card_header">
                                        <div class="m-0 box_header">
                                            <div class="main-title">
                                                <h3 class="m-0">Total</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-0 white_card_body">
                                        <div class="card_container">
                                            <div id="platform_type_dates_donut" style="height:100%"></div>
                    </div>
                </div>
        </div>
        <div class="sales_unit_footer d-flex justify-content-between">
            <div class="single_sales">
                <p>Mahasiswa Sekarang</p>
                <h3>$57k</h3>
            </div>
            <div class="single_sales disable_sales">
                <p>Alumni</p>
                <h3>$14k</h3>
            </div>
        </div>
    </div> --}}
                        @endif

                        @if ($user->id_role == 4)
                            {{-- for  mahasiswa --}}
                            {{-- <div class="col-lg-12">
                                <div class="white_card card_height_100 mb_20">
                                    <div class="white_card_header">
                                        <div class="m-0 box_header">
                                            <div class="main-title">
                                                <h4 class="m-0">Indeks Prestasi Semester (IPS)</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white_card_body">
                                        <div id="chartips"></div>
                                    </div>
                                </div>
                            </div> --}}
                        @endif

                        <div class="mt-3 col-lg-8">
                            <div class="white_card card_height_100 mb_20">
                                <div class="date_picker_wrapper">
                                    <div class="default-datepicker">
                                        <div class="datepicker-here" data-language="en"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('Success', function(event) {
                    Swal.fire({
                        position: 'top-cesnter',
                        icon: 'success',
                        title: event.__livewire.params[0],
                        showConfirmButton: false,
                    });
                });
            });
            var role = {{ $user->id_role }}
            if (role == 1) {


                var options = {
                    series: [{
                        data: [{
                            x: '2008',
                            y: [0, 2800]
                        }, ]
                    }],
                    chart: {
                        height: 350,
                        type: 'rangeBar',
                        zoom: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            isDumbbell: true,
                            columnWidth: 3,
                            dumbbellColors: [
                                ['#008FFB', '#00E396']
                            ]
                        }
                    },
                    legend: {
                        show: true,
                        showForSingleSeries: true,
                        position: 'top',
                        horizontalAlign: 'left',
                        customLegendItems: ['Dosen', 'Mahasiswa']
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            type: 'vertical',
                            gradientToColors: ['#00E396'],
                            inverseColors: true,
                            stops: [0, 100]
                        }
                    },
                    grid: {
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false
                            }
                        }
                    },
                    xaxis: {
                        tickPlacement: 'on'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#reportdata"), options);
                chart.render();
            }


            if (role == 4) {

                var optionsips = {
                    series: [{
                            name: "High - 2013",
                            data: [28, 29, 33, 36, 32, 32, 33]
                        },
                        {
                            name: "Low - 2013",
                            data: [12, 11, 14, 18, 17, 13, 13]
                        }
                    ],
                    chart: {
                        height: 350,
                        type: 'line',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#77B6EA', '#545454'],
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Average High & Low Temperature',
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },
                    markers: {
                        size: 1
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        title: {
                            text: 'Month'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Temperature'
                        },
                        min: 5,
                        max: 40
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chartips"), optionsips);
                chart.render();
            }
        </script>
    @endpush
</div>
