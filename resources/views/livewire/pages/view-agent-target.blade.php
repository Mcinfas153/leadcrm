<div class="container-fluid">
    <livewire:components.navigator title="view agent target"/>
    <div wire:loading>
      <livewire:components.progress-loader/>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">   
                <h6 class="mb-3 fw-bolder">Agent Name: {{ $agentName }}</h6>  
                <form wire:submit.prevent="updateTarget">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">select start date</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                id="date-range-start"
                                name="startDate"
                                value="{{ $startingDate }}"
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
                                value="{{ $endingDate }}"
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


