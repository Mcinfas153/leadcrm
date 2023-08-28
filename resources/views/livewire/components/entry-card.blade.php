<div class="p-3 mb-1 border">
    <div class="d-flex align-items-center">
      <span class="bg-light-info text-info badge">I made a {{ $entry->type }}</span>
      <span class="fs-3 ms-auto">On: {{ dateFormater($entry->entry_time) }}</span>
    </div>
    <h6 class="mt-3">{{ $entry->user->name }}</h6>
    <span class="fs-3 lh-sm">{{ $entry->note }}</span>
    <div class="hstack gap-3 mt-3 d-flex justify-content-between">
        <span class="bg-light-{{ $entry->response == 'negative' ? 'danger': 'success' }} text-{{ $entry->response == 'negative' ? 'danger': 'success' }} badge">Response: {{ $entry->response }}</span>
      @can('delete', App\Models\LeadEntry::find($entry->id))
      <a onclick="deleteEntry({{ $entry->id }})" class="fs-3 text-bodycolor d-flex align-items-center text-decoration-none">
        <i class="ti ti-trash fs-6 text-danger me-2 d-flex"></i> Delete 
      </a>
      @endcan
    </div>
</div>

