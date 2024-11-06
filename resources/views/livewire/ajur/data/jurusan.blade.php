<div>
    <div class="main_content_iner overly_inner">
        <div class="container-fluid p-0 ">
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white">DATA JURUSAN {{ $ajur->name_jurusan }}</h3>
                            <ol class="breadcrumb page_bradcam mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Data Jurusan</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="white_card card_height_100 mb_20">
                        <div class="row">
                            <div class="col-lg-12 d-flex">
                                <div class="btn-group align-items-right justify-content-end" role="group"
                                    aria-label="Basic example">
                                    <button type="button" class="btn btn-outlite-light" onclick="showData('dosen')">
                                        <h4 id="btnDosen" style="color: #68c4b4">Dosen</h4>
                                    </button>
                                    <button type="button" class="btn btn-outlite-light"
                                        onclick="showData('mahasiswa')">
                                        <h4 id="btnMhs">Mahasiswa</h4>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="">
                                <div class="table-responsive" id="table_dosen" style="display: block">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                    </div>
                                    <table id="example1" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start text-info bg-light">Nomor
                                                    Induk Dosen
                                                    Nasional
                                                </th>
                                                <th class="text-center text-info bg-light">Nama</th>
                                                <th class="text-center text-info bg-light">Prodi</th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_dosen as $dosen)
                                                <tr>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $dosen->nidn }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $dosen->name_dosen }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $dosen->name_prodi }}</td>
                                                    <td>
                                                        <button data-bs-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailDosen{{ $dosen->nidn }}"
                                                            class="btn btn-info text-light">Detail</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive" id="table_mahasiswa" style="display: none">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                    </div>
                                    <table id="example2" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start text-info bg-light">Nomor Pokok Mahasiswa</th>
                                                <th class="text-center text-info bg-light">Nama</th>
                                                <th class="text-center text-info bg-light">Prodi</th>
                                                <th class="bg-light text-info"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_mahasiswa as $mhs)
                                                <tr>
                                                    <td
                                                        style="text-align:
                                                    left;vertical-align: top;">
                                                        {{ $mhs->npm }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $mhs->name_mhs }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $mhs->name_prodi }}</td>
                                                    <td style="text-align: center;vertical-align: center;">
                                                        <button data-bs-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailMhs{{ $mhs->npm }}"
                                                            class="btn btn-info text-light">Detail</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Dosen --}}
    @foreach ($data_dosen as $detail_dosen)
        <div wire:ignore.self class="modal fade" id="modalDetailDosen{{ $detail_dosen->nidn }}"
            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Dosen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="col-12 ">
                            <tr class="row" valign = "top">
                                <td class="col-md-6 col-lg-6">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Nomor Induk Dosen Nasional</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->nidn }}</th>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->name_dosen }}</th>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->jk_dosen == 'L' ? 'Laki-laki' : 'Perempuan' }}</th>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->email_dosen }}</th>
                                        </tr>
                                        <tr>
                                            <th>No. Handphone</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->no_hp_dosen }}</th>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->alamat_dosen }}</th>
                                        </tr>
                                    </table>
                                </td>
                                <td class="col-md-6 col-lg-6">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Jurusan</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->name_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>Prodi</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->name_prodi }}</th>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th><a
                                                    class="status_btn {{ $detail_dosen->status_dosen == 1 ? '' : 'bg-danger' }}">{{ $detail_dosen->status_dosen == 1 ? 'aktif' : 'tidak aktif' }}</a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Terakhir</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>
                                                {{ !is_null($detail_dosen->last_login) ? date('d F Y H:i:s', strtotime($detail_dosen->last_login)) : '-' }}
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning text-light"
                            wire:click="show_resetdosen('{{ $detail_dosen->nidn }}')"><i
                                class="ti-back-left"></i>&nbsp;Reset</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btn_close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Detail Mahasiswa --}}
    @foreach ($data_mahasiswa as $detail_mhs)
        <div wire:ignore.self class="modal fade" id="modalDetailMhs{{ $detail_mhs->npm }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Mahasiswa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="col-12 ">
                            <tr class="row" valign = "top">
                                <td class="col-md-6 col-lg-6">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Nomor Pokok Mahasiswa</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->npm }}</th>
                                        </tr>
                                        <tr>
                                            <th>Nama Mahasiswa</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->name_mhs }}</th>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->jk_mhs == 'L' ? 'Laki-laki' : 'Perempuan' }}</th>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->email_mhs }}</th>
                                        </tr>
                                        <tr>
                                            <th>No. Handphone</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->no_hp }}</th>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->alamat_mhs }}</th>
                                        </tr>
                                    </table>
                                </td>
                                <td class="col-md-6 col-lg-6">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Jurusan</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->name_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>Prodi</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->name_prodi }}</th>
                                        </tr>
                                        <tr>
                                            <th>Tahun Masuk</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_mhs->tahun_masuk }}</th>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th><a
                                                    class="status_btn {{ $detail_mhs->status_mhs == 1 ? '' : 'bg-danger' }}">{{ $detail_mhs->status_mhs == 1 ? 'aktif' : 'tidak aktif' }}</a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Terakhir</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>
                                                {{ !is_null($detail_mhs->last_login) ? date('d F Y H:i:s', strtotime($detail_mhs->last_login)) : '-' }}
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning text-light"
                            wire:click="show_resetmahasiswa('{{ $detail_mhs->npm }}')"><i
                                class="ti-back-left"></i>&nbsp;Reset</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btn_close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>

        <script>
            function showData(type) {
                if (type === 'dosen') {
                    document.getElementById('table_dosen').style.display = 'block';
                    document.getElementById('table_mahasiswa').style.display = 'none';
                    document.getElementById('btnDosen').style.color = '#68c4b4';
                    document.getElementById('btnMhs').style.color = '';
                } else if (type === 'mahasiswa') {
                    document.getElementById('table_dosen').style.display = 'none';
                    document.getElementById('table_mahasiswa').style.display = 'block';
                    document.getElementById('btnDosen').style.color = '';
                    document.getElementById('btnMhs').style.color = '#68c4b4';
                }
            }
            document.addEventListener('DOMContentLoaded', function() {

                $('#example1').DataTable({
                    "ordering": false,
                    "pageLength": 10,
                    "info": true,
                    "lengthChange": false,
                    "layout": {
                        topStart: 'search',
                        topEnd: null
                    }
                });
                $('#example2').DataTable({
                    "ordering": false,
                    "pageLength": 10,
                    "info": true,
                    "lengthChange": false,
                    "layout": {
                        topStart: 'search',
                        topEnd: null
                    }
                });

                window.addEventListener('refresh-table', function() {
                    $('#example1').DataTable().ajax.reload();
                });

                window.addEventListener('Success', function(event) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: event.__livewire.params[0],
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
                window.addEventListener('Failed', function(event) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Gagal !' + '\n' + event.__livewire.params[0],
                        showConfirmButton: true,
                    });
                });

                window.addEventListener('Load', function() {
                    const swalAlert = Swal.fire({
                        title: "Sedang dalam Proses",
                        html: '<h4 class="text-light text-center">Harap tunggu sebentar...</h4>',
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    window.addEventListener('close-Load', function() {
                        swalAlert.close();
                    });
                });
            });

            window.addEventListener('open-modal-validation-reset-dosen', function(event) {
                var nidn = event.__livewire.params[0];
                $('#modalDetailDosen' + nidn).modal('hide');
                Swal.fire({
                    title: "Apakah yakin ingin me-reset password?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya !",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('ResetPassDosen', {
                            id: nidn
                        })
                    } else {
                        $('#modalDetailDosen' + nidn).modal('show');
                    }
                });
            });

            window.addEventListener('open-modal-validation-reset-mahasiswa', function(event) {
                var npm = event.__livewire.params[0];
                $('#modalDetailMhs' + npm).modal('hide');
                Swal.fire({
                    title: "Apakah yakin ingin me-reset password?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya !",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('ResetPassMahasiswa', {
                            id: npm
                        })
                    } else {
                        $('#modalDetailMhs' + nidn).modal('show');
                    }
                });
            });

            window.addEventListener('close-modal-detail-dosen', function(event) {
                $('#modalDetailDosen' + event.__livewire.params[0]).modal('hide');
            });
            window.addEventListener('close-modal-detail-mahasiswa', function(event) {
                $('#modalDetailMhs' + event.__livewire.params[0]).modal('hide');
            });

            window.addEventListener('open-modal-information-reset', function(event) {
                var new_pass = event.__livewire.params[0];
                Swal.fire({
                    title: "<strong>Password Baru</strong>",
                    inputValue: new_pass,
                    input: "text",
                    icon: "info",
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    inputAttributes: {
                        disabled: true
                    },
                    customClass: {
                        input: 'text-center'
                    },
                    confirmButtonText: `<i class="ti-clipboard"></i> Salin`,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        navigator.clipboard.writeText(new_pass).then(() => {
                            Swal.getConfirmButton().setAttribute('disabled', true);
                        })
                        return false;
                    }
                });
            });
        </script>
    @endpush
</div>
