<div>
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="index.html" class="text-nowrap logo-img">
              <img src="{{ asset('dist/images/logos/logo.png') }}" class="dark-logo" width="180" alt="" />
              <img src="{{ asset('dist/images/logos/logo.png') }}" class="light-logo"  width="180" alt="" />
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8 text-muted"></i>
            </div>
          </div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
              <!-- ============================= -->
              <!-- Home -->
              <!-- ============================= -->
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">DASHBOARD</span>
              </li>
              <!-- =================== -->
              <!-- Dashboard -->
              <!-- =================== -->
              <li class="sidebar-item">
                <a class="sidebar-link" href="{{ URL::to('/') }}" aria-expanded="false">
                  <span>
                    <i class="ti ti-aperture"></i>
                  </span>
                  <span class="hide-menu">Dashboard</span>
                </a>
              </li>


              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Fresh Leads</span>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                  <span class="d-flex">
                    <i class="ti ti-magnet"></i>
                  </span>
                  <span class="hide-menu">Leads</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="{{ URL::to('lead/add') }}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Add Lead</span>
                    </a>
                  </li>                  
                  <li class="sidebar-item">
                    <a href="{{ URL::to('active-leads') }}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Active Leads</span>
                    </a>
                  </li>
                  
                  <li class="sidebar-item">
                    <a href="{{ URL::to('leads') }}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">All Leads</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">OLD CRM Leads</span>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                  <span class="d-flex">
                    <i class="ti ti-a-b-2"></i>
                  </span>
                  <span class="hide-menu">OLD CRM Leads</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="{{ URL::to('old-leads') }}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">All Leads</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Dump Leads</span>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                  <span class="d-flex">
                    <i class="ti ti-trash"></i>
                  </span>
                  <span class="hide-menu">Dump Leads</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="{{ URL::to('dump-leads') }}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">All Leads</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">COLD DATA LEADS</span>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                  <span class="d-flex">
                    <i class="ti ti-phone"></i>
                  </span>
                  <span class="hide-menu">Cold Data Leads</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="{{ URL::to('lead/add') }}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Add Lead</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="{{ URL::to('cold/leads') }}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">All Leads</span>
                    </a>
                  </li>
                </ul>
              </li>

              @can('isAdmin', App\Models\User::class)
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">USER MANAGEMENT</span>
              </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-user-circle"></i>
                        </span>
                        <span class="hide-menu">User Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ URL::to('/user/add') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Add User</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ URL::to('/users') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                    </ul>
                </li>
              @endcan              

                @can('isAdmin', App\Models\User::class)

                <li class="nav-small-cap">
                  <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                  <span class="hide-menu">Commisions</span>
                </li>

                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ URL::to('/agent-targets') }}" aria-expanded="false">
                    <span>
                        <i class="ti ti-target-arrow"></i>
                    </span>
                    <span class="hide-menu">Agent Targets</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ URL::to('/agent-commisions') }}" aria-expanded="false">
                    <span>
                        <i class="ti ti-brand-cashapp"></i>
                    </span>
                    <span class="hide-menu">Agent Commisions</span>
                    </a>
                  </li>

                  <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Marketing</span>
                  </li>

                  <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ URL::to('/campaigns') }}" aria-expanded="false">
                    <span>
                        <i class="ti ti-artboard"></i>
                    </span>
                    <span class="hide-menu">Campaigns</span>
                    </a>
                  </li>


                @endcan

                <li class="nav-small-cap">
                  <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                  <span class="hide-menu">OTHERS</span>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link" href="{{ URL::to('/reminders') }}" aria-expanded="false">
                  <span>
                      <i class="ti ti-speakerphone"></i>
                  </span>
                  <span class="hide-menu">Reminders & Schedules</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link" href="/account-settings" aria-expanded="false">
                  <span>
                      <i class="ti ti-adjustments-alt"></i>
                  </span>
                  <span class="hide-menu">Account Setting</span>
                  </a>
                </li>

                @can('isAdmin', App\Models\User::class)
                <li class="sidebar-item">
                  <a class="sidebar-link" href="{{ URL::to('/user/daily-report') }}" aria-expanded="false">
                  <span>
                      <i class="ti ti-file"></i>
                  </span>
                  <span class="hide-menu">User Report</span>
                  </a>
                </li>
                @endcan
            </ul>
            <div class="unlimited-access hide-menu bg-light-primary position-relative my-7 rounded">
              <div class="d-flex">
                <div class="unlimited-access-title">
                  <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Unlimited Access</h6>
                  {{-- <button class="btn btn-primary fs-2 fw-semibold lh-sm">Signup</button> --}}
                </div>
                <div class="unlimited-access-img">
                  <img src="{{ asset('dist/images/backgrounds/rocket.png') }}" alt="" class="img-fluid">
                </div>
              </div>
            </div>
          </nav>
          <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3">
            <div class="hstack gap-3">
              <div class="john-img">
                <img src="../../dist/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="">
              </div>
              <div class="john-title">
                <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                <span class="fs-2 text-dark">Designer</span>
              </div>
              <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                <i class="ti ti-power fs-6"></i>
              </button>
            </div>
          </div>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
</div>
