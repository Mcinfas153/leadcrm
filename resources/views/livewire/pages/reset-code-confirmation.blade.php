<div>
    <div wire:loading wire:target="verifyResetCode">
        <livewire:components.progress-loader/>
    </div>
    <div class="position-relative z-index-5">
        <div class="row">
            <div class="col-lg-6 col-xl-8 col-xxl-9">
                <a href="Javascript::void(0)" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                    <img src="{{ asset('dist/images/logos/logo.png') }}" width="180" alt="">
                </a>
                <div class="d-none d-lg-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/login-security.svg" alt="" class="img-fluid" width="500">
                </div>
            </div>
            <div class="col-lg-6 col-xl-4 col-xxl-3">
                <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
                    <div class="d-flex align-items-center w-100 h-100">
                        <div class="card-body">
                            <div class="mb-5">
                                <h2 class="fw-bolder fs-7 mb-3">Verifying User</h2>
                                <p class="mb-0 ">
                                Please enter your reset code to verify the user. Reset code can be found on your email.
                                </p>
                            </div>
                            <form wire:submit.prevent="verifyResetCode">
                                <div class="mb-3">
                                    <label for="resetCode" class="form-label">Reset Code</label>
                                    <input type="text" class="form-control" aria-describedby="resetCode" wire:model.defer="resetCode">
                                    @error('resetCode') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-3">Verify Code</button>
                                <a href="{{ URL::to('login') }}" class="btn btn-light-primary text-primary w-100 py-8">Back to Login</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
