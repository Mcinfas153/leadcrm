<div class="container-fluid">
    <livewire:components.navigator title="closing deal"/>
    <div wire:loading wire:target="">
        <livewire:components.progress-loader/>
    </div>
    <section>
        <div class="card w-100">
            <div class="card-body">
                <div class="mb-4">
                    <h5>Closing a Deal</h5>
                </div>
                <form wire:submit.prevent="closeDeal">
                    <div class="row">

                        <div class="col-md-6 form-group mb-3">
                            <label for="totalValue">Total Value of Deal *</label>
                            <input type="number" class="form-control" wire:model.defer="totalValue" placeholder="1000000">
                            @error('totalValue')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="totalCommision">Total Commision *</label>
                            <input type="number" class="form-control" wire:model.defer="totalCommision" placeholder="250000">
                            @error('totalCommision')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="agentId">Agent *</label>
                            <select class="form-control" wire:model.defer="agentId">
                                <option hidden selected>select an agent</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                            @error('agentId')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="agentCommision">Agent Commision *</label>
                            <input type="number" class="form-control" wire:model.defer="agentCommision" placeholder="100000">
                            @error('agentCommision')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success rounded-pill px-5 mt-4">Close this Deal</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

