<div>
    <div class="main_content_iner overly_inner">
        <div class="p-0 container-fluid ">
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white">DATA DOSEN</h3>
                            <ol class="mb-0 breadcrumb page_bradcam">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Data Dosen</a></li>
                            </ol>
                        </div>
                    </div>
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
                                        <div
                                            class="box-right d-flex justify-content-center lms_block row col-12 col-md-12">
                                            <div class="mb-2 add_button ms-2 col-md-3">
                                                <button data-bs-toggle="modal" data-bs-target="#modalAddDosen"
                                                    class="btn btn-primary col-12">
                                                    <div class="text-green"></div>Tambah
                                                </button>
                                            </div>
                                            <div class="mb-2 add_button ms-2 col-md-3">
                                                <button data-bs-toggle="modal" data-bs-target="#modalImport"
                                                    class="btn btn-secondary col-12">Import</button>
                                            </div>
                                            <div class="mb-2 add_button ms-2 col-md-3">
                                                <a href="{{ asset('format/format_dosen.xlsx') }}"
                                                    class="btn btn-success col-12">Format</a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start text-info bg-light">Nomor Induk Dosen Nasional
                                                </th>
                                                <th class="text-center text-info bg-light">Nama</th>
                                                <th class="text-center text-info bg-light">Jurusan</th>
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
                                                        {{ $dosen->name_jurusan }}</td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tambah -->
    <div wire:ignore.self class="modal fade" id="modalAddDosen" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Dosen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Add_Dosen">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label" for="inputEmail4">Nomor Induk Dosen Nasional</label>
                                <input type="text" class="form-control @error('nidn') is-invalid @enderror"
                                    minlength="10" maxlength="10" placeholder="Nomor Induk Dosen Nasional"
                                    name="nidn" required wire:model.defer="nidn">
                                @error('nidn')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label" for="inputEmail4">Nomor Induk Pegawai</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                    minlength="10" maxlength="10" placeholder="Nomor Induk Dosen Nasional"
                                    name="nip" required wire:model.defer="nip">
                                @error('nip')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name_dosen') is-invalid @enderror"
                                name="name_dosen" placeholder="Masukkan Nama Lengkap" required
                                wire:model.defer="name_dosen" required>
                            @error('name_dosen')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="form-label" for="inputEmail4">Email</label>
                                <input type="email" class="form-control @error('email_dosen') is-invalid @enderror"
                                    placeholder="Email" name="email_dosen" required wire:model.defer="email_dosen">
                                @error('email_dosen')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class=" col-md-6">
                                <label class="form-label" for="inputPassword4">No. Handphone</label>
                                <input type="text" class="form-control @error('no_hp_dosen') is-invalid @enderror"
                                    id="inputPassword4" maxlength="13" placeholder="Nomor Handphone" required
                                    minlength="12" wire:model.defer="no_hp_dosen" name="no_hp_dosen">
                                @error('no_hp_dosen')
                                    <label class="form-label text-danger"
                                        for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <fieldset class>
                            <div class="row">
                                <div class="pt-0 col-form-label col-sm-4">Jenis Kelamin</div>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin_dosen"
                                            value="L" wire:model.defer="jenis_kelamin_dosen" required>
                                        <label class="form-label form-check-label" for="gridRadios1">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin_dosen"
                                            value="P" wire:model.defer="jenis_kelamin_dosen" required>
                                        <label class="form-label form-check-label" for="gridRadios2">
                                            Perempuan
                                        </label>
                                    </div>
                                    @error('jenis_kelamin_dosen')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat_dosen') is-invalid @enderror" required wire:model.defer="alamat_dosen"
                                name="alamat_dosen" cols="10" rows="5"></textarea>
                            @error('alamat_dosen')
                                <label class="form-label text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <select class="form-select" wire:model.defer="jupro" name="jupro" required>
                                    <option selected>Jurusan --- Prodi</option>
                                    @foreach ($data_jupro as $jupro)
                                        <option value="{{ $jupro->id_jurusan . '---' . $jupro->id_prodi }}">
                                            {{ $jupro->jurusan_name . '  ---  ' . $jupro->name_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jupro')
                                    <label class="form-label text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btn_close">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    @foreach ($data_dosen as $detail_dosen)
        <div wire:ignore.self class="modal fade" id="modalDetailDosen{{ $detail_dosen->nidn }}"
            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Dosen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
                                            <th>Nomor Induk Pegawai</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->nip }}</th>
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
                                            <th>Jenjang</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_dosen->jenjang_prodi }}</th>
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
                        <button type="button" class="btn btn-success text-light"
                            wire:click="show_editdosen('{{ $detail_dosen->nidn }}')"><i
                                class="ti-pencil-alt"></i>&nbsp;Ubah</button>
                        <button type="button" class="btn btn-info text-light"
                            wire:click="show_modalstatus('{{ $detail_dosen->nidn }}')"><i
                                class="ti-check-box"></i>&nbsp;Status</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btn_close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    <div wire:ignore.self class="modal fade" id="modalEditDosen" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Data Dosen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Edit_Dosen">
                        <input type="text" name="nidn_edit_hide" hidden wire:model.defer="nidn_edit_hide">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">Nomor Induk Dosen Nasional</label>
                                <input type="text" class="form-control " placeholder="Nomor Induk Dosen Nasional"
                                    wire:model.defer="nidn_edit" disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">Nomor Induk Pegawai</label>
                                <input type="text" class="form-control " placeholder="Nomor Induk Pegawai"
                                    wire:model.defer="nip_edit" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name_edit') is-invalid @enderror"
                                name="name_edit" placeholder="Masukkan Nama Lengkap" required
                                wire:model.defer="name_edit" required>
                            @error('name_edit')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="form-label" for="inputEmail4">Email</label>
                                <input type="email" class="form-control @error('email_edit') is-invalid @enderror"
                                    placeholder="Email" name="email_edit" required wire:model.defer="email_edit">
                                @error('email_edit')
                                    <label class="form-label text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class=" col-md-6">
                                <label class="form-label">No. Handphone</label>
                                <input type="text" class="form-control @error('no_hp_edit') is-invalid @enderror"
                                    maxlength="13" placeholder="Nomor Handphone" required minlength="12"
                                    wire:model.defer="no_hp_edit" name="no_hp_edit">
                                @error('no_hp_edit')
                                    <label class="form-label text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <fieldset class>
                            <div class="row">
                                <div class="pt-0 col-form-label col-sm-4">Jenis Kelamin</div>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="L" wire:model.defer="jenis_kelamin_edit" required>
                                        <label class="form-label form-check-label" for="gridRadios1">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="P" wire:model.defer="jenis_kelamin_edit" required>
                                        <label class="form-label form-check-label" for="gridRadios2">
                                            Perempuan
                                        </label>
                                    </div>
                                    @error('jenis_kelamin_edit')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat_dosen_edit') is-invalid @enderror" required
                                wire:model.defer="alamat_dosen_edit" name="alamat_dosen_edit" cols="10" rows="5"></textarea>
                            @error('alamat_dosen_edit')
                                <label class="form-label text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <select class="form-select" wire:model.defer="jupro_edit" name="jupro_edit" required>
                                    <option selected>Jurusan --- Prodi</option>
                                    @foreach ($data_jupro as $jupro)
                                        <option value="{{ $jupro->id_jurusan . '---' . $jupro->id_prodi }}">
                                            {{ $jupro->jurusan_name . '  ---  ' . $jupro->name_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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

    {{-- Modal Import --}}
    <div wire:ignore.self class="modal fade" id="modalImport" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">File .xlsx|.xls</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="importDosen">
                        <input type="file" class=" @error('file_import_dosen') is-invalid @enderror"
                            wire:model="file_import_dosen" id="importFile" required> <br>
                        @error('file_import_dosen')
                            <label class="form-label text-danger" id="label_error_import">{{ $message }}</label>
                        @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="importButton">Import</button>
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
            document.getElementById('importButton').addEventListener('click', function() {
                var fileInput = document.getElementById('importFile');
                var file = fileInput.files[0];
                var fileName = file.name;
                var fileExtension = fileName.split('.').pop().toLowerCase();
                var fileSizeMB = file.size / (1024 * 1024);
                var maxFileSizeMB = 10;

                if ((fileExtension === 'xlsx' || fileExtension === 'xls') && file && file.size > 0 &&
                    fileSizeMB <= maxFileSizeMB) {
                    Livewire.dispatch('close-modal-import');
                    Livewire.dispatch('Load');
                }
            });
            window.addEventListener('close-Load', function() {
                $('#Load').modal('hide');
            });
            window.addEventListener('close-modal-form', function() {
                $('#modalAddDosen').modal('hide');
            });
            window.addEventListener('close-modal-detail', function(event) {
                $('#modalDetailDosen' + event.__livewire.params[0]).modal('hide');
            });
            window.addEventListener('close-modal-edit-form', function() {
                $('#modalEditDosen').modal('hide');
            });
            window.addEventListener('close-modal-import', function() {
                $('#modalImport').modal('hide');
            });
            window.addEventListener('open-modal-import', function() {
                $('#modalImport').modal('show');
            });
            window.addEventListener('open-modal-edit-form', function(event) {
                var npm = event.__livewire.params[0];
                $('#modalEditDosen').attr('data-npm', npm);
                $('#modalEditDosen').modal('show');
            });
            window.addEventListener('open-modal-validation-status', function(event) {
                var nidn = event.__livewire.params[0];
                $('#modalDetailDosen' + nidn).modal('hide');
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
                            id: nidn
                        })
                    } else {
                        $('#modalDetailDosen' + nidn).modal('show');
                    }
                });
            });
        </script>
    @endpush
</div>
