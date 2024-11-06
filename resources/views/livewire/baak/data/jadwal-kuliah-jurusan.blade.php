<div>
    <div class="main_content_iner overly_inner">
        <div class="container-fluid p-0 ">
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white">JADWAL KULIAH</h3>
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
                                            </div>
                                            <table id="example1" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-info bg-light">No.
                                                        </th>
                                                        <th class="text-start text-info bg-light">Jurusan
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
                                                                {{ $jadwal_kuliah->name_jurusan }}</td>
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
        </div>
    </div>


    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>

        <script>
            window.addEventListener('NewTab', function(event) {
                let link = document.createElement('a');
                link.href = event.__livewire.params[0];
                link.target = '_blank';
                link.click();
            });

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
        </script>
    @endpush
</div>
