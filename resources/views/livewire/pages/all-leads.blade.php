<div class="container-fluid">
    <livewire:components.navigator title="all leads"/>
    <div wire:loading>
      <livewire:components.progress-loader/>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-md-8 col-12">
                  <button type="button" data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-primary lead-table-btn">Import Leads</button>
                  <button type="button" onclick="exportLeads('{{ URL::to('export-leads') }}?filterUserId={{ $filterUserId }}&leadType=fresh&filterStatusID={{ $filterStatusID }}&filterCampaignName={{ $filterCampaignName }}&startDate={{ $startDate }}&endDate={{ $endDate }}')" class="btn btn-secondary lead-table-btn">Export Leads</button>
                  @if (Auth::user()->can('changeAgent',App\Models\Lead::class))
                  <button type="button" data-bs-toggle="modal" data-bs-target="#bulk-assign-modal" class="btn btn-success lead-table-btn" {{ (empty($selectedLeads))? "disabled":"" }}>Bulk Assign</button>
                  @endif
                  <button type="button" onclick="bulkDelete()" class="btn btn-danger lead-table-btn" {{ (empty($selectedLeads))? "disabled":"" }}>Bulk Delete</button>
                  <a type="button" onclick="location.reload()" class="btn btn-info lead-table-btn">Reset</a>
                </div>
                <div class="col-md-4 col-12">
                  <div class="float-md-end">
                    <a type="button" onclick="toggleFilter()" class="btn btn-warning lead-table-btn mb-1">Filter</a>
                  </div>                 
                  <div
                          class="input-daterange input-group"
                          id="date-range"
                        >
                          <input
                            type="text"
                            id="startDate"
                            class="form-control"
                            wire.model="startDate"
                          />

                          <span class="input-group-text bg-info b-0 text-white"
                            >TO</span
                          >

                          <input type="text" class="form-control" id="endDate" wire.model="endDate"/>
                          <button class="btn btn-success" onclick="filterDate()">Submit</button>
                          
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  @can('isAdmin', App\Models\User::class)
                  <select class="form-select table-filter" aria-label="filter-user-id" wire:model="filterUserId">
                    <option selected hidden>Select an Agent to view Assign Leads</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                  </select>
                  @endcan
                </div>
                <div class="col-md-3">
                  <select class="form-select table-filter" aria-label="filter-status-id" wire:model="filterCampaignName">
                    <option selected hidden>Select Campaign</option>
                    @foreach ($campaigns as $campaign)
                      <option value="{{ $campaign->campaign_name }}">{{ $campaign->campaign_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-select table-filter" aria-label="filter-status-id" wire:model="filterStatusID">
                    <option selected hidden>Select Status</option>
                    @foreach ($lead_status as $ls)
                      <option value="{{ $ls->id }}">{{ $ls->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <input class="form-control table-filter" type="text" placeholder="Search Here" wire:model="search">
                </div>
              </div>

            <div class="table-responsive tscroll">
                <table class="table data-table display text-nowrap">
                    <thead>
                        <tr>
                            <th>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="selectAllCheckBox">
                              </div>
                            </th>
                            <th>SR.NO</th>
                            <th class="fixedCol">Name</th>
                            <th>Date</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Campaign Name</th>
                            @if (Auth::user()->can('changeAgent', App\Models\Lead::class))
                            <th class="text-center">Assign To</th>
                            @endif
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if ($leads->isEmpty())
                        <tr>
                          <td colspan="9"><h6 class="text-center">There is No Data Available</h6></td>
                        </tr>
                      @endif
                      @php
                        $currentCount = 1;
                      @endphp
                        @foreach ($leads as $lead)
                        <tr>
                            <td>
                              @can('delete', App\Models\Lead::find($lead->id))
                              <div class="form-check">
                                <input class="form-check-input leadCheckBox{{ $currentCount }}" type="checkbox" wire:model="selectedLeads" value="{{ $lead->id }}" id="flexCheckDefault">
                              </div>
                              @endcan
                            </td>
                            <td>{{ getSrNumberForLeads($leads->currentPage(), $leads->perPage(), $currentCount) }}</td>
                            <td class="fixedCol text-black"><a href="{{ URL::to('lead/view') }}/{{ $lead->id }}" target="_BLANK">{{ $lead->fullname }}</a></td>
                            <td>{{ Auth::user()->user_type == config('custom.USER_ADMIN') ? dateFormater($lead->created_at) : dateFormater($lead->assign_time) }}</td>
                            <td class="text-center"><a onclick="makeCall('{{ $lead->phone }}')">{{ $lead->phone }}</a></td>
                            <td class="text-center"><a onclick="sentEmail('{{ $lead->email }}')">{{ $lead->email }}</a></td>
                            <td class="text-center">
                              @if ($lead->status == config('custom.LEAD_STATUS_DEAL_CLOSED'))
                                <span style="background-color:{{ $lead->color_code }}" class="badge fw-semibold py-2 px-3 text-white fs-1">{{ Str::title($lead->lead_status) }}</span>
                              @else
                              <span onclick="changeStatus({{ $lead->id }}, {{ $lead->status }})" style="background-color:{{ $lead->color_code }}" class="badge fw-semibold py-2 px-3 text-white fs-1">{{ Str::title($lead->lead_status) }}</span>
                              @endif
                            </td>
                            <td class="text-center">{{ Str::title($lead->campaign_name) }}</td>
                            @if (Auth::user()->can('changeAgent', App\Models\Lead::class))
                            <td class="text-center"><span onclick="changeAgent({{ $lead->id }}, {{ $lead->assign_to }})" class="badge fw-semibold py-2 px-3 bg-success bg-gradient text-black fs-1">{{ Str::title($lead->assign_user) }}</span></td>
                            @endif
                            <td class="text-center">
                              <div class="dropdown">
                                <a class="text-decoration-none" href="javascript:void(0)" id="nft2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical fs-4"></i>
                                </a>
                                <ul class="dropdown-menu bg-light bg-gradient" aria-labelledby="nft2" id="action-panel">
                                  <li class="">
                                    <a class="dropdown-item d-flex align-items-center text-black" target="_BLANK" href="{{ URL::to('lead/'.$lead->id.'/entries') }}">
                                    <i class="ti ti-link me-1 fs-1 text-black"></i>Lead Entries & Reminders </a>
                                  </li>
                                  <li class="">
                                    <a class="dropdown-item d-flex align-items-center text-black" target="_BLANK" href="{{ URL::to('lead/activities') }}/{{ $lead->id }}">
                                    <i class="ti ti-link me-1 fs-1 text-black"></i>Lead Activities </a>
                                  </li>
                                  <li class="">
                                    <a class="dropdown-item d-flex align-items-center text-black" target="_BLANK" href="{{ URL::to('lead/comments') }}/{{ $lead->id }}">
                                    <i class="ti ti-link me-1 fs-1 text-black"></i>Lead Comments </a>
                                  </li>
                                  <li class="">
                                      <a class="dropdown-item d-flex align-items-center text-black" target="_BLANK" href="{{ URL::to('lead/view') }}/{{ $lead->id }}">
                                      <i class="ti ti-eye me-1 fs-1 text-black"></i>View </a>
                                  </li>
                                  @if (Auth::user()->can('delete', App\Models\Lead::find($lead->id)))
                                  <li class="">
                                    <a class="dropdown-item d-flex align-items-center text-black" onclick="deleteLead({{ $lead->id }}, '{{ $lead->fullname }}')">
                                    <i class="ti ti-trash me-1 fs-1 text-black"></i>Delete </a>
                                  </li>
                                  @endif
                                </ul>
                             </div>
                            </td>
                        </tr>
                        @php
                        $currentCount++;
                        @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                          <th>#</th>
                          <th>SR.NO</th>
                          <th class="fixedCol">Name</th>
                          <th>Date</th>
                          <th class="text-center">Phone</th>
                          <th class="text-center">Email</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Campaign Name</th>
                          @if (Auth::user()->can('changeAgent',App\Models\Lead::class))
                          <th class="text-center">Assign To</th>
                          @endif
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
            <option selected hidden>Select the status</option>
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
            <option selected hidden>Select a user</option>
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

    {{-- import modal --}}
    <div
    class="modal fade"
    id="import-modal"
    tabindex="-1"
    aria-labelledby="mySmallModalLabel"
    aria-hidden="true"
    wire:ignore.self
    >
   <div class="modal-dialog modal-sm">
    <form action="{{ route('import.leads') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
         <div
            class="modal-header d-flex align-items-center modal-colored-header bg-success text-white"
            >
            <h4 class="modal-title" id="myModalLabel">
               Import Leads
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
              <label for="file" class="form-label">File*</label>
              <input class="form-control form-control-sm" id="formFileSm" type="file" name="file">
              <div class="text-end">
                <a class="fs-1" download="lead-import-sample" href="{{ Storage::url('downloads/lead-import-sample.xlsx') }}" title="Lead Import Sample">Download Sample File</a>
              </div>
            </div>
            <div class="mb-3">
              <label for="Lead Type" class="form-label">Lead Type*</label>
              <select class="form-select" aria-label="Lead Type" name="leadType">
                <option hidden disabled>Select Lead Type</option>
                @foreach ($leadTypes as $leadType)
                <option value="{{ $leadType->id }}">{{ $leadType->name }}</option>
                @endforeach
              </select>
            </div>
            @can('isAdmin', App\Models\User::class)
            <div class="mb-3">
              <label for="assignUser" class="form-label">Assign User</label>
              <select class="form-select" aria-label="Assign User" name="importAssignUserId">
                <option hidden disabled>Select User to Assign</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
            @endcan

            @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif

            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <div>
                <p>In Excel Import File:</p>
                <div>Full name is required</div>
                <div>Emai is required</div>
                <div>Phone is required</div>
              </div>
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
              >
            Import
          </button>
         </div>
      </div>
    </form>
   </div>
</div>

{{-- Bulk change modal  --}}
<div
class="modal fade"
id="bulk-assign-modal"
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
          Bulk Lead Assign
        </h4>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
          ></button>
      </div>
      <div class="modal-body">
      <select class="form-select" aria-label="Default select example" wire:model.defer="bulkAssignUserId">
        <option selected hidden>Select a user</option>
        @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
      </select>
      @error('bulkAssignUserId') <span class="error">{{ $message }}</span> @enderror
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
          wire:click="bulkAssign"
        >
        Save changes
        </button>
      </div>
    </div>
  </div>
</div>

<script>
 
  let currentPageLeadCount;
 
   document.addEventListener("DOMContentLoaded", () => {
     Livewire.hook('element.initialized', (el, component) => {
       currentPageLeadCount = {{ $leadsCount }};
     })
     Livewire.hook('message.processed', (el, component) => {
       let pageLeadCount = @this.leadsCount
       currentPageLeadCount = pageLeadCount
     })
   });
  
 </script>

</div>
