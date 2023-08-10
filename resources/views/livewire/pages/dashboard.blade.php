<div class="container-fluid">
  <div class="owl-carousel counter-carousel owl-theme">
    <div class="item">
      <div class="card border-0 zoom-in bg-light-warning shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-warning mb-1">New Leads</p>
            <h5 class="fw-semibold text-warning mb-0">{{ $newLeadsCount }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="card border-0 zoom-in bg-light-info shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-mailbox.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-info mb-1">Today Leads</p>
            <h5 class="fw-semibold text-info mb-0">{{ $todayLeadsCount }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="card border-0 zoom-in bg-light-danger shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-favorites.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-danger mb-1">Follwing Up</p>
            <h5 class="fw-semibold text-danger mb-0">{{ $followingLeadCount }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="card border-0 zoom-in bg-light-success shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-speech-bubble.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-success mb-1">Total Leads</p>
            <h5 class="fw-semibold text-success mb-0">{{ $totalLeadsCount }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="card border-0 zoom-in bg-light-info shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-connect.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-info mb-1">Close Deals</p>
            <h5 class="fw-semibold text-info mb-0">{{ $closeDealsCount }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
      <div class="card w-100">
        <div class="card-body">
          <div>
            <h5 class="card-title fw-semibold mb-1">Leads Count</h5>
            <p class="card-subtitle mb-0">Every Day</p>
            <div id="daily-leads" class="mb-7 pb-8">
              {!! $chart->container() !!}
            </div>
          </div>
          </div>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
      <div class="card w-100">
        <div class="card-body">
          <div>
            <h5 class="card-title fw-semibold mb-1">Leads Count</h5>
            <p class="card-subtitle mb-0">Every Month</p>
            <div id="monthly-leads" class="mb-7 pb-8">
              {!! $monthlyLeadChart->container() !!}
            </div>
          </div>
          </div>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
      <div class="card w-100">
        <div class="card-body">
          <div
            class="d-sm-flex d-block align-items-center justify-content-between mb-7"
          >
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Latest Leads</h5>
              <p class="card-subtitle mb-0">Most Recent Leads</p>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle text-nowrap mb-0">
              <thead>
                <tr class="text-muted fw-semibold">
                  <th scope="col" class="ps-0">Name</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Email</th>
                  <th scope="col">Campaign Name</th>
                </tr>
              </thead>
              <tbody class="border-top">
                @foreach ($latestLeads as $latest)
                <tr>
                  <td class="ps-0">
                    <div class="d-flex align-items-center">
                      <div class="me-2 pe-1">
                        <img
                          src="{{ asset('dist/images/profile/user-1.jpg') }}"
                          class="rounded-circle"
                          width="40"
                          height="40"
                          alt=""
                        />
                      </div>
                      <div>
                        <h6 class="fw-semibold mb-1">{{ $latest->fullname }}</h6>
                        <p class="fs-2 mb-0 text-muted">{{ $latest->country ?? "World" }}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="mb-0 fs-3">{{ $latest->phone }}</p>
                  </td>
                  <td>
                    <span
                      class="badge fw-semibold py-1 w-85 bg-light-primary text-primary"
                      >{{ $latest->email }}</span
                    >
                  </td>
                  <td>
                    <p class="fs-3 text-dark mb-0">{{ $latest->campaign_name }}</p>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ $chart->cdn() }}"></script>
  <script src="{{ $monthlyLeadChart->cdn() }}"></script>
  {{ $chart->script() }}
  {{ $monthlyLeadChart->script() }}
</div>