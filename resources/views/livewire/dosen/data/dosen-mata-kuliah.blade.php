<div>
    <div class="main_content_iner overly_inner">
        <div class="p-0 container-fluid ">
            <div class="page_title_box d-flex align-items-center justify-content-between">
                <div class="page_title_left">
                    <h3 class="f_s_30 f_w_700 text_white">MATA KULIAH </h3>
                    <ol class="mb-0 breadcrumb page_bradcam">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Mata Kuliah </a></li>
                    </ol>
                </div>
            </div>
            @if ($form == 0)
                <div class="mt-3 row" id="data_matkul">
                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_20">
                            <div class="white_card_body col-12">
                                <div class="table-responsive">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                    </div>
                                    <table id="example1" class="table table-hover" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-start text-info bg-light">Mata Kuliah
                                                </th>
                                                <th class="text-start text-info bg-light"> <label
                                                        style="font-style: italic">Course</label>
                                                </th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mata_kuliah as $matkul)
                                                <tr>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $matkul->nama_matkul_ind }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        <label
                                                            style="font-style: italic">{{ $matkul->nama_matkul_eng }}</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <button wire:click="KMtoInput('{{ $matkul->kode_mengajar }}')"
                                                            class="mb-3 btn btn-outline-link text-danger rounded-pill"><i
                                                                class="bi bi-file-text-fill"></i></button>
                                                        <button
                                                            wire:click="KMtoInputEdit('{{ $matkul->kode_mengajar }}')"
                                                            class="mb-3 btn btn-outline-link text-primary rounded-pill"><i
                                                                class="bi bi-pencil-square"></i></button>
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
            @elseif($form == 1)
                <div class="mt-3 row" id="form_nilai">
                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_20">
                            <div class="white_card_body">
                                <h4>Penilaian Mata Kuliah</h4>
                                <div class="card-body">
                                    <form wire:submit.prevent="Add_Nilai">
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Kode Mengajar</label>
                                                <input type="text" class="form-control" placeholder="Kode Mengajar"
                                                    wire:model.defer="km_nilai" required readonly>
                                            </div>
                                            <div class=" col-md-6">
                                                <label class="form-label fw-bold">Mata Kuliah</label>
                                                <input type="text" class="form-control" placeholder="Mata Kuliah"
                                                    wire:model.defer="nama_matkul_nilai" required readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nomor Pokok
                                                    Mahasiswa</label>
                                                <input type="text" class="form-control" wire:model.defer="npm_nilai"
                                                    required placeholder="Nomor Pokok Mahasiswa" readonly>
                                            </div>
                                            <div class=" col-md-6">
                                                <label class="form-label fw-bold">Nama
                                                    Mahasiswa</label>
                                                <input type="text" class="form-control" placeholder="Nama Mahasiswa"
                                                    wire:model.defer="nama_mhs_nilai" required readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Kelas</label>
                                                <select class="form-control @error('kelas_nilai') is-invalid @enderror"
                                                    wire:model.defer="kelas_nilai" required>
                                                    <option value="" selected>Choose...</option>
                                                    <option value="1A">1A</option>
                                                    <option value="1B">1B</option>
                                                    <option value="1C">1C</option>
                                                    <option value="1D">1D</option>
                                                    <option value="2A">2A</option>
                                                    <option value="2B">2B</option>
                                                    <option value="2C">2C</option>
                                                    <option value="2D">2D</option>
                                                    <option value="3A">3A</option>
                                                    <option value="3B">3B</option>
                                                    <option value="3C">3C</option>
                                                    <option value="3D">3D</option>
                                                </select>
                                                @error('kelas_nilai')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label fw-bold" for="inputState">Tahun Ajaran
                                                @error('ta_awal_nilai')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">*{{ $message }}</label>
                                                @enderror
                                            </label>
                                            <div class="divider-label-container">
                                                <select
                                                    class="form-control @error('ta_awal_nilai') is-invalid @enderror"
                                                    wire:model.defer="ta_awal_nilai" required>
                                                    <option value="" selected>Choose...</option>
                                                    @php
                                                        $tahun_sekarang = date('Y');
                                                    @endphp
                                                    @for ($tahun = 2020; $tahun <= $tahun_sekarang; $tahun++)
                                                        <option value="{{ $tahun }}">{{ $tahun }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <label class="form-label fw-bold divider-label"
                                                    style="font-size: 3vh">/</label>
                                                <select
                                                    class="form-control @error('ta_akhir_nilai') is-invalid @enderror"
                                                    wire:model.defer="ta_akhir_nilai" required>
                                                    <option value="" selected>Choose...</option>
                                                    @php
                                                        $tahun_sekarang = date('Y');
                                                    @endphp
                                                    @for ($tahun = 2020; $tahun <= $tahun_sekarang + 1; $tahun++)
                                                        <option value="{{ $tahun }}">{{ $tahun }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold" for="inputState">Semester
                                                    @error('semester_nilai')
                                                        <label class="form-label text-danger">*{{ $message }}</label>
                                                    @enderror
                                                </label>
                                                <select
                                                    class="form-control @error('semester_nilai') is-invalid @enderror"
                                                    wire:model.defer="semester_nilai" required>
                                                    <option value="">Choose...</option>
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                    <option value="IV">IV</option>
                                                    <option value="V">V</option>
                                                    <option value="VI">VI</option>
                                                    <option value="VII">VII</option>
                                                    <option value="VIII">VIII</option>
                                                    <option value="IX">IX</option>
                                                    <option value="X">X</option>
                                                    <option value="XI">XI</option>
                                                    <option value="XII">XII</option>
                                                    <option value="XIII">XIII</option>
                                                    <option value="XIV">XIV</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">SKS</label>
                                                <input type="number"
                                                    class="form-control @error('sks_nilai') is-invalid @enderror"
                                                    required wire:model.defer="sks_nilai"
                                                    placeholder="Satuan Kredit Semester" min="1">
                                                @error('sks_nilai')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Alpha</label>
                                                        <input type="number"
                                                            class="form-control @error('alpha_nilai') is-invalid @enderror"
                                                            min="0" required value="0"
                                                            wire:model.defer="alpha_nilai">
                                                        @error('alpha_nilai')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Sakit</label>
                                                        <input type="number"
                                                            class="form-control @error('sakit_nilai') is-invalid @enderror"
                                                            min="0" required value="0"
                                                            wire:model.defer="sakit_nilai">
                                                        @error('sakit_nilai')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Izin</label>
                                                        <input type="number"
                                                            class="form-control @error('izin_nilai') is-invalid @enderror"
                                                            min="0" required value="0"
                                                            wire:model.defer="izin_nilai">
                                                        @error('izin_nilai')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Catatan</label>
                                                <textarea type="text" class="form-control" wire:model.defer="catatan_nilai"></textarea>
                                                @error('catatan_nilai')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3 col-md-12 row">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Lain-lain</label>
                                                    <div class="input-group">
                                                        <input type="number"
                                                            class="form-control @error('prosentase_lain_nilai') is-invalid @enderror"
                                                            placeholder="Masukkan Presentase nilai"
                                                            wire:model.defer="prosentase_lain_nilai" required
                                                            min="20" max="40">
                                                        <label class="form-label fw-bold"
                                                            style="font-size: 3dvh">&nbsp;%</label>
                                                    </div>
                                                    @error('prosentase_lain_nilai')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nilai</label>
                                                    <input type="number"
                                                        class="form-control @error('lain_nilai') is-invalid @enderror"
                                                        placeholder="Masukkan Nilai" wire:model.defer="lain_nilai"
                                                        value="0" min="0" max="100">
                                                    @error('lain_nilai')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-12 row">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Ujian Tengah
                                                        Semester(UTS)</label>
                                                    <div class="input-group">
                                                        <input type="number"
                                                            class="form-control @error('prosentase_uts_nilai') is-invalid @enderror"
                                                            placeholder="Masukkan Presentase nilai"
                                                            wire:model.defer="prosentase_uts_nilai" required
                                                            min="20" max="40" required>
                                                        <label class="form-label fw-bold"
                                                            style="font-size: 3dvh">&nbsp;%</label>
                                                    </div>
                                                    @error('prosentase_uts_nilai')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nilai</label>
                                                    <input type="number"
                                                        class="form-control @error('uts_nilai') is-invalid @enderror"
                                                        placeholder="Masukkan Nilai" wire:model.defer="uts_nilai"
                                                        value="0" min="0" max="100" required>
                                                    @error('uts_nilai')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-12 row">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Ujian Akhir Semester(UAS)</label>
                                                    <div class="input-group">
                                                        <input type="number"
                                                            class="form-control @error('prosentase_uas_nilai') is-invalid @enderror"
                                                            placeholder="Masukkan Presentase nilai"
                                                            wire:model.defer="prosentase_uas_nilai" required
                                                            min="20" max="40">
                                                        <label class="form-label fw-bold"
                                                            style="font-size: 3dvh">&nbsp;%</label>
                                                    </div>
                                                    @error('prosentase_uas_nilai')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nilai</label>
                                                    <input type="number"
                                                        class="form-control @error('uas_nilai') is-invalid @enderror"
                                                        placeholder="Masukkan Nilai" wire:model.defer="uas_nilai"
                                                        required value="0" min="0" max="100">
                                                    @error('uas_nilai')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if ($hitung == 1)
                                                <div class="mb-3 col-md-6 row"
                                                    style="display: grid; grid-template-columns: 1fr 1fr;">
                                                    <div class="d-flex flex-column">
                                                        <label class="form-label fw-bold">Nilai </label>
                                                        <input type="number"
                                                            class="form-control @error('nilai') is-invalid @enderror"
                                                            placeholder="Nilai" wire:model.defer="nilai" required
                                                            readonly min="1" max="100">
                                                        @error('nilai')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <label class="form-label fw-bold">Predikat</label>
                                                        <input type="text"
                                                            class="form-control @error('predikat_nilai') is-invalid @enderror"
                                                            placeholder="Predikat" wire:model.defer="predikat_nilai"
                                                            readonly>
                                                        @error('predikat_nilai')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-secondary" wire:click="allreset()"
                                            onclick="refresh()">Kembali</button>
                                        <button type="button" class="btn btn-info"
                                            wire:click="HitungNilai()">Hitung</button>
                                        @if ($hitung == 1)
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($form == 2)
                <div class="mt-3 row">
                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_20">
                            <div class="white_card_body">
                                <h4>Penilaian Mata Kuliah</h4>
                                <div class="card-body">
                                    <form wire:submit.prevent="Edit_Nilai('{{ $this->id_nilai }}')">
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Kode Mengajar</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Kode Mengajar" wire:model.defer="km_nilai_edit"
                                                    required readonly>
                                            </div>
                                            <div class=" col-md-6">
                                                <label class="form-label fw-bold">Mata Kuliah</label>
                                                <input type="text" class="form-control" placeholder="Mata Kuliah"
                                                    wire:model.defer="nama_matkul_nilai_edit" required readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nomor Pokok
                                                    Mahasiswa</label>
                                                <input type="text" class="form-control"
                                                    wire:model.defer="npm_nilai_edit" required
                                                    placeholder="Nomor Pokok Mahasiswa" readonly>
                                            </div>
                                            <div class=" col-md-6">
                                                <label class="form-label fw-bold">Nama
                                                    Mahasiswa</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Nama Mahasiswa"
                                                    wire:model.defer="nama_mhs_nilai_edit" required readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Kelas</label>
                                                <select
                                                    class="form-control @error('kelas_nilai_edit') is-invalid @enderror"
                                                    wire:model.defer="kelas_nilai_edit" required>
                                                    <option value="" selected>Choose...</option>
                                                    <option value="1A">1A</option>
                                                    <option value="1B">1B</option>
                                                    <option value="1C">1C</option>
                                                    <option value="1D">1D</option>
                                                    <option value="2A">2A</option>
                                                    <option value="2B">2B</option>
                                                    <option value="2C">2C</option>
                                                    <option value="2D">2D</option>
                                                    <option value="3A">3A</option>
                                                    <option value="3B">3B</option>
                                                    <option value="3C">3C</option>
                                                    <option value="3D">3D</option>
                                                </select>
                                                @error('kelas_nilai_edit')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label fw-bold" for="inputState">Tahun Ajaran
                                                @error('ta_awal_nilai_edit')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">*{{ $message }}</label>
                                                @enderror
                                            </label>
                                            <div class="divider-label-container">
                                                <select
                                                    class="form-control @error('ta_awal_nilai_edit') is-invalid @enderror"
                                                    wire:model.defer="ta_awal_nilai_edit" required>
                                                    <option value="">Choose...</option>
                                                    @php
                                                        $tahun_sekarang = date('Y');
                                                    @endphp
                                                    @for ($tahun = 2020; $tahun <= $tahun_sekarang; $tahun++)
                                                        <option value="{{ $tahun }}">{{ $tahun }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <label class="form-label fw-bold divider-label"
                                                    style="font-size: 3vh">/</label>
                                                <select
                                                    class="form-control @error('ta_akhir_nilai_edit') is-invalid @enderror"
                                                    wire:model.defer="ta_akhir_nilai_edit" required>
                                                    <option value="" selected>Choose...</option>
                                                    @php
                                                        $tahun_sekarang = date('Y');
                                                    @endphp
                                                    @for ($tahun = 2020; $tahun <= $tahun_sekarang + 1; $tahun++)
                                                        <option value="{{ $tahun }}">{{ $tahun }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <select
                                                    class="form-control @error('semester_nilai_edit') is-invalid @enderror"
                                                    wire:model.defer="semester_nilai_edit" required>
                                                    <option value="">Choose...</option>
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                    <option value="IV">IV</option>
                                                    <option value="V">V</option>
                                                    <option value="VI">VI</option>
                                                    <option value="VII">VII</option>
                                                    <option value="VIII">VIII</option>
                                                    <option value="IX">IX</option>
                                                    <option value="X">X</option>
                                                    <option value="XI">XI</option>
                                                    <option value="XII">XII</option>
                                                    <option value="XIII">XIII</option>
                                                    <option value="XIV">XIV</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">SKS</label>
                                                <input type="number"
                                                    class="form-control @error('sks_nilai_edit') is-invalid @enderror"
                                                    required wire:model.defer="sks_nilai_edit"
                                                    placeholder="Satuan Kredit Semester" min="1">
                                                @error('sks_nilai_edit')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Alpha</label>
                                                        <input type="number"
                                                            class="form-control @error('alpha_nilai_edit') is-invalid @enderror"
                                                            min="0" required value="0"
                                                            wire:model.defer="alpha_nilai_edit">
                                                        @error('alpha_nilai_edit')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Sakit</label>
                                                        <input type="number"
                                                            class="form-control @error('sakit_nilai_edit') is-invalid @enderror"
                                                            min="0" required value="0"
                                                            wire:model.defer="sakit_nilai_edit">
                                                        @error('sakit_nilai_edit')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Izin</label>
                                                        <input type="number"
                                                            class="form-control @error('izin_nilai_edit') is-invalid @enderror"
                                                            min="0" required value="0"
                                                            wire:model.defer="izin_nilai_edit">
                                                        @error('izin_nilai_edit')
                                                            <label class="form-label text-danger"
                                                                for="inputPassword4">{{ $message }}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Catatan</label>
                                                <textarea type="text" class="form-control" wire:model.defer="catatan_nilai_edit"></textarea>
                                                @error('catatan_nilai_edit')
                                                    <label class="form-label text-danger"
                                                        for="inputPassword4">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3 col-md-12 row">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Lain-lain</label>
                                                    <div class="input-group">
                                                        <input type="number"
                                                            class="form-control @error('prosentase_lain_nilai_edit') is-invalid @enderror"
                                                            placeholder="Masukkan Presentase nilai"
                                                            wire:model.defer="prosentase_lain_nilai_edit" required
                                                            min="20" max="40">
                                                        <label class="form-label fw-bold"
                                                            style="font-size: 3dvh">&nbsp;%</label>
                                                    </div>
                                                    @error('prosentase_lain_nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nilai</label>
                                                    <input type="number"
                                                        class="form-control @error('lain_nilai_edit') is-invalid @enderror"
                                                        placeholder="Masukkan Nilai"
                                                        wire:model.defer="lain_nilai_edit" required min="1"
                                                        max="100">
                                                    @error('lain_nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-12 row">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Ujian Tengah
                                                        Semester(UTS)</label>
                                                    <div class="input-group">
                                                        <input type="number"
                                                            class="form-control @error('prosentase_uts_nilai_edit') is-invalid @enderror"
                                                            placeholder="Masukkan Presentase nilai"
                                                            wire:model.defer="prosentase_uts_nilai_edit" required
                                                            min="20" max="40">
                                                        <label class="form-label fw-bold"
                                                            style="font-size: 3dvh">&nbsp;%</label>
                                                    </div>
                                                    @error('prosentase_uts_nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nilai</label>
                                                    <input type="number"
                                                        class="form-control @error('uts_nilai_edit') is-invalid @enderror"
                                                        placeholder="Masukkan Nilai" wire:model.defer="uts_nilai_edit"
                                                        required min="1" max="100">
                                                    @error('uts_nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-12 row">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Ujian Akhir
                                                        Semester(UAS)</label>
                                                    <div class="input-group">
                                                        <input type="number"
                                                            class="form-control @error('prosentase_uas_nilai_edit') is-invalid @enderror"
                                                            placeholder="Masukkan Presentase nilai"
                                                            wire:model.defer="prosentase_uas_nilai_edit" required
                                                            min="20" max="40">
                                                        <label class="form-label fw-bold"
                                                            style="font-size: 3dvh">&nbsp;%</label>
                                                    </div>
                                                    @error('prosentase_uas_nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nilai</label>
                                                    <input type="number"
                                                        class="form-control @error('uas_nilai_edit') is-invalid @enderror"
                                                        placeholder="Masukkan Nilai" wire:model.defer="uas_nilai_edit"
                                                        required min="1" max="100">
                                                    @error('uas_nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6 row"
                                                style="display: grid; grid-template-columns: 1fr 1fr;">
                                                <div class="d-flex flex-column">
                                                    <label class="form-label fw-bold">Nilai </label>
                                                    <input type="number"
                                                        class="form-control @error('nilai_edit') is-invalid @enderror"
                                                        placeholder="Nilai" wire:model.defer="nilai_edit" required
                                                        readonly min="1" max="100">
                                                    @error('nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <label class="form-label fw-bold">Predikat</label>
                                                    <input type="text"
                                                        class="form-control @error('predikat_nilai_edit') is-invalid @enderror"
                                                        placeholder="Predikat" wire:model.defer="predikat_nilai_edit"
                                                        readonly>
                                                    @error('predikat_nilai_edit')
                                                        <label class="form-label text-danger"
                                                            for="inputPassword4">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary" wire:click="allreset()"
                                            onclick="refresh()">Kembali</button>
                                        <button type="button" class="btn btn-info"
                                            wire:click="HitungNilaiEdit()">Hitung</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal pilih Mahasiswa -->
    <div wire:ignore.self class="modal fade" id="modalPilihMhs" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Mahasiswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="allreset()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
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
                                        <th class="text-start text-info bg-light">Nomor Pokok Mahasiswa
                                        </th>
                                        <th class="text-start text-info bg-light">Nama
                                        </th>
                                        <th class="text-info bg-light"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data_mhs))
                                        @foreach ($data_mhs as $mahasiswa)
                                            <tr>
                                                <td style="text-align: left;vertical-align: top;">
                                                    {{ $mahasiswa->npm }}</td>
                                                <td style="text-align: left;vertical-align: top;">
                                                    <label>{{ $mahasiswa->name_mhs }}</label>
                                                </td>
                                                <td style="text-align: left;vertical-align: top;">
                                                    <button type="button" class="mb-3 btn btn-outline-primary col-12"
                                                        wire:click="NpmtoInput('{{ $mahasiswa->npm }}')">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close"
                        wire:click="allreset()">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pilih Mahasiswa for Edit -->
    <div wire:ignore.self class="modal fade" id="modalPilihMhsEdit" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Mahasiswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="allreset()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="col-md-12">
                            <div class="mb-2 col-md-2">
                                <form wire:submit.prevent="UpdatedsearchEdit">
                                    <div class="serach_field-area d-flex align-items-center">
                                        <div class="search_inner">
                                            <div class="search_field">
                                                <input type="text" wire:model.defer="searchEdit"
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
                                        <th class="text-start text-info bg-light">Nomor Pokok Mahasiswa
                                        </th>
                                        <th class="text-start text-info bg-light">Nama
                                        </th>
                                        <th class="text-start text-info bg-light">Tahun Ajaran
                                        </th>
                                        <th class="text-info bg-light"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data_nilai_mhs))
                                        @foreach ($data_nilai_mhs as $mahasiswa_edit)
                                            <tr>
                                                <td style="text-align: left;vertical-align: top;">
                                                    {{ $mahasiswa_edit->npm }}</td>
                                                <td style="text-align: left;vertical-align: top;">
                                                    <label>{{ $mahasiswa_edit->name_mhs }}</label>
                                                </td>
                                                <td style="text-align: left;vertical-align: top;">
                                                    <label>{{ $mahasiswa_edit->tahun_ajar_awal_nilai }}&nbsp;/&nbsp;{{ $mahasiswa_edit->tahun_ajar_akhir_nilai }}</label>
                                                </td>
                                                <td style="text-align: left;vertical-align: top;">
                                                    <button type="button" class="mb-3 btn btn-outline-primary col-12"
                                                        wire:click="NpmtoInputEdit('{{ $mahasiswa_edit->npm }}')">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close"
                        wire:click="allreset()">Tutup</button>
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

            window.addEventListener('close-modal-pilih-mhs', function() {
                $('#modalPilihMhs').modal('hide');
            });

            window.addEventListener('close-modal-pilih-mhs-edit', function() {
                $('#modalPilihMhsEdit').modal('hide');
            });
            window.addEventListener('open-modal-pilih-mhs', function() {
                $('#modalPilihMhs').modal('show');
            });
            window.addEventListener('open-modal-pilih-mhs-edit', function() {
                $('#modalPilihMhsEdit').modal('show');
            });

            function refresh() {
                location.reload();
            }
        </script>
    @endpush
</div>
