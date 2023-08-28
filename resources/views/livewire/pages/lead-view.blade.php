<div class="container-fluid">
    <livewire:components.navigator title="Lead Details"/>

    <div class="row">
        <div wire:loading wire:target="status,assignTo,updateLead,priority,addComment">
            <livewire:components.progress-loader/>
        </div>
        <div class="">
            <div class="button-group mb-2 d-flex justify-content-end">
                <button type="button" onclick="setReminder({{ $leadId }})" class="btn mb-1 waves-effect waves-light btn-rounded btn-success">
                    Add Reminder
                </button>
                <a type="button" onclick="addEntry({{ $leadId }})" class="btn mb-1 waves-effect waves-light btn-rounded btn-warning">
                    Add Entry
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
                                <small id="campaign" class="form-text text-muted">Campaign Name *</small>
                                <input type="text" class="form-control mt-1"aria-describedby="campaign" placeholder="Campaign Name" wire:model.defer="campaignName">
                                @error('campaignName') <span class="error">{{ $message }}</span> @enderror
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
                                <small id="propertyType" class="form-text text-muted">Property Type</small>
                                <input type="text" class="form-control mt-1" aria-describedby="propertyType" placeholder="Property Type" wire:model.defer="propertyType">
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
                            <div class="form-group mb-3 col-md-3">
                                <small id="type" class="form-text text-muted">Lead Type *</small>
                                <select class="form-select mr-sm-2 mt-1" wire:model="type">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ Str::title($type->name) }}</option>
                                    @endforeach
                                </select>
                                @error('type') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <small id="status" class="form-text text-muted">Status *</small>
                                <select class="form-select mr-sm-2 mt-1" wire:model="status">
                                    @foreach ($statusList as $sl)
                                        <option value="{{ $sl->id }}">{{ $sl->name }}</option>
                                    @endforeach
                                </select>
                                @error('status') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <small id="bedroom" class="form-text text-muted">Priority *</small>
                                <select class="form-select mr-sm-2 mt-1" wire:model="priority">
                                    @foreach ($priorityList as $pl)
                                        <option value="{{ $pl->id }}">{{ $pl->name }}</option>
                                    @endforeach
                                </select>
                                @error('priority') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            @can('isAdmin', App\models\User::class)                            
                            <div class="form-group mb-3 col-md-3">
                                <small id="bedroom" class="form-text text-muted">Assigned To</small>
                                <select class="form-select mr-sm-2 mt-1" wire:model="assignTo">
                                    @foreach ($usersList as $ul)
                                        <option value="{{ $ul->id }}">{{ $ul->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endcan
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
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-light"><i class="ti ti-checklist me-1 fs-6"></i> Comments</h5>
                            @can('isAdmin', App\Models\User::class)
                                <button class="btn btn-danger rounded-pill btn-sm" onclick="deleteAllComments({{ $leadId }})"><i class="ti ti-trash fs-4 me-2"></i>clear all</button>
                            @endcan
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="addComment">
                                <div class="mb-3 d-flex flex-column">                            
                                        <label for="note" class="form-label">Add your comment here...</label>
                                        <input class="form-control" wire:model.defer="note">
                                        @error('note') <span class="error">{{ $message }}</span> @enderror
                                        <div class="align-self-end">
                                            
                                            <button type="submit" class="btn rounded-pill waves-effect waves-light btn-primary mt-2">
                                                Add Comment
                                            </button>
                                        </div>                                                  
                                </div>
                            </form>
                            @if ($notes->isEmpty())
                            <h6 class="text-center">There is No Comments Available</h6>
                            @endif
                            @foreach ($notes as $note)
                                <livewire:components.comment-card :note="$note" :wire:key="'note-'.$note->id"/>
                            @endforeach
                            <div class="d-flex justify-content-end">
                                {{-- {{ $notes->links() }} --}}
                            </div>                            
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-light"><i class="ti ti-list-check me-1 fs-6"></i> Activities</h5>
                            @can('isAdmin', App\Models\User::class)
                                <button class="btn btn-danger rounded-pill btn-sm" onclick="deleteAllActivities({{ $leadId }})"><i class="ti ti-trash fs-4 me-2"></i>clear all</button>
                            @endcan
                        </div>
                        <div class="card-body">
                            @if ($leadActivities->isEmpty())
                            <h6 class="text-center">There is No Activities Found</h6>
                            @endif
                            @foreach ($leadActivities as $activity)
                            <ul class="timeline-widget mb-0 position-relative">
                                <livewire:components.activity-panel :activity="$activity" :wire:key="'activity-'.$activity->id"/>
                            </ul>
                            @endforeach
                            <div class="d-flex justify-content-end">
                                {{ $leadActivities->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- reminder modal --}}
    <div
    class="modal fade"
    id="reminder-modal"
    tabindex="-1"
    aria-labelledby="mySmallModalLabel"
    aria-hidden="true"
    wire:ignore.self
    >
        <div class="modal-dialog modal-sm">
            <form wire:submit.prevent="addReminder">
                <div class="modal-content">
                    <div
                        class="modal-header d-flex align-items-center modal-colored-header bg-success text-white"
                        >
                        <h4 class="modal-title" id="myModalLabel">
                            Add Reminder
                        </h4>
                        <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="note" class="form-label">Time</label>
                            <input type="datetime-local" id="reminder-time" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Reminder Type</label>
                            <select class="form-select" wire:model.defer="reminderType">
                                <option selected hidden>Select Reminder Type</option>
                                    @foreach ($schedulerTypes as $schedulerType)
                                        <option value="{{ $schedulerType->id }}">{{ $schedulerType->name }}</option>
                                    @endforeach
                            </select>
                            @error('reminderType') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" rows="3" wire:model.defer="reminderNote"></textarea>
                            @error('reminderNote') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                        type="button"
                        class="btn btn-danger text-black font-medium waves-effect"
                        data-bs-dismiss="modal"
                        >
                        Close
                        </button>
                        <button
                        type="submit"
                        class="btn btn-success text-black font-medium waves-effect"
                        id="status-change-save"
                        >
                        Save changes
                    </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- entry modal --}}
    <div
    class="modal fade"
    id="entry-modal"
    tabindex="-1"
    aria-labelledby="mySmallModalLabel"
    aria-hidden="true"
    wire:ignore.self
    >
        <div class="modal-dialog modal-sm">
            <form wire:submit.prevent="addEntry">
                <div class="modal-content">
                    <div
                        class="modal-header d-flex align-items-center modal-colored-header bg-success text-white"
                        >
                        <h4 class="modal-title" id="myModalLabel">
                            Add Entry
                        </h4>
                        <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="note" class="form-label">Time</label>
                            <input type="datetime-local" id="entry-time" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Type of Entry</label>
                            <select class="form-select" wire:model.defer="entryType">
                                <option selected hidden>select type of entry</option>
                                <option value="call">call</option>
                                <option value="mail">mail</option>
                                <option value="whatsapp">whatsapp</option>
                                <option value="meeting">meeting</option>                                    
                            </select>
                            @error('entryType') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="response" class="form-label">Response</label>
                            <select class="form-select" wire:model.defer="entryResponse">
                                <option selected hidden>select response</option>
                                <option value="positive">positive</option>
                                <option value="negative">negative</option>
                                <option value="neutral">neutral</option>                                
                            </select>
                            @error('entryResponse') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" rows="3" wire:model.defer="entryNote"></textarea>
                            @error('entryNote') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                        type="button"
                        class="btn btn-danger text-black font-medium waves-effect"
                        data-bs-dismiss="modal"
                        >
                        Close
                        </button>
                        <button
                        type="submit"
                        class="btn btn-success text-black font-medium waves-effect"
                        id="status-change-save"
                        >
                        Save changes
                    </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
