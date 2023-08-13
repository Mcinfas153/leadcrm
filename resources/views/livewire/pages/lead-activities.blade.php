<div class="container-fluid">
    <livewire:components.navigator title="Comments & Activities"/>
    <div class="row">
        <div class="col-lg-6">
            <div class="card-body">
                @if ($activities->isEmpty())
                    <h5 class="card-title fw-semibold mb-3">There is no activies</h5>
                @else
                    <h5 class="card-title fw-semibold mb-3">Recent Activities</h5>
                @endif              
                <ul class="timeline-widget mb-0 position-relative mb-n5">
                @foreach ($activities as $activity)
                    <livewire:components.activity-panel :activity="$activity" :wire:key="$activity->id">
                @endforeach
                </ul>
              </div>
        </div>       
    </div>
</div>

