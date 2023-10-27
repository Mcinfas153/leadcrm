<div class="container-fluid">
    <div wire:loading wire:target="">
        <livewire:components.progress-loader/>
    </div>
    <livewire:components.navigator title="agent commisions"/>
    <section>
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="/agent-performance-chart" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12 col-md-4">
                            <label for="exampleFormControlInput1" class="form-label">select a agent to view performance</label>
                            <select class="form-select" aria-label="agentId" name="agentId">
                                <option selected hidden>select an agent</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="exampleFormControlInput1" class="form-label">select start date</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                id="date-range-start"
                                name="startDate"
                            />
                        </div>
                    
                        <div class="col-12 col-md-4">
                            <label for="exampleFormControlInput1" class="form-label">select end date</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                id="date-range-end"
                                name="endDate"
                            />
                        </div>                       
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="exampleFormControlInput1" class="form-label"></label>
                        <button class="btn btn-rounded btn-primary" type="submit">Generate</button>
                    </div>
                </form>
                <div class="row">
                    <div class="mt-3">
                        {!! $chart->container() !!}
                    </div>                    
                </div>
            </div>
        </div>
    </section>
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
<script>
   let initialStartDate = "{{ $startDate }}";
</script>
</div>
