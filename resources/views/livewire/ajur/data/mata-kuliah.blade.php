<div>
    <div class="main_content_iner overly_inner">
        <div class="p-0 container-fluid ">
            <div class="page_title_box d-flex align-items-center justify-content-between">
                <div class="page_title_left">
                    <h3 class="f_s_30 f_w_700 text_white">MATA KULIAH JURUSAN {{ $ajur->name_jurusan }}</h3>
                    <ol class="mb-0 breadcrumb page_bradcam">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Mata Kuliah </a></li>
                    </ol>
                </div>
            </div>
            <div class="mt-3 row">
                <div class="col-lg-12">
                    <div class="white_card card_height_100 mb_20">
                        <div class="white_card_body">
                            <div class="">
                                <div class="table-responsive">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                        <div class="mb-2 add_button ms-2 col-md-3">
                                            <button data-bs-toggle="modal" data-bs-target="#modalAddMataKuliah"
                                                class="btn btn-primary col-12">
                                                <div class="text-green"></div>Tambah
                                            </button>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center text-info bg-light">No.
                                                </th>
                                                <th class="text-start text-info bg-light">Mata Kuliah
                                                </th>
                                                <th class="text-start text-info bg-light"> <label
                                                        style="font-style: italic">Course</label>
                                                </th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($mata_kuliah as $matkul)
                                                <tr>
                                                    <td style="text-align: center;vertical-align: top;">
                                                        {{ $no++ }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $matkul->nama_matkul_ind }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        <label
                                                            style="font-style: italic">{{ $matkul->nama_matkul_eng }}</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <button data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailMatkul"
                                                            wire:click="show_detailmatkul('{{ $matkul->id_matkul }}')"
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

    <!-- Modal tambah Matkul -->
    <div wire:ignore.self class="modal fade" id="modalAddMataKuliah" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Mata Kuliah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Add_Mata_Kuliah">
                        <div class="mb-3">
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <label class="form-label" for="inputAddress">Kode Mata Kuliah</label>
                                    <input type="text"
                                        class="form-control @error('kode_matkul') is-invalid @enderror"
                                        name="kode_matkul" placeholder="Kode Mata Kuliah" required
                                        wire:model.defer="kode_matkul" required disabled>
                                    @error('kode_matkul')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="button" class="btn btn-secondary"
                                        wire:click="generateKodeMatkul()">Generate</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="inputAddress">Nama Mata Kuliah *IND</label>
                                <input type="text"
                                    class="form-control @error('nama_matkul_ind') is-invalid @enderror"
                                    name="nama_matkul_ind" placeholder="Masukkan Nama Mata Kuliah" required
                                    wire:model.defer="nama_matkul_ind" required>
                                @error('nama_matkul_ind')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="inputAddress">Nama Mata Kuliah *ENG</label>
                                <input type="text"
                                    class="form-control @error('nama_matkul_eng') is-invalid @enderror"
                                    name="nama_matkul_eng" placeholder="Enter Course Name" required
                                    wire:model.defer="nama_matkul_eng" required>
                                @error('nama_matkul_eng')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btn_close">Tutup</button>
                    <button type="submit" class="btn btn-success" id="addButton">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal tambah Pengajar -->
    <div wire:ignore.self class="modal fade" id="modalAddMengajar" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pengajar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <form wire:submit.prevent="Add_Mengajar">
                            <div class="mb-3 col-md-12 row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="inputAddress">Kode Mata
                                        Kuliah</label>
                                    <input type="text"
                                        class="form-control @error('kode_matkul_pengajar') is-invalid @enderror"
                                        name="kode_matkul_pengajar" placeholder="Kode Mata Kuliah"
                                        wire:model.defer="kode_matkul_pengajar" required readonly>
                                    @error('kode_matkul_pengajar')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 col-md-12 row">
                                <div class="mb-2 col-md-6">
                                    <label class="form-label fw-bold" for="inputAddress">NIDN</label>
                                    <input type="text"
                                        class="form-control @error('nidn_pengajar') is-invalid @enderror"
                                        name="nidn_pengajar" wire:model.defer="nidn_pengajar" readonly required>
                                    @error('nidn_pengajar')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="inputAddress">Nama Dosen</label>
                                    <input type="text" class="form-control @error('nama_pengajar') is-@enderror"
                                        name="nama_pengajar" wire:model.defer="nama_pengajar" readonly required>
                                    @error('nama_pengajar')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success col-12"
                                        id="addButton">Simpan</button>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <div class="mb-2 col-md-2">
                                <form wire:submit.prevent="Updatedsearch">
                                    <div class="serach_field-area d-flex align-items-center">
                                        <div class="search_inner">
                                            <div class="search_field">
                                                <input type="text" wire:model.defer="search"
                                                    placeholder="Cari..." />
                                            </div>
                                            <button>
                                                <img src="{{ asset('asset/img/icon/icon_search.svg') }}" alt />
                                            </button>
                                        </div>
                                        <span class="f_s_14 f_w_400 ml_25 white_text text_white">Apps</span>
                                    </div>
                                </form>
                            </div>
                            <table id="example2" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-start text-info bg-light">NIDN
                                        </th>
                                        <th class="text-start text-info bg-light">Nama
                                        </th>
                                        </th>
                                        <th class="text-info bg-light"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data_dosen))
                                        @foreach ($data_dosen as $dosen)
                                            <tr>
                                                <td style="text-align: left;vertical-align: top;">
                                                    {{ $dosen->nidn }}</td>
                                                <td style="text-align: left;vertical-align: top;">
                                                    <label>{{ $dosen->name_dosen }}</label>
                                                </td>
                                                <td style="text-align: left;vertical-align: top;">
                                                    <button type="button" class="mb-3 btn btn-outline-primary col-12"
                                                        wire:click="NidntoInput('{{ $dosen->nidn }}')">
                                                        Pilih
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btn_close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Matkul --}}
    <div wire:ignore.self class="modal fade" id="modalDetailMatkul" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Mata Kuliah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="col-12 ">
                        <tr class="row" valign = "top">
                            <td class="col-md-6 col-lg-6">
                                <table class="table table-stripped" border="1">
                                    <tr>
                                        <th>Kode Mata Kuliah</th>
                                        <th>&nbsp;=&nbsp;</th>
                                        <th>{{ $label_kode_matkul }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Jurusan</th>
                                        <th>&nbsp;=&nbsp;</th>
                                        <th>{{ $label_jurusan }}</th>
                                    </tr>
                                </table>
                            </td>
                            <td class="col-md-6 col-lg-6">
                                <table class="table table-stripped" border="1">
                                    <tr>
                                        <th>Mata Kuliah</th>
                                        <th>&nbsp;=&nbsp;</th>
                                        <th>{{ $label_nama_matkul_ind }}</th>
                                    </tr>
                                    <tr>
                                        <th><label style="font-style: italic">Course</label></th>
                                        <th>&nbsp;=&nbsp;</th>
                                        <th><label style="font-style: italic">{{ $label_nama_matkul_eng }}</label>
                                        </th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <div class="table-responsive">
                        <div class="white_box_tittle list_header">
                            <h4>PENGAJAR</h4>
                            <div class="mb-2 add_button ms-2 col-md-3 justify-content-end">
                                <button wire:click="modalAddMengajar('{{ $label_kode_matkul }}')" type="button"
                                    class="mb-3 btn btn-outline-primary col-12">
                                    <i class="bi bi-person-plus bi-lg"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <table class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-start text-info bg-light">Kode Mengajar
                                    </th>
                                    <th class="text-start text-info bg-light">NIDN
                                    </th>
                                    <th class="text-start text-info bg-light">Nama
                                    </th>
                                    <th class="text-info bg-light"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($mengajar))
                                    @foreach ($mengajar as $ajar)
                                        <tr>
                                            <td style="text-align: left;vertical-align: top;">
                                                {{ $ajar->kode_mengajar }}</td>
                                            <td style="text-align: left;vertical-align: top;">
                                                <label>{{ $ajar->nidn }}</label>
                                            </td>
                                            <td style="text-align: left;vertical-align: top;">
                                                <label>{{ $ajar->name_dosen }}</label>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn {{ $ajar->status_mengajar == 1 ? 'btn-success' : 'btn-danger' }}"
                                                    wire:click="show_modalstatus('{{ $ajar->kode_mengajar }}')"><i
                                                        class="{{ $ajar->status_mengajar == 1 ? 'ti-check' : 'ti-close' }}"></i>&nbsp;{{ $ajar->status_mengajar == 1 ? 'Aktif' : 'Tidak Aktif' }}</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success text-light"
                        wire:click="show_editmatkul('{{ $id_matkul }}')"><i class="ti-pencil-alt"></i>&nbsp;Ubah
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btn_close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div wire:ignore.self class="modal fade" id="modalEditMatkul" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Data Mata Kuliah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Edit_Matkul">
                        <input type="text" name="id_edit_hide" hidden wire:model.defer="id_edit_hide">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">Kode Mata Kuliah</label>
                                <input type="text" class="form-control" placeholder="Kode Mata Kuliah"
                                    name="kode_matkul_edit" wire:model.defer="kode_matkul_edit" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="inputAddress">Nama Mata Kuliah *IND</label>
                            <input type="text"
                                class="form-control @error('nama_matkul_ind_edit') is-invalid @enderror"
                                name="nama_matkul_ind_edit" placeholder="Masukkan Nama Mata Kuliah" required
                                wire:model.defer="nama_matkul_ind_edit" required>
                            @error('nama_matkul_ind_edit')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="inputAddress">Nama Mata Kuliah *ENG</label>
                            <input type="text"
                                class="form-control @error('nama_matkul_eng_edit') is-invalid @enderror"
                                name="nama_matkul_eng_edit" placeholder="Enter Course Name" required
                                wire:model.defer="nama_matkul_eng_edit" required>
                            @error('nama_matkul_eng_edit')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close"
                        wire:click="close_modal_edit_form">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>

        <script>
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

            window.addEventListener('close-modal-form', function() {
                $('#modalAddMataKuliah').modal('hide');
            });
            window.addEventListener('close-modal-form-pengajar', function() {
                $('#modalAddMengajar').modal('hide');
            });
            window.addEventListener('close-modal-detail', function() {
                $('#modalDetailMatkul').modal('hide');
            });
            window.addEventListener('close-modal-edit-form', function() {
                $('#modalEditMatkul').modal('hide');
            });
            window.addEventListener('open-modal-edit-form', function(event) {
                var id = event.__livewire.params[0];
                $('#modalEditMatkul').attr('data-id', id);
                $('#modalEditMatkul').modal('show');
            });
            window.addEventListener('open-modal-detail', function() {
                $('#modalDetailMatkul').modal('show');
            });
            window.addEventListener('open-modal-add-pengajar', function() {
                $('#modalDetailMatkul').modal('hide');
                $('#modalDetailMatkul').remove();
                $('#modalAddMengajar').modal('show');
            });
            window.addEventListener('open-modal-validation-status', function(event) {
                var id = event.__livewire.params[0];
                $('#modalDetailMatkul').modal('hide');
                Swal.fire({
                    title: "Apakah yakin ingin mengubah status?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya !",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('ubahStatus', {
                            id: id
                        })
                    } else {
                        $('#modalDetailMatkul').modal('show');
                    }
                });
            });
        </script>
    @endpush
</div>
