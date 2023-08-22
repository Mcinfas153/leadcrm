<div class="container-fluid">
    <livewire:components.navigator title="Comments & Activities"/>
    <div wire:loading wire:target="addComment">
        <livewire:components.progress-loader/>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card-body">
                <form wire:submit.prevent="addComment">
                    <div class="mb-3 d-flex flex-column">                            
                            <label for="note" class="form-label">Add your comment here...</label>
                            <input class="form-control" wire:model.defer="note">
                            @error('note') <span class="error">{{ $message }}</span> @enderror
                            <div class="align-self-end">
                                
                                <button type="submit" class="btn rounded-pill waves-effect waves-light btn-primary mt-2">
                                    Add Comment
                                </button>
                            </div>                                                  
                    </div>
                </form>
                @if ($notes->isEmpty())
                    <h5 class="card-title fw-semibold mb-3">There is no comments</h5>
                @else
                    <h5 class="card-title fw-semibold mb-3">Recent Comments</h5>
                @endif              
                @foreach ($notes as $note)
                    <livewire:components.comment-card :note="$note" :wire:key="$note->id">
                @endforeach
              </div>
        </div>       
    </div>
</div>
