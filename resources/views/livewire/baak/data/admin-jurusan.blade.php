<div>
    <div class="main_content_iner overly_inner">
        <div class="container-fluid p-0 ">
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white">DATA ADMIN JURUSAN</h3>
                            <ol class="breadcrumb page_bradcam mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Data Admin Jurusan</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="white_card card_height_100 mb_20">
                        <div class="white_card_body">
                            <div class="">
                                <div class="table-responsive">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                        <div
                                            class="box-right d-flex justify-content-end lms_block row col-12 col-md-12">
                                            <div class="add_button ms-2 col-md-3 mb-2">
                                                <button data-bs-toggle="modal" data-bs-target="#modalAddAjur"
                                                    class="btn btn-primary col-12">
                                                    <div class="text-green"></div>Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start text-info bg-light">Nomor Induk Pegawai</th>
                                                <th class="text-center text-info bg-light">Nama</th>
                                                <th class="text-center text-info bg-light">Jurusan</th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_ajur as $admin_jurusan)
                                                <tr>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $admin_jurusan->nip }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $admin_jurusan->name_admin_jurusan }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $admin_jurusan->name_jurusan }}</td>
                                                    <td>
                                                        <button data-bs-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailAjur{{ $admin_jurusan->nip }}"
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
    <div wire:ignore.self class="modal fade" id="modalAddAjur" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Admin Jurusan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Add_Ajur">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" for="inputEmail4">Nomor Induk Pegawai</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                    minlength="10" placeholder="Nomor Induk Pegawai" name="nip" required
                                    wire:model.defer="nip">
                                @error('nip')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name_admin_jurusan') is-invalid @enderror"
                                name="name_admin_jurusan" placeholder="Masukkan Nama Lengkap" required
                                wire:model.defer="name_admin_jurusan" required>
                            @error('name_admin_jurusan')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="inputEmail4">Email</label>
                                <input type="email"
                                    class="form-control @error('email_admin_jurusan') is-invalid @enderror"
                                    placeholder="Email" name="email_admin_jurusan" required
                                    wire:model.defer="email_admin_jurusan">
                                @error('email_admin_jurusan')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class=" col-md-6">
                                <label class="form-label" for="inputPassword4">No. Handphone</label>
                                <input type="text"
                                    class="form-control @error('no_hp_admin_jurusan') is-invalid @enderror"
                                    id="inputPassword4" maxlength="13" placeholder="Nomor Handphone" required
                                    minlength="12" wire:model.defer="no_hp_admin_jurusan" name="no_hp_admin_jurusan">
                                @error('no_hp_admin_jurusan')
                                    <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <fieldset class>
                            <div class="row">
                                <div class="col-form-label col-sm-4 pt-0">Jenis Kelamin</div>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="jenis_kelamin_admin_jurusan" value="L"
                                            wire:model.defer="jenis_kelamin_admin_jurusan" required>
                                        <label class="form-label form-check-label" for="gridRadios1">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="jenis_kelamin_admin_jurusan" value="P"
                                            wire:model.defer="jenis_kelamin_admin_jurusan" required>
                                        <label class="form-label form-check-label" for="gridRadios2">
                                            Perempuan
                                        </label>
                                    </div>
                                    @error('jenis_kelamin_admin_jurusan')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat_admin_jurusan') is-invalid @enderror" required
                                wire:model.defer="alamat_admin_jurusan" name="alamat_admin_jurusan" cols="10" rows="5"></textarea>
                            @error('alamat_admin_jurusan')
                                <label class="form-label text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <select class="form-select" wire:model.defer="jurusan" name="jurusan" required>
                                    <option selected>Jurusan</option>
                                    @foreach ($data_jurusan as $jurusan)
                                        <option value="{{ $jurusan->id_jurusan }}">
                                            {{ $jurusan->name_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jurusan')
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
    @foreach ($data_ajur as $detail_admin_jurusan)
        <div wire:ignore.self class="modal fade" id="modalDetailAjur{{ $detail_admin_jurusan->nip }}"
            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Admin Jurusan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="col-12 ">
                            <tr class="row" valign = "top">
                                <td class="col-md-6 col-lg-6">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Nomor Induk Pegawai</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_admin_jurusan->nip }}</th>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_admin_jurusan->name_admin_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_admin_jurusan->jk_admin_jurusan == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_admin_jurusan->email_admin_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>No. Handphone</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_admin_jurusan->no_hp_admin_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_admin_jurusan->alamat_admin_jurusan }}</th>
                                        </tr>
                                    </table>
                                </td>
                                <td class="col-md-6 col-lg-6">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Jurusan</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_admin_jurusan->name_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th><a
                                                    class="status_btn {{ $detail_admin_jurusan->status_admin_jurusan == 1 ? '' : 'bg-danger' }}">{{ $detail_admin_jurusan->status_admin_jurusan == 1 ? 'aktif' : 'tidak aktif' }}</a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Terakhir</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>
                                                {{ !is_null($detail_admin_jurusan->last_login) ? date('d F Y H:i:s', strtotime($detail_admin_jurusan->last_login)) : '-' }}
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning text-light"
                            wire:click="show_resetajur('{{ $detail_admin_jurusan->nip }}')"><i
                                class="ti-back-left"></i>&nbsp;Reset</button>
                        <button type="button" class="btn btn-success text-light"
                            wire:click="show_editajur('{{ $detail_admin_jurusan->nip }}')"><i
                                class="ti-pencil-alt"></i>&nbsp;Ubah</button>
                        @if ($detail_admin_jurusan->status_admin_jurusan == 0)
                            <button type="button" class="btn btn-info text-light"
                                wire:click="show_modalstatus('{{ $detail_admin_jurusan->nip }}')"><i
                                    class="ti-check-box"></i>&nbsp;Status</button>
                        @endif
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btn_close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    <div wire:ignore.self class="modal fade" id="modalEditAjur" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Data Admin Jurusan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Edit_Ajur">
                        <input type="text" name="nip_edit_hide" hidden wire:model.defer="nip_edit_hide">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Nomor Induk Pegawai</label>
                                <input type="text" class="form-control" placeholder="Nomor Induk Pegawai"
                                    name="nip_edit" wire:model.defer="nip_edit" disabled>
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
                        <div class="row mb-3">
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
                                <div class="col-form-label col-sm-4 pt-0">Jenis Kelamin</div>
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
                            <textarea class="form-control @error('alamat_admin_jurusan_edit') is-invalid @enderror" required
                                wire:model.defer="alamat_admin_jurusan_edit" name="alamat_admin_jurusan_edit" cols="10" rows="5"></textarea>
                            @error('alamat_admin_jurusan_edit')
                                <label class="form-label text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <select class="form-select" wire:model.defer="jurusan_edit" name="jurusan_edit"
                                    required>
                                    <option selected>Jurusan</option>
                                    @foreach ($data_jurusan as $jurusan)
                                        <option value="{{ $jurusan->id_jurusan }}">
                                            {{ $jurusan->name_jurusan }}
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

            window.addEventListener('close-Load', function() {
                $('#Load').modal('hide');
            });
            window.addEventListener('close-modal-form', function() {
                $('#modalAddAjur').modal('hide');
            });
            window.addEventListener('close-modal-detail', function(event) {
                $('#modalDetailAjur' + event.__livewire.params[0]).modal('hide');
            });
            window.addEventListener('close-modal-edit-form', function() {
                $('#modalEditAjur').modal('hide');
            });
            window.addEventListener('open-modal-edit-form', function(event) {
                var nip = event.__livewire.params[0];
                $('#modalEditAjur').attr('data-nip', nip);
                $('#modalEditAjur').modal('show');
            });
            window.addEventListener('open-modal-validation-status', function(event) {
                var nip = event.__livewire.params[0];
                $('#modalDetailAjur' + nip).modal('hide');
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
                            id: nip
                        })
                    } else {
                        $('#modalDetailAjur' + nip).modal('show');
                    }
                });
            });
            window.addEventListener('open-modal-validation-reset', function(event) {
                var nip = event.__livewire.params[0];
                $('#modalDetailAjur' + nip).modal('hide');
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
                        Livewire.dispatch('ResetPass', {
                            id: nip
                        })
                    } else {
                        $('#modalDetailAjur' + nip).modal('show');
                    }
                });
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
