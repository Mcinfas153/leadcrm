<div class="container-fluid">
    <livewire:components.navigator title="all leads"/>
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
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Campaign Name</th>
                            <th>Assign To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>    
                        @foreach ($leads as $lead)                                  
                        <tr>
                            <td class="fixedCol">{{ $lead->fullname }}</td>
                            <td>{{ getDateFormat($lead->created_at,'YYYY-MM-DD, h:mm a',config('custom.LOCAL_TIMEZONE')) }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->email }}</td>
                            <td><span onclick="changeStatus({{ $lead->id }})" style="background-color:{{ $lead->color_code }}" class="badge fw-semibold py-2 px-3 text-white fs-2">{{ Str::title($lead->lead_status) }}</span></td>
                            <td>{{ Str::title($lead->campaign_name) }}</td>
                            <td>{{ Str::title($lead->assign_user) }}</td>
                            <td></td>
                        </tr>
                    @endforeach 
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                          <th class="fixedCol">Name</th>
                          <th>Date</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Status</th>
                          <th>Campaign Name</th>
                          <th>Assign To</th>
                          <th>Action</th>
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

</div>
