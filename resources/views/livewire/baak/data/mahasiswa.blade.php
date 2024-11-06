<div>
    <div class="main_content_iner overly_inner">
        <div class="p-0 container-fluid ">
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white">DATA MAHASISWA</h3>
                            <ol class="mb-0 breadcrumb page_bradcam">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Data Mahasiswa</a></li>
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
                                                <button data-bs-toggle="modal" data-bs-target="#modalAddMhs"
                                                    class="btn btn-primary col-12">
                                                    <div class="text-green"></div>Tambah
                                                </button>
                                            </div>
                                            <div class="mb-2 add_button ms-2 col-md-3">
                                                <button data-bs-toggle="modal" data-bs-target="#modalImport"
                                                    class="btn btn-secondary col-12">Import</button>
                                            </div>
                                            <div class="mb-2 add_button ms-2 col-md-3">
                                                <a href="{{ asset('format/format_mahasiswa.xlsx') }}"
                                                    class="btn btn-success col-12">Format</a>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start text-info bg-light">Nomor Pokok Mahasiswa</th>
                                                <th class="text-center text-info bg-light">Nama</th>
                                                <th class="text-center text-info bg-light">Jurusan</th>
                                                <th class="text-center text-info bg-light">Prodi</th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_mhs as $mahasiswa)
                                                <tr>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $mahasiswa->npm }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $mahasiswa->name_mhs }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $mahasiswa->name_jurusan }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $mahasiswa->name_prodi }}</td>
                                                    <td>
                                                        <button data-bs-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailMhs{{ $mahasiswa->npm }}"
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
    <div wire:ignore.self class="modal fade" id="modalAddMhs" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Mahasiswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Add_Mhs">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label" for="inputEmail4">Nomor Pokok Mahasiswa</label>
                                <input type="text" class="form-control @error('npm') is-invalid @enderror"
                                    minlength="9" maxlength="9" placeholder="Nomor Pokok Mahasiswa" name="npm"
                                    required wire:model.defer="npm">
                                @error('npm')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" placeholder="Masukkan Nama Lengkap" required wire:model.defer="name"
                                required>
                            @error('name')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="form-label" for="inputEmail4">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email" name="email" required wire:model.defer="email">
                                @error('email')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class=" col-md-6">
                                <label class="form-label" for="inputPassword4">No. Handphone</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                    id="inputPassword4" maxlength="13" placeholder="Nomor Handphone" required
                                    minlength="12" wire:model.defer="no_hp" name="no_hp">
                                @error('no_hp')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <fieldset class>
                            <div class="row">
                                <div class="pt-0 col-form-label col-sm-4">Jenis Kelamin</div>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="L" wire:model.defer="jenis_kelamin" required>
                                        <label class="form-label form-check-label" for="gridRadios1">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="P" wire:model.defer="jenis_kelamin" required>
                                        <label class="form-label form-check-label" for="gridRadios2">
                                            Perempuan
                                        </label>
                                    </div>
                                    @error('jenis_kelamin')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                placeholder="Masukkan Tempat Lahir" required wire:model.defer="tempat_lahir" required>
                            @error('tempat_lahir')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                placeholder="Masukkan Tanggal Lahir" required wire:model.defer="tanggal_lahir"
                                required>
                            @error('tanggal_lahir')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat_mhs') is-invalid @enderror" required wire:model.defer="alamat_mhs"
                                name="alamat_mhs" cols="10" rows="5"></textarea>
                            @error('alamat_mhs')
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
                            <div class="mb-3 col-12">
                                <select class="form-select" wire:model.defer="tahun_masuk" name="tahun_masuk"
                                    required>
                                    <option selected>Tahun Masuk</option>
                                    @php
                                        $tahun_sekarang = date('Y');
                                    @endphp
                                    @for ($tahun = 2020; $tahun <= $tahun_sekarang; $tahun++)
                                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endfor
                                </select>
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
    @foreach ($data_mhs as $detail_mhs)
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
                                            <th>Tempat, Tanggal Lahir</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            @php
                                                $parts = explode(', ', $detail_mhs->tempat_tgl_lahir_mhs);
                                                $date = $parts[1];
                                                $formattedDate = date('d F Y', strtotime($date));
                                                $ttgl_lahir = $parts[0] . ', ' . $formattedDate;
                                            @endphp
                                            <th>{{ $ttgl_lahir }}</th>
                                        </tr>
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
                        <button type="button" class="btn btn-success text-light"
                            wire:click="show_editmhs('{{ $detail_mhs->npm }}')"><i
                                class="ti-pencil-alt"></i>&nbsp;Ubah</button>
                        <button type="button" class="btn btn-info text-light"
                            wire:click="show_modalstatus('{{ $detail_mhs->npm }}')"><i
                                class="ti-check-box"></i>&nbsp;Status</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btn_close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    <div wire:ignore.self class="modal fade" id="modalEditMhs" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Data Mahasiswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Edit_mhs">
                        <input type="text" name="npm_edit_hide" hidden wire:model.defer="npm_edit_hide">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">Nomor Pokok Mahasiswa</label>
                                <input type="text" class="form-control " placeholder="Nomor Pokok Mahasiswa"
                                    wire:model.defer="npm_edit" disabled>
                                @error('npm_edit')
                                    <label class="form-label text-danger"
                                        for="inputPassword4">{{ $message }}</label>
                                @enderror
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
                            <label class="form-label" for="inputAddress">Tempat Lahir</label>
                            <input type="text"
                                class="form-control @error('tempat_lahir_edit') is-invalid @enderror"
                                placeholder="Masukkan Tempat Lahir" required wire:model.defer="tempat_lahir_edit"
                                required>
                            @error('tempat_lahir_edit')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Tanggal Lahir</label>
                            <input type="date"
                                class="form-control @error('tanggal_lahir_edit') is-invalid @enderror"
                                placeholder="Masukkan Tanggal Lahir" required wire:model.defer="tanggal_lahir_edit"
                                required>
                            @error('tanggal_lahir_edit')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat_mhs_edit') is-invalid @enderror" required
                                wire:model.defer="alamat_mhs_edit" name="alamat_mhs_edit" cols="10" rows="5"></textarea>
                            @error('alamat_mhs_edit')
                                <label class="form-label text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <select class="form-select" wire:model.defer="jupro_edit" name="jupro_edit" required>
                                    <option selected>Jurusan --- Prodi</option>
                                    @foreach ($data_jupro as $jupro)
                                        <option
                                            value="{{ $jupro->id_jurusan . ' --- ' . $jupro->id_prodi }}"{{ $jupro_edit == $jupro->id_jurusan . ' --- ' . $jupro->id_prodi ? 'selected' : '' }}>
                                            {{ $jupro->jurusan_name . '  ---  ' . $jupro->name_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-12">
                                <select class="form-select" wire:model.defer="tahun_masuk_edit"
                                    name="tahun_masuk_edit" required>
                                    <option selected>Tahun Masuk</option>
                                    @php
                                        $tahun_sekarang = date('Y');
                                    @endphp
                                    @for ($tahun = 2020; $tahun <= $tahun_sekarang; $tahun++)
                                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endfor
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
                    <form wire:submit.prevent="importMhs">
                        <input type="file" class=" @error('file_import_mhs') is-invalid @enderror"
                            wire:model="file_import_mhs" id="importFile" required> <br>
                        @error('file_import_mhs')
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

            window.addEventListener('open-modal-validation-status', function(event) {
                var npm = event.__livewire.params[0];
                $('#modalDetailMhs' + npm).modal('hide');
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
                            id: npm
                        })
                    } else {
                        $('#modalDetailMhs' + npm).modal('show');
                    }
                });
            });
            window.addEventListener('open-modal-import', function() {
                $('#modalImport').modal('show');
            });
            window.addEventListener('open-modal-edit-form', function(event) {
                var npm = event.__livewire.params[0];
                $('#modalEditMhs').attr('data-npm', npm);
                $('#modalEditMhs').modal('show');
            });
            window.addEventListener('close-Load', function() {
                $('#Load').modal('hide');
            });
            window.addEventListener('close-modal-form', function() {
                $('#modalAddMhs').modal('hide');
                var pesanElement = document.getElementById('pesanBerhasil');
            });
            window.addEventListener('close-modal-detail', function(event) {
                $('#modalDetailMhs' + event.__livewire.params[0]).modal('hide');
            });
            window.addEventListener('close-modal-edit-form', function() {
                $('#modalEditMhs').modal('hide');
            });
            window.addEventListener('close-modal-import', function() {
                $('#modalImport').modal('hide');
            });
        </script>
    @endpush
</div>
