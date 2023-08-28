<div class="container-fluid">
    <livewire:components.navigator title="lead enrties & schedules"/>
    <div class="row">
        <div wire:loading wire:target="">
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
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-light"><i class="ti ti-checklist me-1 fs-6"></i> Schedulers</h5>
                            @can('isAdmin', App\Models\User::class)
                                <button class="btn btn-danger rounded-pill btn-sm" onclick="deleteAllComments({{ $leadId }})"><i class="ti ti-trash fs-4 me-2"></i>clear all</button>
                            @endcan
                        </div>
                        <div class="card-body">
                            @if ($schedulers->isEmpty())
                            <h6 class="text-center">There is No Schdulers Available</h6>
                            @endif
                            @foreach ($schedulers as $scheduler)
                                <livewire:components.scheduler-card :scheduler="$scheduler" :wire:key="'scheduler-'.$scheduler->id">
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
                            <h5 class="card-title text-light"><i class="ti ti-list-check me-1 fs-6"></i> Entries</h5>
                            @can('isAdmin', App\Models\User::class)
                                <button class="btn btn-danger rounded-pill btn-sm" onclick="deleteAllActivities({{ $leadId }})"><i class="ti ti-trash fs-4 me-2"></i>clear all</button>
                            @endcan
                        </div>
                        <div class="card-body">
                            @if ($entries->isEmpty())
                            <h6 class="text-center">There is No Entries Found</h6>
                            @endif
                            @foreach ($entries as $entry)
                                <livewire:components.entry-card :entry="$entry" :wire:key="'entry'.$entry->id">
                            @endforeach
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

