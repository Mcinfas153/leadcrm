<div class="container-fluid">
    <livewire:components.navigator title="reminders"/>
    <div wire:loading wire:target="">
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
                            <th>Reminder Time</th>
                            <th class="text-center">Owner</th>
                            <th class="text-center">Remind Through</th>
                            <th>Note</th>
                            <th class="">Is Active</th>                       
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if ($reminders->isEmpty())
                        <tr>
                          <td colspan="9"><h6 class="text-center">There is No Data Available</h6></td>
                        </tr>
                      @endif    
                        @foreach ($reminders as $reminder)                                  
                        <tr>
                            <td>{{ dateFormater($reminder->reminder_time, 'LLLL') }}</td>
                            <td class="text-center">{{ Str::title($reminder->ownerName) }}</td>
                            <td class="text-center">{{ $reminder->schedulerType }}</td>
                            <td>{{ $reminder->note }}</td>
                            <td class="text-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $reminder->is_active ? "checked" : "" }}>
                                </div>
                            </td>
                            <td class="text-center"></td>
                        </tr>
                    @endforeach 
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>Owner</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Remind Through</th>
                            <th>Note</th>
                            <th class="">Is Active</th>                       
                            <th class="text-center">Action</th>
                        </tr>
                        <!-- end row -->
                      </tfoot>
                      
                </table>
                <div class="d-flex justify-content-end">
                    {{ $reminders->links() }}
                </div>               
              </div>
            </div>
          </div>
        </div>
    </div>
</div>


