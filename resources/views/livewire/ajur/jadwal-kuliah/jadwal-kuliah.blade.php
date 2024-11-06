<div>
    <div class="main_content_iner overly_inner">
        <div class="container-fluid p-0 ">
            <div class="page_title_box d-flex align-items-center justify-content-between">
                <div class="page_title_left">
                    <h3 class="f_s_30 f_w_700 text_white">JADWAL KULIAH JURUSAN {{ $ajur->name_jurusan }}</h3>
                    <ol class="breadcrumb page_bradcam mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Jadwal Kuliah </a></li>
                    </ol>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="white_card card_height_100 mb_20">
                        <div class="white_card_body">
                            <div class="">
                                <div class="table-responsive" id="table_dosen" style="display: block">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                        <div class="add_button ms-2 mb-2 col-md-3">
                                            <button data-bs-toggle="modal" data-bs-target="#modalAddJadwalKuliah"
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
                                                <th class="text-start text-info bg-light">Tahun Ajaran
                                                </th>
                                                <th class="text-start text-info bg-light">Semester</th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($file_jadwal_kuliah as $jadwal_kuliah)
                                                <tr>
                                                    <td style="text-align: center;vertical-align: top;">
                                                        {{ $no++ }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $jadwal_kuliah->tahun_file_jadwal }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $jadwal_kuliah->semester_file_jadwal == 1 ? 'Ganjil' : 'Genap' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            wire:click="getFile('{{ $jadwal_kuliah->id_file_jadwal }}',1)"
                                                            class="btn btn-outline-link text-success rounded-pill mb-3"><i
                                                                class="bi bi-file-earmark-excel"></i></button>
                                                        <button
                                                            wire:click="getFile('{{ $jadwal_kuliah->id_file_jadwal }}',0)"
                                                            class="btn btn-outline-link text-danger rounded-pill mb-3"><i
                                                                class="bi bi-file-earmark-pdf"></i></button>
                                                        <button type="button"
                                                            wire:click="show_editjadwalkuliah('{{ $jadwal_kuliah->id_file_jadwal }}')"
                                                            class="btn btn-outline-link text-primary rounded-pill mb-3"><i
                                                                class="ti-pencil"></i></button>
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
    <div wire:ignore.self class="modal fade" id="modalAddJadwalKuliah" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah File Jadwal Kuliah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Add_Jadwal_Kuliah">
                        <div class="mb-3 col-12">
                            <select class="form-select @error('tahun_ajaran')is-invalid @enderror"
                                wire:model.defer="tahun_ajaran" name="tahun_ajaran" required>
                                <option selected>Tahun Ajaran</option>
                                @php
                                    $tahun_sekarang = date('Y');
                                @endphp
                                @for ($tahun = 2020; $tahun <= $tahun_sekarang; $tahun++)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endfor
                            </select>
                        </div>
                        <fieldset class>
                            <div class="row">
                                <div class="col-form-label col-sm-4 pt-0 fw-bold">Semester</div>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="semester_jadwal"
                                            value="1" wire:model.defer="semester_jadwal" required>
                                        <label class="form-label form-check-label" for="gridRadios1">
                                            Ganjil
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="semester_jadwal"
                                            value="0" wire:model.defer="semester_jadwal" required>
                                        <label class="form-label form-check-label" for="gridRadios2">
                                            Genap
                                        </label>
                                    </div>
                                    @error('semester_jadwal')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">File Excel Jadwal Kuliah</label>
                                <label class="text-success"><i class="bi bi-file-earmark-excel"></i></label><br>
                                <input type="file" class=" @error('file_excel_jadwal') is-invalid @enderror"
                                    wire:model="file_excel_jadwal" id="addFileExcel" required> <br>
                                @error('file_excel_jadwal')
                                    <label class="form-label text-danger"
                                        id="label_error_import">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label fw-bold">File PDF Jadwal Kuliah</label>
                                <label class="text-danger"><i class="bi bi-file-earmark-pdf"></i></label><br>
                                <input type="file" class=" @error('file_pdf_jadwal') is-invalid @enderror"
                                    wire:model="file_pdf_jadwal" id="addFilePDF" required> <br>
                                @error('file_pdf_jadwal')
                                    <label class="form-label text-danger"
                                        id="label_error_import">{{ $message }}</label>
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

    {{-- Modal Edit --}}
    <div wire:ignore.self class="modal fade" id="modalEditJadwalKuliah" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah File Jadwal Kuliah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Edit_Jadwal_Kuliah">
                        <input type="text" name="id_edit_hide" hidden wire:model.defer="id_edit_hide">
                        <div class="mb-3 col-12">
                            <select class="form-select @error('tahun_ajaran_edit')is-invalid @enderror"
                                wire:model.defer="tahun_ajaran_edit" name="tahun_ajaran_edit" required>
                                <option selected>Tahun Ajaran</option>
                                @php
                                    $tahun_sekarang = date('Y');
                                @endphp
                                @for ($tahun = 2020; $tahun <= $tahun_sekarang; $tahun++)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endfor
                            </select>
                        </div>
                        <fieldset class>
                            <div class="row">
                                <div class="col-form-label col-sm-4 pt-0 fw-bold">Semester</div>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="semester_jadwal_edit"
                                            value="1" wire:model.defer="semester_jadwal_edit" required>
                                        <label class="form-label form-check-label" for="gridRadios1">
                                            Ganjil
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="semester_jadwal_edit"
                                            value="0" wire:model.defer="semester_jadwal_edit" required>
                                        <label class="form-label form-check-label" for="gridRadios2">
                                            Genap
                                        </label>
                                    </div>
                                    @error('semester_jadwal_edit')
                                        <label class="form-label text-danger"
                                            for="inputPassword4">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">File Excel Jadwal Kuliah</label>
                                <label class="text-success"><i class="bi bi-file-earmark-excel"></i></label><br>
                                <input type="file" class=" @error('file_excel_jadwal_edit') is-invalid @enderror"
                                    wire:model="file_excel_jadwal_edit" id="addFileExcel" required> <br>
                                @error('file_excel_jadwal_edit')
                                    <label class="form-label text-danger"
                                        id="label_error_import">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label fw-bold">File PDF Jadwal Kuliah</label>
                                <label class="text-danger"><i class="bi bi-file-earmark-pdf"></i></label><br>
                                <input type="file" class=" @error('file_pdf_jadwal_edit') is-invalid @enderror"
                                    wire:model="file_pdf_jadwal_edit" id="addFilePDF" required> <br>
                                @error('file_pdf_jadwal_edit')
                                    <label class="form-label text-danger"
                                        id="label_error_import">{{ $message }}</label>
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
                window.addEventListener('NewTab', function(event) {
                    let link = document.createElement('a');
                    link.href = event.__livewire.params[0];
                    link.target = '_blank';
                    link.click();
                });

                window.addEventListener('close-Load', function() {
                    swalAlert.close();
                });
            });

            window.addEventListener('close-modal-form', function() {
                $('#modalAddJadwalKuliah').modal('hide');
            });

            document.getElementById('addButton').addEventListener('click', function() {
                var fileInput1 = document.getElementById('addFileExcel');
                var fileInput2 = document.getElementById('addFilePDF');
                var file1 = fileInput1.files[0];
                var fileName1 = file1.name;
                var fileExtension1 = fileName1.split('.').pop().toLowerCase();
                var file2 = fileInput2.files[0];
                var fileName2 = file2.name;
                var fileExtension2 = fileName2.split('.').pop().toLowerCase();
                var fileSizeMB1 = file1.size / (1024 * 1024);
                var fileSizeMB2 = file2.size / (1024 * 1024);
                var maxFileSizeMB = 10;

                if (((fileExtension1 === 'xlsx' || fileExtension1 === 'xls') && file1 && file1.size > 0 &&
                        fileSizeMB1 <= maxFileSizeMB) && (fileExtension2 === 'pdf' && file2 && file2.size >
                        0 && fileSizeMB2 <= maxFileSizeMB)) {
                    Livewire.dispatch('close-modal-form');
                    Livewire.dispatch('Load');
                }
            });
            window.addEventListener('close-modal-edit-form', function() {
                $('#modalEditJadwalKuliah').modal('hide');
            });
            window.addEventListener('open-modal-add-form', function() {
                $('#modalAddJadwalKuliah').modal('show');
            });
            window.addEventListener('open-modal-edit-form', function(event) {
                var id = event.__livewire.params[0];
                $('#modalEditJadwalKuliah').attr('data-id', id);
                $('#modalEditJadwalKuliah').modal('show');
            });
        </script>
    @endpush
</div>
