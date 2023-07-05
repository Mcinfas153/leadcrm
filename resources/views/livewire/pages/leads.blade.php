<div class="container-fluid" wire:ignore>
    <livewire:components.navigator title="all leads"/>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table display text-nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
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
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                          <th>Name</th>
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
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

    <script>
        const getAllLeadsRoute = "{{ route('all.leads') }}"
    </script>
</div>
