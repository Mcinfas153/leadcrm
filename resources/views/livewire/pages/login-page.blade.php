<div class="position-relative z-index-5">
    <div class="row">
        <div class="col-xl-7 col-xxl-8">
            <a href="index.html" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/dark-logo.svg" width="180" alt="">
            </a>
            <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/login-security.svg" alt="" class="img-fluid" width="500">
            </div>
        </div>
        <div class="col-xl-5 col-xxl-4">
            <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                <div class="col-sm-8 col-md-6 col-xl-9">
                    <h2 class="mb-5 fs-7 fw-bolder">WELCOME TO {{ config('custom.APP_NAME') }}</h2>
                    
                    <form  wire:submit.prevent="loginUser">
                        <div wire:loading wire:target="loginUser">
                            <livewire:components.progress-loader/>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" wire:model.defer="email">
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" wire:model.defer="password">
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                            <input class="form-check-input primary" type="checkbox" value={{ true }} wire:model.defer="remember">
                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                Remeber this Device
                            </label>
                            </div>
                            <a class="text-primary fw-medium" href="{{ URL::to('forgot-password') }}">Forgot Password ?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
                        <div class="d-flex align-items-center justify-content-center">
                            <p class="fs-4 mb-0 fw-medium">New to {{ config('custom.APP_NAME') }}?</p>
                            <a class="text-primary fw-medium ms-2" href="{{ URL::to('/register') }}">Create an account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
