<div class="container-fluid">
    <livewire:components.navigator title="set target"/>
    <div wire:loading>
      <livewire:components.progress-loader/>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">     
                <form wire:submit.prevent="setTarget">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">select start date</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                id="date-range-start"
                                name="startDate"
                                onchange="setStartDate()"
                            />
                            @error('startingDate') <span class="error">{{ $message }}</span> @enderror
                        </div>                    
                        <div class="col-12 col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">select end date</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                id="date-range-end"
                                name="endDate"
                                onchange="setEndDate()"
                            />
                            @error('endingDate') <span class="error">{{ $message }}</span> @enderror
                        </div>   
                        <div class="col-12 col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">total amount</label>
                            <input
                                type="number"
                                class="form-control"
                                wire:model.defer="totalAmount"
                            />
                            @error('totalAmount') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">acheived amount (optional)</label>
                            <input
                                type="number"
                                class="form-control"
                                wire:model.defer="achievedAmount"
                            />
                        </div>
                        <div class="col-12 col-md-12" wire:ignore>
                            <label for="exampleFormControlInput1" class="form-label">select agent</label>
                            <select class="agents form-control" name="agents[]" multiple="multiple" onchange="selectAgent()">
                                @foreach ($agentList as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                              </select>                              
                        </div>
                        @error('agents') <span class="error">{{ $message }}</span> @enderror                        
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 mt-4">Submit</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
</div>

