<div>
    <div class="main_content_iner">
        <div class="p-0 container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="dashboard_header mb_50">
                        <div class="row">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="modal-content cs_modal">
                                    <div class="modal-header justify-content-center theme_bg_1">
                                        <h5 class="text-center modal-title text_white">SISTEM INFORMASI AKADEMIK
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <form wire:submit.prevent="AuthUser">
                                            @if (session()->has('pesandanger'))
                                                <div class="text-white alert bg-danger d-flex align-items-center"
                                                    role="alert">
                                                    <div class="alert-icon me-2">
                                                        <i class="ti-alert"></i>
                                                    </div>
                                                    <div class="alert-text">
                                                        <b>{{ session('pesandanger') }}</b>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-auto mb-3">
                                                <input type="text" placeholder="Username" id="username_txt"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    wire:model.defer="username" required autofocus />
                                            </div>
                                            @error('username')
                                                <label for="" class="mb-3 text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="col-auto mb-3">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Password" wire:model.defer="password" required />
                                            </div>
                                            @error('password')
                                                <label for="" class="mb-3 text-danger">{{ $message }}</label>
                                            @enderror
                                            <button type="submit" class="text-center btn_1 full_width">Masuk</button>
                                            <div class="text-center">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#forgot_password" data-bs-dismiss="modal"
                                                    class="pass_forget_btn">Lupa Password?</a>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('Focus', function() {
                    document.getElementById('username_txt').focus();
                });
            });
        </script>
    @endpush

</div>
