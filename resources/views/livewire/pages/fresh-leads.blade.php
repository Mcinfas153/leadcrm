<div class="container-fluid">
    <livewire:components.navigator title="fresh leads"/>
    <div class="row">
        <div class="col-12">
          <!-- ---------------------
                      start File export
                  ---------------- -->
          <div class="card">
            <div class="card-body">
            <div class="table-responsive">
                <table
                  id="leads"
                  class="table border table-striped display text-nowrap"
                >
                  <thead>
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
                  </thead>
                  <tbody>
                    @foreach ($leads as $lead)
                    <tr>
                      <td>{{ $lead->fullname }}</td>
                      <td>{{ getDateFormat($lead->created_at,'YYYY-MM-DD, h:mm a',config('custom.LOCAL_TIMEZONE')) }}</td>
                      <td>{{ $lead->phone }}</td>
                      <td>{{ $lead->email }}</td>
                      <td>{{ $lead->status }}</td>
                      <td>{{ $lead->campaign_name }}</td>
                      <td>{{ $lead->assign_to }}</td>
                      <td></td>
                    </tr>
                    @endforeach                   
                  </tbody>
                  <tfoot>
                    <!-- start row -->
                    <tr>
                      <th>#</th>
                      <th>Name</th>
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
          <!-- ---------------------
                      end File export
                  ---------------- -->
        </div>
      </div>
</div>
