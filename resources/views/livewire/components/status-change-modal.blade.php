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
