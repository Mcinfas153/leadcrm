<div class="p-3 mb-1 border">
    <div class="d-flex align-items-center">
      <span class="bg-light-success text-success badge">Through: {{ $scheduler->reminderType->name }}</span>
      <span class="fs-3 ms-auto">Remind me On: {{ dateFormater($scheduler->reminder_time) }}</span>
    </div>
    <h6 class="mt-3">{{ $scheduler->user->name }}</h6>
    <span class="fs-3 lh-sm">{{ $scheduler->note }}</span>
    <div class="hstack gap-3 mt-3 d-flex justify-content-end">
      @can('delete', App\Models\Scheduler::find($scheduler->id))
      <a onclick="deleteNote({{ $scheduler->id }})" class="fs-3 text-bodycolor d-flex align-items-center text-decoration-none">
        <i class="ti ti-trash fs-6 text-danger me-2 d-flex"></i> Delete 
      </a>
      @endcan
    </div>
</div>
