<div class="container-fluid">
    <livewire:components.navigator title="Lead Details"/>

    <div class="row">
        <div wire:loading wire:target="status,assignTo,updateLead,priority">
            <livewire:components.progress-loader/>
        </div>
        <div class="">
            <div class="button-group mb-2 d-flex justify-content-end">
                <a type="button" href="{{ URL::to('lead/comments/'.$leadId) }}" class="btn mb-1 waves-effect waves-light btn-rounded btn-primary">
                  View Comments
                </a>
                <a type="button" href="{{ URL::to('lead/activities/'.$leadId) }}" class="btn mb-1 waves-effect waves-light btn-rounded btn-primary">
                    View Activities
                </a>
            </div> 
            <div class="card">                
                <div class="card-header text-center bg-info">
                    <h5 class="card-title text-light"><i class="ti ti-user-circle me-1 fs-6"></i> User Informations</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <small id="fullname" class="form-text text-muted">Full Name *</small>
                                <input type="text" class="form-control mt-1" wire:model.defer="fullname">
                                @error('fullname') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="email" class="form-text text-muted">Email Address *</small>
                                <input type="email" class="form-control mt-1"aria-describedby="email" placeholder="Email Address *" wire:model.defer="email">
                                @error('email') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="phone" class="form-text text-muted">Phone Number *</small>
                                <input type="text" class="form-control mt-1"aria-describedby="phone" placeholder="Phone Number *" wire:model.defer="phone">
                                @error('phone') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="secondaryphone" class="form-text text-muted">Secondary Phone</small>
                                <input type="text" class="form-control mt-1" aria-describedby="secondaryphone" placeholder="Secondary Phone" wire:model.defer="secondaryPhone">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="whatsapp" class="form-text text-muted">Whatsapp Number</small>
                                <input type="text" class="form-control mt-1" aria-describedby="whatsapp" placeholder="Whatsapp Phone" wire:model.defer="whatsapp">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="city" class="form-text text-muted">City</small>
                                <input type="text" class="form-control mt-1" aria-describedby="city" placeholder="City" wire:model.defer="city">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="country" class="form-text text-muted">Country</small>
                                <input type="text" class="form-control mt-1" aria-describedby="country" placeholder="Country" wire:model.defer="country">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-header text-center bg-success">
                    <h5 class="card-title text-light"><i class="ti ti-info-circle me-1 fs-6"></i> More Informations</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateLead">
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <small id="campaign" class="form-text text-muted">Campaign Name</small>
                                <input type="text" class="form-control mt-1"aria-describedby="campaign" placeholder="Campaign Name" wire:model.defer="campaignName">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="purpose" class="form-text text-muted">Purpose</small>
                                <input type="text" class="form-control mt-1"aria-describedby="purpose" placeholder="Purpose" wire:model.defer="purpose">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="budget" class="form-text text-muted">Budget</small>
                                <input type="text" class="form-control mt-1" aria-describedby="budget" placeholder="Budget" wire:model.defer="budget">
                            </div>                           
                            <div class="form-group mb-3 col-md-4">
                                <small id="propertytype" class="form-text text-muted">Property Type</small>
                                <input type="text" class="form-control mt-1" aria-describedby="propertytype" placeholder="Property Type" wire:model.defer="propertyType">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="bedroom" class="form-text text-muted">Bedrooms</small>
                                <input type="text" class="form-control mt-1" aria-describedby="bedroom" placeholder="Bedrooms" wire:model.defer="bedroom">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="developer" class="form-text text-muted">Developer</small>
                                <input type="text" class="form-control mt-1" aria-describedby="developer" placeholder="Developer" wire:model.defer="developer">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="contacttime" class="form-text text-muted">Preffered Call Time</small>
                                <input type="text" class="form-control mt-1" aria-describedby="contacttime" placeholder="Preffered Time" wire:model.defer="contactTime">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="source" class="form-text text-muted">Source</small>
                                <input type="text" class="form-control mt-1" aria-describedby="source" placeholder="Source" wire:model.defer="source">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="status" class="form-text text-muted">Status</small>
                                <select class="form-select mr-sm-2 mt-1" id="inlineFormCustomSelect" wire:model="status">
                                    @foreach ($statusList as $sl)
                                        <option value="{{ $sl->id }}">{{ $sl->name }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                            @if (Auth::user()->user_type === (int)config('custom.USER_ADMIN'))
                            <div class="form-group mb-3 col-md-4">
                                <small id="bedroom" class="form-text text-muted">Priority</small>
                                <select class="form-select mr-sm-2 mt-1" id="inlineFormCustomSelect" wire:model="priority">
                                    @foreach ($priorityList as $pl)
                                        <option value="{{ $pl->id }}">{{ $pl->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="bedroom" class="form-text text-muted">Assigned To</small>
                                <select class="form-select mr-sm-2 mt-1" id="inlineFormCustomSelect" wire:model="assignTo">
                                    @foreach ($usersList as $ul)
                                        <option value="{{ $ul->id }}">{{ $ul->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif                            
                            <div class="form-group mb-3 col-md-12">
                                <small id="inquiry" class="form-text text-muted">Inquiry</small>
                                <textarea class="form-control mt-1"aria-describedby="inquiry" rows="4" wire:model.defer="inquiry"></textarea>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-md-flex align-items-center mt-3">
                                    <div class="ms-auto mt-3 mt-md-0">
                                        <button
                                            type="submit"
                                            class="btn btn-success font-medium rounded-pill px-4"
                                        >
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-check me-2 fs-4"></i>
                                                Update
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>
