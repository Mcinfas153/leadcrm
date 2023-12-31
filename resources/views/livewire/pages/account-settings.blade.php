<div class="container-fluid">
    <livewire:components.navigator title="accout settings"/>
    <div wire:loading>
        <livewire:components.progress-loader/>
      </div>
    <section>
        <div class="row">
            <div class="">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="mb-0">Settings</h5>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <!-- Security Setting -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#security" aria-expanded="true" aria-controls="security">
                                        Security Settings
                                    </button>
                                </h2>
                                <div id="security" class="accordion-collapse collapse {{ $security }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <form wire:submit.prevent="changePassword">
                                                <h4 class="my-3">Change Password</h4>
                                                <div class="mb-3">
                                                    <label class="form-control-label mb-1" for="oldPassword">Current Password*:</label>
                                                    <input type="password" id="oldPassword" class="form-control" placeholder="Current Password *" wire:model.defer="oldPassword">
                                                    @error('oldPassword') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-control-label mb-1" for="oldPassword">New Password*:</label>
                                                    <input type="password" id="newPassword" class="form-control" placeholder="New Password" wire:model.defer="newPassword">
                                                    @error('newPassword') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-control-label mb-1" for="oldPassword">Confirm Password*:</label>
                                                    <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" wire:model.defer="conPassword">
                                                    @error('conPassword') <span class="error">{{ $message }}</span> @enderror
                                                </div>

                                                <div class="d-flex justify-content-end mt-3 mt-md-0">
                                                    <button type="submit" class="btn btn-success font-medium rounded-pill px-4">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ti ti-device-floppy me-1 fs-4"></i> Save
                                                        </div>
                                                    </button>
                                                </div>
                                                </form>
                                            </div>

                                            <hr class="my-4">
                                            @can('isAdmin', App\Models\User::class)
                                            <div class="mb-3">
                                                <label for="authKey" class="mb-2">Authentication Key:</label>
                                                <div class="input-group mb-1">
                                                    <input type="text" id="authKey" class="form-control" value="{{ Auth::user()->organization->auth_code }}" disabled>
                                                    <button class="btn btn-light-info text-info font-medium" type="button">
                                                        <i class="ti ti-file"></i> Copy
                                                    </button>
                                                </div>
                                                <div class="d-flex justify-content-start">
                                                    <small id="name13" class="badge badge-default text-warning font-medium bg-light-warning form-text"><i class="ti ti-alert"></i> Don't share this code with others</small>
                                                </div>
                                            </div>
                                            @endcan                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @can('isAdmin', App\Models\User::class)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button bg-warning" type="button" data-bs-toggle="collapse" data-bs-target="#automation" aria-expanded="true" aria-controls="automation">
                                        Automation Settings
                                    </button>
                                </h2>
                                <div id="automation" class="accordion-collapse collapse {{ $automation }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between my-3">
                                            <label for="reoprtMail" class="form-check-label">Send reports via mail</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="reoprtMail" size="large" onchange="reportMail({{ $reportViaEmail }})" {{ ($reportViaEmail) ? "checked" : "" }}/>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-sm-7 col-md-8 mb-1">
                                                    <label>Send reports </label>
                                                </div>
                                                <div class="col-sm-5 col-md-4">
                                                    <select class="form-control form-select" wire:model="reportPeriod">
                                                        @foreach ($reportPeriods as $reportPeriod)
                                                        <option value="{{ $reportPeriod->id }}">{{ $reportPeriod->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between my-3">
                                            <label for="autoShuffle" class="form-check-label">Auto Reshuffle Mode</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="autoShuffle" size="large" onchange="leadReshuffle({{ $leadReshuffle }})" {{ ($leadReshuffle) ? "checked" : "" }}/>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-sm-7 col-md-8 mb-1">
                                                    <label>Reshuffle in </label>
                                                </div>
                                                <div class="col-sm-5 col-md-4">
                                                    <select class="form-control form-select" wire:model="reshufflePeriod">
                                                        @foreach ($reshufflePeriods as $reshufflePeriod)
                                                            <option value="{{ $reshufflePeriod->id }}">{{ $reshufflePeriod->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
