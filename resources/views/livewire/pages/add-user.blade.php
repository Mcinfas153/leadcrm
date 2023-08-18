<div class="container-fluid">
    <div wire:loading wire:target="addUser">
        <livewire:components.progress-loader/>
    </div>
    <livewire:components.navigator title="Add User"/>
    <section>
        <div class="card w-100">
            <div class="card-body">
                <div class="mb-4">
                    <h5>Add New User</h5>
                </div>
                <form wire:submit.prevent="addUser">
                    <div class="row">

                        <div class="col-md-6 form-group mb-3">
                            <label for="name">Full Name *</label>
                            <input type="text" class="form-control" wire:model.defer="name" aria-describedby="name" placeholder="John Doe">
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="email">Email Address *</label>
                            <input type="email" class="form-control" wire:model.defer="email" aria-describedby="email" placeholder="johndoe@test.com">
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="password">Password *</label>
                            <input type="password" class="form-control" wire:model.defer="password" aria-describedby="password" placeholder="******">
                            @error('password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="passwordConfirmation">Confirm Password *</label>
                            <input type="password" class="form-control" wire:model.defer="passwordConfirmation" aria-describedby="passwordConfirmation" placeholder="******">
                            @error('passwordConfirmation')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="type">User Type</label>
                            <select type="text" class="form-control" wire:model.defer="userType" aria-describedby="type">
                                <option selected hidden>Select the type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ Str::title($type->name) }}</option>
                                @endforeach
                            </select>
                            @error('userType')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="role">User Role</label>
                            <select type="text" class="form-control" wire:model.defer="userRole" aria-describedby="role">
                                <option selected hidden>Select the role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ Str::title($role->name) }}</option>
                                @endforeach
                            </select>
                            @error('userRole')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-info rounded-pill px-5 mt-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
