<div>
    <div class="main_content_iner overly_inner">
        <div class="p-0 container-fluid ">
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white">STRUKTUR AKADEMIK</h3>
                            <ol class="mb-0 breadcrumb page_bradcam">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard </a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Struktur Akademik</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 row">
                <div class="col-lg-12">
                    <div class="white_card card_height_100 mb_20">
                        <div class="row">
                            <div class="col-lg-12 d-flex">
                                <div class="btn-group align-items-right justify-content-end" role="group"
                                    aria-label="Basic example">
                                    <button type="button" class="btn btn-outlite-light" onclick="showData('prodi')">
                                        <h4 id="btnProdi" style="color: #68c4b4">Prodi</h4>
                                    </button>
                                    <button type="button" class="btn btn-outlite-light" onclick="showData('jurusan')">
                                        <h4 id="btnJurusan">Jurusan</h4>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="">
                                <div class="table-responsive" id="table_prodi" style="display: block">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                        <div
                                            class="box-right d-flex justify-content-end lms_block row col-12 col-md-12">
                                            <div class="mb-2 add_button ms-2 col-md-3">
                                                <button data-bs-toggle="modal" data-bs-target="#modalAddProdi"
                                                    class="btn btn-primary col-12">
                                                    <div class="text-green"></div>Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-hover" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center text-info bg-light">No.</th>
                                                <th class="text-start text-info bg-light">Prodi</th>
                                                <th class="text-start text-info bg-light">Jurusan</th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($data_prodi as $struktur_akademik_prodi)
                                                <tr>
                                                    <td style="text-align: center;vertical-align: top;">
                                                        {{ $no++ }}</td>
                                                    <td style="text-align: start;vertical-align: top;">
                                                        {{ $struktur_akademik_prodi->jenjang_prodi . ' ' . $struktur_akademik_prodi->name_prodi }}
                                                    </td>
                                                    <td style="text-align: start;vertical-align: top;">
                                                        {{ $struktur_akademik_prodi->name_jurusan }}</td>
                                                    <td>
                                                        <button data-bs-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailJupro{{ $struktur_akademik_prodi->id_prodi }}"
                                                            class="btn btn-info text-light">Detail</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive" id="table_jurusan" style="display: none">
                                    <div class="white_box_tittle list_header">
                                        <h4></h4>
                                        <div
                                            class="box-right d-flex justify-content-end lms_block row col-12 col-md-12">
                                            <div class="mb-2 add_button ms-2 col-md-3">
                                                <button data-bs-toggle="modal" data-bs-target="#modalAddJurusan"
                                                    class="btn btn-primary col-12">
                                                    <div class="text-green"></div>Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example2" class="table table-hover" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center text-info bg-light">No.</th>
                                                <th class="text-start text-info bg-light">Jurusan</th>
                                                <th class="text-info bg-light"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no1 = 1;
                                            @endphp
                                            @foreach ($data_jurusan as $struktur_akademik_jurusan)
                                                <tr>
                                                    <td style="text-align: center;vertical-align: top;">
                                                        {{ $no1++ }}</td>
                                                    <td style="text-align: left;vertical-align: top;">
                                                        {{ $struktur_akademik_jurusan->name_jurusan }}</td>
                                                    <td>
                                                        <button data-bs-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailJurusan{{ $struktur_akademik_jurusan->id_jurusan }}"
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

    <!-- Modal tambah prodi -->
    <div wire:ignore.self class="modal fade" id="modalAddProdi" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Prodi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Add_Prodi">
                        <div class="mb-3 col-12">
                            <select class="form-select" wire:model.defer="jenjang_prodi" name="jurusan" required>
                                <option selected>Jenjang</option>
                                <option value="DI">
                                    DI
                                </option>
                                <option value="DII">
                                    DII
                                </option>
                                <option value="DIII">
                                    DIII
                                </option>
                                <option value="DIV">
                                    DIV
                                </option>
                                <option value="SI">
                                    SI
                                </option>
                            </select>
                            @error('jenjang_prodi')
                                <label class="form-label text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Nama Prodi</label>
                            <input type="text" class="form-control @error('name_prodi') is-invalid @enderror"
                                name="name_prodi" placeholder="Masukkan Nama Prodi" required
                                wire:model.defer="name_prodi" required>
                            @error('name_prodi')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
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

    <!-- Modal tambah jurusan -->
    <div wire:ignore.self class="modal fade" id="modalAddJurusan" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Jurusan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Add_Jurusan" class="mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Nama Jurusan</label>
                            <input type="text" class="form-control @error('name_jurusan') is-invalid @enderror"
                                name="name_jurusan" placeholder="Masukkan Nama Jurusan" required
                                wire:model.defer="name_jurusan" required>
                            @error('name_jurusan')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btn_close">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Prodi --}}
    @foreach ($data_prodi as $detail_struktur_akademik_prodi)
        <div wire:ignore.self class="modal fade" id="modalDetailJupro{{ $detail_struktur_akademik_prodi->id_prodi }}"
            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Struktur Akademik</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="col-12 ">
                            <tr class="row" valign = "top">
                                <td class="col-md-12 col-lg-12">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Prodi</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_struktur_akademik_prodi->name_prodi }}</th>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ date('d F Y', strtotime($detail_struktur_akademik_prodi->tb_prodi . $detail_struktur_akademik_prodi->created_at)) }}
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                                <td class="col-md-12 col-lg-12">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Jurusan</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_struktur_akademik_prodi->name_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>
                                                {{ date('d F Y', strtotime($detail_struktur_akademik_prodi->tb_jurusan . $detail_struktur_akademik_prodi->created_at)) }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Kepala Prodi</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>
                                                {{ empty($detail_struktur_akademik_prodi->name_dosen) ? '-' : $detail_struktur_akademik_prodi->name_dosen }}
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success text-light"
                            wire:click="show_editprodi('{{ $detail_struktur_akademik_prodi->id_prodi }}')"><i
                                class="ti-pencil-alt"></i>&nbsp;Ubah</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btn_close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    {{-- Modal Detail Jurusan --}}
    @foreach ($data_jurusan as $detail_struktur_akademik_jurusan)
        <div wire:ignore.self class="modal fade"
            id="modalDetailJurusan{{ $detail_struktur_akademik_jurusan->id_jurusan }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Struktur Akademik</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="col-12 ">
                            <tr class="row" valign = "top">
                                <td class="col-md-12 col-lg-12">
                                    <table class="table table-stripped" border="1">
                                        <tr>
                                            <th>Jurusan</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>{{ $detail_struktur_akademik_jurusan->name_jurusan }}</th>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>
                                                {{ $detail_struktur_akademik_jurusan->created_at->format('d M Y') }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Kepala Jurusan</th>
                                            <th>&nbsp;=&nbsp;</th>
                                            <th>
                                                {{ $detail_struktur_akademik_jurusan->name_dosen == null ? '-' : $detail_struktur_akademik_jurusan->name_dosen }}
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success text-light"
                            wire:click="show_editjurusan('{{ $detail_struktur_akademik_jurusan->id_jurusan }}')"><i
                                class="ti-pencil-alt"></i>&nbsp;Ubah</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btn_close_detail_jurusan">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit Prodi --}}
    <div wire:ignore.self class="modal fade" id="modalEditProdi" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Prodi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Edit_Prodi" class="mb-3">
                        <div class="mb-3 col-12">
                            <select class="form-select" wire:model.defer="jenjang_prodi_edit" name="jurusan"
                                required>
                                <option selected>Jenjang</option>
                                <option value="DI">
                                    DI
                                </option>
                                <option value="DII">
                                    DII
                                </option>
                                <option value="DIII">
                                    DIII
                                </option>
                                <option value="DIV">
                                    DIV
                                </option>
                                <option value="SI">
                                    SI
                                </option>
                            </select>
                            @error('jenjang_prodi')
                                <label class="form-label text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <input type="text" name="id_prodi_hide" hidden wire:model.defer="id_prodi_hide">
                        <div class="mb-3 row">
                            <label class="form-label" for="inputAddress">Nama Lengkap</label>
                            <div class="col-6">
                                <input type="text"
                                    class="form-control @error('name_prodi_edit') is-invalid @enderror"
                                    name="name_prodi_edit" placeholder="Masukkan Nama Lengkap" required
                                    wire:model.defer="name_prodi_edit" required>
                                @error('name_prodi_edit')
                                    <label class="form-label text-danger"
                                        for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-6">
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
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="form-label" for="inputAddress">NIDN</label>
                                <input type="text"
                                    class="form-control @error('nidn_jurusan_edit_prodi') is-invalid @enderror"
                                    name="nidn_jurusan_edit_prodi" wire:model.defer="nidn_jurusan_edit_prodi"
                                    readonly>
                                @error('nidn_jurusan_edit_prodi')
                                    <label class="form-label text-danger"
                                        for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="inputAddress">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control @error('nidn_jurusan_edit_prodi') is-invalid @enderror"
                                    name="nama_dosen_jurusan_edit_prodi"
                                    wire:model.defer="nama_dosen_jurusan_edit_prodi" readonly>
                                @error('nidn_jurusan_edit_prodi')
                                    <label class="form-label text-danger"
                                        for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                    <div class="col-md-12">
                        <div class="mb-2 col-md-2">
                            <form wire:submit.prevent="UpdatedsearchDosen">
                                <div class="serach_field-area d-flex align-items-center">
                                    <div class="search_inner">
                                        <div class="search_field">
                                            <input type="text" wire:model.defer="search_dosen"
                                                placeholder="Cari..." />
                                        </div>
                                        <button type="submit">
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
                                @if (isset($data_dosen_prodi))
                                    @foreach ($data_dosen_prodi as $dosen_prodi)
                                        <tr>
                                            <td style="text-align: left;vertical-align: top;">
                                                {{ $dosen_prodi->nidn }}</td>
                                            <td style="text-align: left;vertical-align: top;">
                                                <label>{{ $dosen_prodi->name_dosen }}</label>
                                            </td>
                                            <td style="text-align: left;vertical-align: top;">
                                                <button type="button" class="mb-3 btn btn-outline-primary col-12"
                                                    wire:click="dosentoInputProdi({{ $dosen_prodi->nidn }})">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close"
                        wire:click="close_modal_edit_form">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Jurusan --}}
    <div wire:ignore.self class="modal fade" id="modalEditJurusan" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Jurusan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="Edit_Jurusan" class="mb-3">
                        <input type="text" name="id_jurusan_hide" hidden wire:model.defer="id_jurusan_hide">
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Nama Lengkap</label>
                            <input type="text"
                                class="form-control @error('name_jurusan_edit') is-invalid @enderror"
                                name="name_jurusan_edit" placeholder="Masukkan Nama Lengkap" required
                                wire:model.defer="name_jurusan_edit" required>
                            @error('name_jurusan_edit')
                                <label class="form-label text-danger" for="inputPassword4">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="form-label" for="inputAddress">NIDN</label>
                                <input type="text"
                                    class="form-control @error('nidn_jurusan_edit') is-invalid @enderror"
                                    name="nidn_jurusan_edit" wire:model.defer="nidn_jurusan_edit" readonly>
                                @error('nidn_jurusan_edit')
                                    <label class="form-label text-danger"
                                        for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="inputAddress">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control @error('nidn_jurusan_edit') is-invalid @enderror"
                                    name="nama_dosen_jurusan_edit" wire:model.defer="nama_dosen_jurusan_edit"
                                    readonly>
                                @error('nidn_jurusan_edit')
                                    <label class="form-label text-danger"
                                        for="inputPassword4">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                    <div class="col-md-12">
                        <div class="mb-2 col-md-2">
                            <form wire:submit.prevent="UpdatedsearchDosen">
                                <div class="serach_field-area d-flex align-items-center">
                                    <div class="search_inner">
                                        <div class="search_field">
                                            <input type="text" wire:model.defer="search_dosen"
                                                placeholder="Cari..." />
                                        </div>
                                        <button type="submit">
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
                                                    wire:click="dosentoInput({{ $dosen->nidn }})">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close"
                        wire:click="close_modal_edit_form">Tutup</button>
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

            window.addEventListener('close-modal-form-prodi', function() {
                $('#modalAddProdi').modal('hide');
            });
            window.addEventListener('close-modal-form-jurusan', function() {
                $('#modalAddJurusan').modal('hide');
            });
            window.addEventListener('close-modal-detail-jurusan', function(event) {
                var id = event.__livewire.params[0];
                $('#btn_close_detail_jurusan').click();
                $('#modalDetailJurusan' + id).modal('hide');
            });
            window.addEventListener('close-modal-detail-prodi', function(event) {
                var id_prodi = event.__livewire.params[0];
                $('#modalDetailJupro' + id_prodi).modal('hide');
            });
            window.addEventListener('close-modal-edit-prodi', function() {
                $('#modalEditProdi').modal('hide');
            });
            window.addEventListener('close-modal-edit-jurusan', function() {
                $('#modalEditJurusan').modal('hide');
            });
            window.addEventListener('open-modal-edit-prodi', function(event) {
                var id_prodi = event.__livewire.params[0];
                $('#modalEditProdi').attr('data-id_prodi', id_prodi);
                $('#modalEditProdi').modal('show');
            });
            window.addEventListener('open-modal-edit-jurusan', function(event) {
                var id_jurusan = event.__livewire.params[0];
                $('#modalEditJurusan').attr('data-id_jurusan', id_jurusan);
                $('#modalEditJurusan').modal('show');
            });

            function showData(type) {
                if (type === 'prodi') {
                    document.getElementById('table_prodi').style.display = 'block';
                    document.getElementById('table_jurusan').style.display = 'none';
                    document.getElementById('btnProdi').style.color = '#68c4b4';
                    document.getElementById('btnJurusan').style.color = '';
                } else if (type === 'jurusan') {
                    document.getElementById('table_prodi').style.display = 'none';
                    document.getElementById('table_jurusan').style.display = 'block';
                    document.getElementById('btnJurusan').style.color = '#68c4b4';
                    document.getElementById('btnProdi').style.color = '';
                }
            }
        </script>
    @endpush
</div>
