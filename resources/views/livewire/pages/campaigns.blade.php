<div class="container-fluid">
    <livewire:components.navigator title="campaigns"/>
    <div wire:loading>
        <livewire:components.progress-loader/>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex align-items-start">
                    <table id="zero_config"
                    class="table table-striped border text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Leads Count</th>
                                {{-- <th class="text-center">Status</th> --}}
                                <th class="text-center">Action</th>
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            @if ($campaigns->isEmpty())
                                <tr>
                                    <td colspan="3"><h6 class="text-center">There is No Data Available</h6></td>
                                </tr>
                            @else
                                @foreach ($campaigns as $campaign)
                                    <tr>
                                        <td>{{ $campaign->campaign_name }}</td>
                                        <td class="text-center">{{ $campaign->lead_count }}</td>
                                        {{-- <td class="text-center">{{ campaignStatus($campaign->created_at) }}</td> --}}
                                        <td class="text-center">
                                            <a href="" type="button" class="btn btn-rounded btn-warning btn-sm"><i class="ti ti-settings-automation mx-1"></i>automation</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Leads Count</th>
                                {{-- <th class="text-center">Status</th> --}}
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>                        
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $campaigns->links() }}
                </div>
                
            </div>
        </div>
    </div>
</div>
