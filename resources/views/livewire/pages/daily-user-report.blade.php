<div class="container-fluid">
    <livewire:components.navigator title="user report"/>
    <div wire:loading wire:target="userId,period">
        <livewire:components.progress-loader/>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Please Select a User to View Report</label>
                        <select class="form-control" wire:model="userId">
                            <option selected hidden>Select a User</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach                            
                        </select>
                    </div>
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="exampleFormControlInput1" class="form-label">Please Select a Period of Time</label>
                        <select
                            class="form-control"
                            style="width: 100%; height: 36px"
                            wire:model="period"
                            >
                            <option hidden>Select a Period of Time</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        <a class="btn btn-primary mt-3" href="{{ URL::to('user/report') }}/{{ $userId }}/{{ $period }}">Download Current Report</a>
                    </div>                    
                </div>
                <h5 class="card-title fw-semibold mb-3">{{ $selectedUser->name ?? '' }}</h5>
                @if (!$activities->isEmpty())
                <div class="row mb-3">
                    @foreach ($activityStats as $activityStat)
                    <div class="col-sm-6 col-lg-4 col-xl-2">
                        {{-- <livewire:components.data-box stat="{{ $activityStat->stat }}" actionName="{{ $activityStat->action_name }}" :wire:key="$activityStat->id"/> --}}
                        <a href="javascript:void(0)" class="p-4 text-center bg-light-{{ Arr::random($dataBox) }} card shadow-none rounded-2">
                            <img src="{{ Arr::random($dataBoxImg) }}" width="50" height="50" class="mb-6 mx-auto" alt="">
                            <p class="fw-semibold text-{{ Arr::random($dataBox) }} mb-1">{{ Str::title($activityStat->action_name) }}</p>
                            <h4 class="fw-semibold text-{{ Arr::random($dataBox) }} mb-0">{{ $activityStat->stat }}</h4>
                        </a>
                    </div>
                    @endforeach
                  </div>
                @endif
                <div class="row mb-3">
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                        @if (isset($userId) && $activities->isEmpty())
                            <h5 class="card-title fw-semibold mb-3">No Activities Found</h5>
                        @endif
                        @if (!$activities->isEmpty())
                            <h5 class="card-title fw-semibold mb-3">Recent Activities</h5>                            
                        @endif                        
                        @foreach ($activities as $activity)
                            <livewire:components.activity-panel :activity="$activity" :wire:key="$activity->id"/>
                        @endforeach
                    </ul> 
                </div>
                <div class="mt-5">
                    {{ $activities->links() }}    
                </div>                            
            </div>            
          </div>
        </div>
    </div>    
</div>
