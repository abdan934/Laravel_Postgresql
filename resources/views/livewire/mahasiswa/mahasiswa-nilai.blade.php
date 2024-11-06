<div>
    <style>
        /* CSS untuk menambahkan garis strip di setiap sel tabel */
        #example1 tr,
        #example1 td,
        #example1 th {
            border: 1px solid #ccc;
        }
    </style>
    <div class="main_content_iner overly_inner">
        <div class="p-0 container-fluid ">
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white">NILAI MATA KULIAH</h3>
                            <ol class="mb-0 breadcrumb page_bradcam">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Nilai Mata Kuliah </a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="mt-3 row">
                        <div class="col-lg-12">
                            <div class="white_card card_height_100 mb_20">
                                <div class="row">
                                    <div class="col-lg-12 d-flex">
                                        <div class="btn-group align-items-right justify-content-end" role="group"
                                            aria-label="Basic example">
                                            <button type="button" class="btn btn-outlite-light"
                                                wire:click="outputNilai(0)">
                                                <h4 class="{{ $displayNilai == 0 ? 'text-info' : 'text-dark' }}">
                                                    Per Semester</h4>
                                            </button>
                                            <button type="button" class="btn btn-outlite-light"
                                                wire:click="outputNilai(1)">
                                                <h4 class="{{ $displayNilai == 1 ? 'text-info' : 'text-dark' }}">
                                                    Transkrip</h4>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if ($displayNilai == 0)
                                    <div class="white_card_body">
                                        <div class="">
                                            <div class="table-responsive" id="table_dosen" style="display: block">
                                                <div
                                                    class="mt-2 white_box_tittle list_header d-flex justify-content-between row">
                                                    <div class="col-md-8">
                                                        <form class="align-items-start"
                                                            wire:submit.prevent="change_data_nilai">
                                                            <div
                                                                class="mb-3 d-flex flex-column flex-md-row align-items-start justify-content-start">
                                                                <!-- Tahun Ajaran -->
                                                                <div
                                                                    class="mb-2 me-md-3 mb-md-0 d-flex align-items-start">
                                                                    <label class="form-label fw-bold me-2"
                                                                        for="inputState">Tahun Ajaran</label>
                                                                    <div class="divider-label-container">
                                                                        <select
                                                                            class="form-control @error('tahun_ajar_nilai') is-invalid @enderror"
                                                                            wire:model.defer="tahun_ajar_nilai" required
                                                                            onchange="submitForm()">
                                                                            @foreach ($gettahunajaran as $tahunajaran)
                                                                                <option
                                                                                    {{ $tahun_ajar_nilai == $tahunajaran->tahun_ajar_awal_nilai . '/' . $tahunajaran->tahun_ajar_akhir_nilai ? 'selected' : '' }}
                                                                                    value="{{ $tahunajaran->tahun_ajar_awal_nilai . '/' . $tahunajaran->tahun_ajar_akhir_nilai }}">
                                                                                    {{ $tahunajaran->tahun_ajar_awal_nilai . '/' . $tahunajaran->tahun_ajar_akhir_nilai }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    @error('tahun_ajar_nilai')
                                                                        <span
                                                                            class="form-label text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <!-- Semester -->
                                                                <fieldset class="row">
                                                                    <legend class="pt-0 col-form-label fw-bold col-5">
                                                                        Semester :
                                                                    </legend>
                                                                    <div class="text-align-start col-6">
                                                                        <div class="form-check form-check-inline">
                                                                            <input
                                                                                class="form-check-input @error('semester_nilai') is-invalid @enderror"
                                                                                type="radio" required
                                                                                onchange="submitForm()"
                                                                                {{ $semester_nilai == 1 ? 'checked' : '' }}
                                                                                wire:model.defer="semester_nilai"
                                                                                value="1" required>
                                                                            <label class="form-label form-check-label"
                                                                                for="gridRadios1">Ganjil</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input
                                                                                class="form-check-input @error('semester_nilai') is-invalid @enderror"
                                                                                type="radio" onchange="submitForm()"
                                                                                {{ $semester_nilai == 0 ? 'checked' : '' }}
                                                                                wire:model.defer="semester_nilai"
                                                                                value="0" required>
                                                                            <label class="form-label form-check-label"
                                                                                for="gridRadios2">Genap</label>
                                                                        </div>
                                                                        @error('semester_nilai')
                                                                            <label class="form-label text-danger"
                                                                                for="inputPassword4">{{ $message }}</label>
                                                                        @enderror
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <button type="submit" id="submit" hidden></button>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-4 d-flex justify-content-end">
                                                        <button type="button" class="mb-3 btn btn-danger"
                                                            wire:click="cetakKHS()"><i
                                                                class="ti-printer f_s_14 me-2"></i>Cetak KHS</button>
                                                    </div>
                                                </div>

                                                <table id="example1" class="table table-hover table-stripped"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-start text-info bg-light">Kode Mata Kuliah
                                                            </th>
                                                            <th class="text-start text-info bg-light">Nama Mata Kuliah
                                                            </th>
                                                            <th class="text-start text-info bg-light">Predikat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($filteredNilaiList as $nilai)
                                                            <tr>
                                                                <td style="text-align: left;vertical-align: top;">
                                                                    {{ $nilai->kode_matkul }}</td>
                                                                <td style="text-align: left;vertical-align: top;">
                                                                    {{ $nilai->nama_matkul_ind }}</td>
                                                                <td style="text-align: right;vertical-align: top;">
                                                                    {{ $nilai->predikat }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td class="fw-bold" colspan="2"
                                                                style="text-align: center;vertical-align: center;">
                                                                Satuan Kredit Semester (SKS)
                                                            </td>
                                                            <td class="fw-bold"
                                                                style="text-align: right;vertical-align: center;">
                                                                {{ $totalSKS }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold" colspan="2"
                                                                style="text-align: center;vertical-align: center;">
                                                                Indeks Prestasi Semester (IPS)
                                                            </td>
                                                            <td class="fw-bold"
                                                                style="text-align: right;vertical-align: center;">
                                                                {{ $ips }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold" colspan="2"
                                                                style="text-align: center;vertical-align: center;">
                                                                Indeks Prestasi Kumulatif (IPK)
                                                            </td>
                                                            <td class="fw-bold"
                                                                style="text-align: right;vertical-align: center;">
                                                                {{ $ipk }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($displayNilai == 1)
                                    <div class="white_card_body">
                                        <div class="">
                                            <div class="table-responsive" id="table_dosen" style="display: block">
                                                <div
                                                    class="mt-2 white_box_tittle list_header d-flex justify-content-end">
                                                    <button type="button" class="mb-3 btn btn-danger"
                                                        wire:click="cetakTranskrip()"><i
                                                            class="ti-printer f_s_14 me-2"></i>Cetak
                                                        Transkrip</button>
                                                </div>
                                                <table id="example1" class="table table-hover table-stripped"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-start text-info bg-light">Kode Mata Kuliah
                                                            </th>
                                                            <th class="text-start text-info bg-light">Nama Mata Kuliah
                                                            </th>
                                                            <th class="text-start text-info bg-light">Predikat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($data_nilai['nilaiListAll'] as $nilaiAll)
                                                            <tr>
                                                                <td style="text-align: left;vertical-align: top;">
                                                                    {{ $nilaiAll->kode_matkul }}</td>
                                                                <td style="text-align: left;vertical-align: top;">
                                                                    {{ $nilaiAll->nama_matkul_ind }}</td>
                                                                <td style="text-align: right;vertical-align: top;">
                                                                    {{ $nilaiAll->predikatAll }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td class="fw-bold" colspan="2"
                                                                style="text-align: center;vertical-align: center;">
                                                                Satuan Kredit Semester (SKS)
                                                            </td>
                                                            <td class="fw-bold"
                                                                style="text-align: right;vertical-align: center;">
                                                                {{ $totalSKSAll }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold" colspan="2"
                                                                style="text-align: center;vertical-align: center;">
                                                                Indeks Prestasi Kumulatif (IPK)
                                                            </td>
                                                            <td class="fw-bold"
                                                                style="text-align: right;vertical-align: center;">
                                                                {{ $ipk }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
            function submitForm() {
                document.getElementById("submit").click();
            }

            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('Success', function(event) {
                    setTimeout(function() {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: event.__livewire.params[0],
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }, 1600);
                });
                window.addEventListener('Failed', function(event) {
                    setTimeout(function() {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Gagal!\n' + event.__livewire.params[0],
                            showConfirmButton: true,
                        });
                    }, 1600);
                });
                window.addEventListener('CetakKHS', function() {
                    setTimeout(function() {
                        window.open('{{ url('/mahasiswa/nilai-khs') }}', '_blank');
                    }, 1600);
                });
                window.addEventListener('Load', function() {
                    const swalAlert = Swal.fire({
                        title: "Sedang dalam Proses",
                        timerProgressBar: true,
                        timer: 1500,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    window.addEventListener('close-Load', function() {
                        swalAlert.close();
                    });
                });
            });
        </script>
    @endpush
</div>
