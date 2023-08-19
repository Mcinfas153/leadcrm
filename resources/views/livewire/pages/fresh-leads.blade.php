<div class="container-fluid">
    <livewire:components.navigator title="fresh leads"/>
    <div class="row">
        <div class="col-12">
          
          <div class="card">
            <div class="card-body">
            <div class="table-responsive">
              <table class="table data-table display text-nowrap" id="leads">
                <thead>
                    <tr>
                      <th>#ID</th>
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
                    @foreach ($leads as $lead)                                  
                    <tr>
                        <td>
                          #{{ $lead->id }}
                        </td>
                        <td class="fixedCol text-black"><a href="{{ URL::to('lead/view') }}/{{ $lead->id }}" target="_BLANK">{{ $lead->fullname }}</a></td>
                        <td>{{ Auth::user()->user_type == config('custom.USER_ADMIN') ? getDateFormat($lead->created_at,'YYYY-MM-DD, h:mm a',config('custom.LOCAL_TIMEZONE')) : getDateFormat($lead->assign_time,'YYYY-MM-DD, h:mm a',config('custom.LOCAL_TIMEZONE')) }}</td>
                        <td class="text-center"><a>{{ $lead->phone }}</a></td>
                        <td class="text-center"><a>{{ $lead->email }}</a></td>
                        <td class="text-center"><span style="background-color:{{ $lead->color_code }}" class="badge fw-semibold py-2 px-3 text-white fs-2">{{ Str::title($lead->lead_status) }}</span></td>
                        <td class="text-center">{{ Str::title($lead->campaign_name) }}</td>
                        @if (Auth::user()->can('changeAgent', App\Models\Lead::class))
                        <td class="text-center"><span class="badge fw-semibold py-2 px-3 bg-success bg-gradient text-black fs-2">{{ Str::title($lead->assign_user) }}</span></td>
                        @endif
                        <td class="text-center">
                          <div class="dropdown">
                            <a class="text-decoration-none" href="javascript:void(0)" id="nft2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-4"></i>
                            </a>
                            <ul class="dropdown-menu bg-light bg-gradient" aria-labelledby="nft2" id="action-panel">
                              <li class="">
                                  <a class="dropdown-item d-flex align-items-center text-black" target="_BLANK" href="{{ URL::to('lead/view') }}/{{ $lead->id }}">
                                  <i class="ti ti-eye me-1 fs-1 text-black"></i>View </a>
                              </li>                                                             
                            </ul>
                         </div>
                        </td>
                    </tr>
                @endforeach 
                </tbody>
                <tfoot>
                    <!-- start row -->
                    <tr>
                      <th>#</th>
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
              </div>
            </div>
          </div>
          
        </div>
      </div>
</div>
