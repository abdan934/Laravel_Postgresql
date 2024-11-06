<div>
    <div class="row flex-lg-nowrap">

        <div class="col">
            <div class="row">
                <div class="col mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="e-profile">
                                <div class="row">
                                    <div class="col-12 col-sm-auto mb-3">
                                        <div class="mx-auto" style="width: 140px;">
                                            <div class="d-flex justify-content-center align-items-center rounded"
                                                style="height: 140px; background-color: rgb(233, 236, 239);">
                                                <span
                                                    style="color: rgb(166, 168, 170); font: bold 8pt Arial;display: inline-block; text-align: center; width: 100%; height: 100%;"><img
                                                        src="{{ asset('photo/pp/' . $user->photo_profile) }}"
                                                        style="max-width: 100%; max-height: 100%;"
                                                        id="profileImage"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-left text-sm-left mb-2 mb-sm-0">
                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ $user->name_user }}</h4>
                                            <p class="mb-0">{{ $user->username }}</p>
                                            <div class="text-muted"><small>Terakhir. {{ $user->last_login }}
                                                </small>
                                            </div>
                                            <div class="mt-2 row">
                                                <div class="col-12">
                                                    <button class="btn btn-primary" type="button" id="ubahFotoBtn">
                                                        <i class="fa fa-fw fa-camera"></i>
                                                        <span>Ubah Foto</span>
                                                    </button>
                                                </div>
                                                <div class="d-flex col-2">
                                                    <input type="file" style="display: none;" id="uploadFotoInput"
                                                        wire:model="profile_photo">
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        document.getElementById('ubahFotoBtn').addEventListener('click', function() {
                                                            document.getElementById('uploadFotoInput').click();
                                                        });
                                                        document.getElementById('uploadFotoInput').addEventListener('change', function(event) {
                                                            const file = event.target.files[0];
                                                            if (file && file.type.startsWith('image/')) {
                                                                const reader = new FileReader();
                                                                reader.onload = function(e) {
                                                                    document.getElementById('profileImage').src = e.target.result;
                                                                }
                                                                reader.readAsDataURL(file);
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="text-center text-sm-right">
                                            <div class="text-muted"><small>Joined
                                                    {{ date('d M Y', strtotime($user->created_at)) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs">

                                </ul>
                                <div class="tab-content pt-3">
                                    <div class="tab-pane active">
                                        <form class="form" wire:submit.prevent="Update_Profile">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Nama Lengkap</label>
                                                                <input class="form-control" type="text"
                                                                    placeholder="{{ $user->name_user }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input class="form-control" type="text"
                                                                    placeholder="{{ $user->username }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <fieldset class>
                                                            <div class="row">
                                                                <div class="col-form-label col-sm-2 pt-0">Jenis Kelamin
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            {{ $user->jk_user == 'L' ? 'checked' : '' }}
                                                                            disabled>
                                                                        <label class="form-label form-check-label"
                                                                            for="gridRadios1">
                                                                            Laki-laki
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            {{ $user->jk_user == 'P' ? 'checked' : '' }}
                                                                            disabled>
                                                                        <label class="form-label form-check-label"
                                                                            for="gridRadios2">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-sm-12 mb-3">
                                                    <div class="mb-2"><b>Ganti Password</b></div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Password Lama</label>
                                                                <input
                                                                    class="form-control @if (session()->has('gagal')) is-invalid @endif"
                                                                    type="password" placeholder="••••••"
                                                                    wire:model.defer="password_lama">
                                                                @if (session()->has('gagal'))
                                                                    <label
                                                                        class="form-label text-danger">{{ session('gagal') }}</label>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Password Baru</label>
                                                                <input
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    type="password" placeholder="••••••"
                                                                    wire:model.defer="password"
                                                                    id="password_confirmation">
                                                                @error('password')
                                                                    <label
                                                                        class="form-label text-danger">{{ $message }}</label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Konfirmasi <span
                                                                        class="d-none d-xl-inline">Password</span></label>
                                                                <input
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    type="password" placeholder="••••••"
                                                                    wire:model.defer="password_confirmation">
                                                                @error('password')
                                                                    <label
                                                                        class="form-label text-danger">{{ $message }}</label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">Simpan
                                                        Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
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
            document.addEventListener('DOMContentLoaded', function() {

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
        </script>
    @endpush
</div>
