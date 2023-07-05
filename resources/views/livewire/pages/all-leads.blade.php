<div class="container-fluid">
    <livewire:components.navigator title="all leads"/>
    <div wire:loading>
      <livewire:components.progress-loader/>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
            <div class="table-responsive tscroll">
                <table class="table data-table display text-nowrap">
                    <thead>
                        <tr>
                            <th class="fixedCol">Name</th>
                            <th>Date</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Campaign Name</th>
                            <th class="text-center">Assign To</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>    
                        @foreach ($leads as $lead)                                  
                        <tr>
                            <td class="fixedCol">{{ $lead->fullname }}</td>
                            <td>{{ getDateFormat($lead->created_at,'YYYY-MM-DD, h:mm a',config('custom.LOCAL_TIMEZONE')) }}</td>
                            <td class="text-center">{{ $lead->phone }}</td>
                            <td class="text-center">{{ $lead->email }}</td>
                            <td class="text-center"><span onclick="changeStatus({{ $lead->id }}, {{ $lead->status }})" style="background-color:{{ $lead->color_code }}" class="badge fw-semibold py-2 px-3 text-white fs-2">{{ Str::title($lead->lead_status) }}</span></td>
                            <td class="text-center">{{ Str::title($lead->campaign_name) }}</td>
                            <td class="text-center"><span onclick="changeAgent({{ $lead->id }}, {{ $lead->assign_to }})" class="badge fw-semibold py-2 px-3 bg-success bg-gradient text-black fs-2">{{ Str::title($lead->assign_user) }}</span></td>
                            <td class="text-center"></td>
                        </tr>
                    @endforeach 
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                          <th class="fixedCol">Name</th>
                          <th>Date</th>
                          <th class="text-center">Phone</th>
                          <th class="text-center">Email</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Campaign Name</th>
                          <th class="text-center">Assign To</th>
                          <th class="text-center">Action</th>
                        </tr>
                        <!-- end row -->
                      </tfoot>
                      
                </table>
                {{ $leads->links() }}
              </div>
            </div>
          </div>
        </div>
    </div>
    
    {{-- status change modal --}}
    <div
    class="modal fade"
    id="status-change-modal"
    tabindex="-1"
    aria-labelledby="mySmallModalLabel"
    aria-hidden="true"
    wire:ignore.self
    >
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div
            class="modal-header d-flex align-items-center modal-colored-header bg-success text-white"
            >
            <h4 class="modal-title" id="myModalLabel">
               Status Change
            </h4>
            <button
               type="button"
               class="btn-close"
               data-bs-dismiss="modal"
               aria-label="Close"
               ></button>
         </div>
         <div class="modal-body">
          <input type="hidden" value="" id="leadIdHidden"/>
          <select class="form-select" aria-label="Default select example" wire:model.defer="statusId">
            <option selected>Select the status</option>
            @foreach ($lead_status as $ls)
            <option value="{{ $ls->id }}">{{ $ls->name }}</option>
            @endforeach
          </select>
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
              type="button"
              class="btn btn-success text-black font-medium waves-effect"
              id="status-change-save"
              wire:click="changeLeadStatus"
            >
            Save changes
          </button>
         </div>
      </div>
   </div>
</div>

{{-- agent change modal  --}}
    <div
    class="modal fade"
    id="agent-change-modal"
    tabindex="-1"
    aria-labelledby="mySmallModalLabel"
    aria-hidden="true"
    wire:ignore.self
    >
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div
            class="modal-header d-flex align-items-center modal-colored-header bg-success text-white"
            >
            <h4 class="modal-title" id="myModalLabel">
              Lead Assign
            </h4>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              ></button>
        </div>
        <div class="modal-body">
          <input type="hidden" value="" id="leadIdHidden"/>
          <select class="form-select" aria-label="Default select example" wire:model.defer="userId">
            <option selected>Select a user</option>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
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
              type="button"
              class="btn btn-success text-black font-medium waves-effect"
              id="status-change-save"
              wire:click="changeAgent"
            >
            Save changes
          </button>
        </div>
      </div>
    </div>
    </div>

</div>
