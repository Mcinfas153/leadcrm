<div class="p-3 mb-1 border">
  <div class="d-flex align-items-center">
    <span class="bg-light-success text-success badge">Approved</span>
    <span class="fs-3 ms-auto">{{ dateFormater($note->created_at, 'YYYY-MM-DD, h:mm a') }}</span>
  </div>
  <h6 class="mt-3">{{ $note->owner->name }}</h6>
  <span class="fs-3 lh-sm">{{ $note->note }}</span>
  <div class="hstack gap-3 mt-3 d-flex justify-content-end">
    @can('delete', App\Models\Note::find($note->id))
    <a onclick="deleteNote({{ $note->id }})" class="fs-3 text-bodycolor d-flex align-items-center text-decoration-none">
      <i class="ti ti-trash fs-6 text-danger me-2 d-flex"></i> Delete 
    </a>
    @endcan
  </div>
</div>