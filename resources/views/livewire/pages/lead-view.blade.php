<div class="container-fluid">
    <livewire:components.navigator title="Lead Details"/>

    <div class="row">
        <div class="">
            <div class="card">
                <div class="card-header text-center bg-info">
                    <h5 class="card-title text-light"><i class="ti ti-user-circle me-1 fs-6"></i> User Informations</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <small id="fullname" class="form-text text-muted">Full Name *</small>
                                <input type="text" class="form-control mt-1"aria-describedby="fullname" placeholder="Full Name *" value="{{ $lead->fullname }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="email" class="form-text text-muted">Email Address *</small>
                                <input type="email" class="form-control mt-1"aria-describedby="email" placeholder="Email Address *" value="{{ $lead->email }}">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="phone" class="form-text text-muted">Phone Number *</small>
                                <input type="text" class="form-control mt-1"aria-describedby="phone" placeholder="Phone Number *" value="{{ $lead->phone }}">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="secondaryphone" class="form-text text-muted">Secondary Phone</small>
                                <input type="text" class="form-control mt-1" aria-describedby="secondaryphone" placeholder="Secondary Phone" value="{{ $lead->secondary_phone }}">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="whatsapp" class="form-text text-muted">Whatsapp Number</small>
                                <input type="text" class="form-control mt-1" aria-describedby="whatsapp" placeholder="Whatsapp Phone" value="{{ $lead->whatsapp }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="city" class="form-text text-muted">City</small>
                                <input type="text" class="form-control mt-1" aria-describedby="city" placeholder="City" value="{{ $lead->city }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="country" class="form-text text-muted">Country</small>
                                <input type="text" class="form-control mt-1" aria-describedby="country" placeholder="Country" value="{{ $lead->country }}">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-header text-center bg-success">
                    <h5 class="card-title text-light"><i class="ti ti-info-circle me-1 fs-6"></i> More Informations</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <small id="campaign" class="form-text text-muted">Campaign Name</small>
                                <input type="text" class="form-control mt-1"aria-describedby="campaign" placeholder="Campaign Name" value="{{ Str::title($lead->campaign_name) }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="purpose" class="form-text text-muted">Purpose</small>
                                <input type="text" class="form-control mt-1"aria-describedby="purpose" placeholder="Purpose" value="{{ Str::title($lead->purpose) }}">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="budget" class="form-text text-muted">Budget</small>
                                <input type="text" class="form-control mt-1" aria-describedby="budget" placeholder="Budget" value="{{ $lead->budget }}">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="bedroom" class="form-text text-muted">Bedrooms</small>
                                <input type="text" class="form-control mt-1" aria-describedby="bedroom" placeholder="Bedrooms" value="{{ $lead->bedroom }}">
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                <small id="contacttime" class="form-text text-muted">Preffered Time</small>
                                <input type="text" class="form-control mt-1" aria-describedby="contacttime" placeholder="Preffered Time" value="{{ $lead->contact_time }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="developer" class="form-text text-muted">Developer</small>
                                <input type="text" class="form-control mt-1" aria-describedby="developer" placeholder="Developer" value="{{ Str::title($lead->developer) }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="propertytype" class="form-text text-muted">Property Type</small>
                                <input type="text" class="form-control mt-1" aria-describedby="propertytype" placeholder="Property Type" value="{{ Str::title($lead->property_type) }}">
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <small id="source" class="form-text text-muted">Source</small>
                                <input type="text" class="form-control mt-1" aria-describedby="source" placeholder="Source" value="{{ Str::title($lead->source) }}">
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <small id="status" class="form-text text-muted">Status</small>
                                <select class="form-select mr-sm-2 mt-1" id="inlineFormCustomSelect">
                                    <option selected disabled>Select a Status Value</option>
                                    @foreach ($status as $st)
                                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <small id="bedroom" class="form-text text-muted">Assigned To</small>
                                <select class="form-select mr-sm-2 mt-1" id="inlineFormCustomSelect">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <small id="inquiry" class="form-text text-muted">Inquiry</small>
                                <textarea class="form-control mt-1"aria-describedby="inquiry" rows="4">{{ $lead->inquiry }}</textarea>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <small id="note" class="form-text text-muted">Note:</small>
                                <textarea class="form-control mt-1"aria-describedby="note" rows="4">Write Something...</textarea>
                            </div>
                            <div class="col-12">
                                <div class="d-md-flex align-items-center mt-3">
                                    <div class="ms-auto mt-3 mt-md-0">
                                        <button
                                            type="submit"
                                            class="btn btn-info font-medium rounded-pill px-4"
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
