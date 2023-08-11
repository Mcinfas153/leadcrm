<div class="container-fluid">
    <div wire:loading wire:target="addLead">
        <livewire:components.progress-loader/>
    </div>
    <livewire:components.navigator title="accout settings"/>
    <section>
        <div class="card w-100">
            <div class="card-body">
                <div class="mb-4">
                    <h5>Add New Lead</h5>
                </div>
                <form wire:submit.prevent="addLead">
                    <div class="row">

                        <div class="col-md-4 form-group mb-3">
                            <label for="fullname">Full Name *</label>
                            <input type="text" class="form-control" wire:model.defer="fullname" aria-describedby="fullname" placeholder="John Doe">
                            @error('fullname')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-8 form-group mb-3">
                            <label for="email">Email Address *</label>
                            <input type="email" class="form-control" wire:model.defer="email" aria-describedby="email" placeholder="johndoe@test.com">
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="phone">Phone *</label>
                            <input type="text" class="form-control" wire:model.defer="phone" aria-describedby="phone" placeholder="+971 - *** ****">
                            @error('phone')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="secondaryPhone">Secondary Phone </label>
                            <input type="text" class="form-control" wire:model.defer="secondaryPhone" aria-describedby="secondaryPhone" placeholder="+971 - *** ****">
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="whatsapp">Whatsapp No </label>
                            <input type="text" class="form-control" wire:model.defer="whatsapp" aria-describedby="whatsapp" placeholder="+971 - *** ****">
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label for="city">City </label>
                            <input type="text" class="form-control" wire:model.defer="city" aria-describedby="city" placeholder="Dubai">
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="country">Country </label>
                            <input type="text" class="form-control" wire:model.defer="country" aria-describedby="country" placeholder="United Arab Emirates">
                        </div>

                        <div class="col-md-5 form-group mb-3">
                            <label for="campaignName">Campaign Name *</label>
                            <input type="text" class="form-control" wire:model.defer="campaignName" aria-describedby="campaignName" placeholder="Test">
                            @error('campaignName')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-5 form-group mb-3">
                            <label for="propertyType">Property Type </label>
                            <input type="text" class="form-control" wire:model.defer="propertyType" aria-describedby="propertyType" placeholder="Apartments">
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label for="developer">Developer </label>
                            <input type="text" class="form-control" wire:model.defer="developer" aria-describedby="developer" placeholder="Emaar">
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="bedroom">Bedrooms </label>
                            <input type="text" class="form-control" wire:model.defer="bedroom" aria-describedby="bedroom" placeholder="2 Bedrooms">
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="purpose">Purpose </label>
                            <input type="text" class="form-control" wire:model.defer="purpose" aria-describedby="purpose" placeholder="Investment">
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="budget">Budget </label>
                            <input type="text" class="form-control" wire:model.defer="budget" aria-describedby="budget" placeholder="***,*** AED">
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="contactTime">Contact Time </label>
                            <input type="text" class="form-control" wire:model.defer="contactTime" aria-describedby="contactTime" placeholder="Monday">
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label for="source">Source</label>
                            <input type="text" class="form-control" wire:model.defer="source" aria-describedby="source" placeholder="Facebook Leads">
                            @error('source')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label for="priority">Priority *</label>
                            <select type="text" class="form-control" wire:model.defer="priority" aria-describedby="priority">
                                <option selected hidden>Select the Priority</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ Str::title($priority->name) }}</option>
                                @endforeach
                            </select>
                            @error('priority')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label for="status">Status *</label>
                            <select type="text" class="form-control" wire:model.defer="status" aria-describedby="status">
                                <option selected hidden>Select the Priority</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ Str::title($status->name) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        @can('isAdmin', App\Models\User::class)
                        <div class="col-md-3 form-group mb-3">
                            <label for="assignedTo">Assigned to</label>
                            <select type="text" class="form-control" wire:model.defer="assignedTo" aria-describedby="assignedTo">
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ Str::title($agent->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endcan

                        <div class="form-group mb-3">
                            <label for="inquiry">Inquiry </label>
                            <textarea type="text" class="form-control" wire:model.defer="inquiry" aria-describedby="budget" rows="6">Write Something...</textarea>
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
