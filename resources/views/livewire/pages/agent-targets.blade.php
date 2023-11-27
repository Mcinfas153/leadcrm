<div class="container-fluid">
    <livewire:components.navigator title="agent targets"/>
    <div wire:loading>
        <livewire:components.progress-loader/>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row-reverse bd-highlight mb-2">
                    <a href="{{ URL::to('/agent/create-target') }}" type="button" class="btn btn-success lead-table-btn">Create Target</a>
                </div>
                <div class="table-responsive tscroll d-flex align-items-start">                    
                    <table id="zero_config"
                        class="table table-striped text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th class="text-left">Agent</th>
                                <th class="text-center">Starting Period</th>
                                <th class="text-center">Ending Period</th>
                                <th class="text-center">Total Target</th>
                                <th class="text-center">Achieved Target</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            @if ($targets->isEmpty())
                                <tr>
                                    <td colspan="7"><h6 class="text-center">There is No Data Available</h6></td>
                                </tr>
                            @else
                                @foreach ($targets as $target)
                                    <tr>
                                        <td>{{ $target->agent->name }}</td>
                                        <td class="text-center">{{ $target->starting_date }}</td>
                                        <td class="text-center">{{ $target->ending_date }}</td>
                                        <td class="text-center">{{ number_format($target->total_amount, 2) }}</td>
                                        <td class="text-center">{{ number_format($target->achieved_amount, 2) }}</td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $target->is_active ? "checked":"" }} onchange="changeTargetStatus({{ $target->id }}, {{ $target->is_active }})">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">{{ $target->is_active ? 'active':'not active' }}</label>
                                              </div>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-rounded btn-warning btn-sm" href="{{ URL::to('/agent/view-target') }}/{{ $target->id }}">edit</a>
                                            <button class="btn btn-rounded btn-danger btn-sm" onclick="deleteTarget('{{ $target->id }}')">delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>Agent</th>
                                <th class="text-center">Starting Period</th>
                                <th class="text-center">Ending Period</th>
                                <th class="text-center">Total Target</th>
                                <th class="text-center">Achieved Target</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                {{ $targets->links() }}
                </div>
                
            </div>
        </div>
    </div>
</div>

