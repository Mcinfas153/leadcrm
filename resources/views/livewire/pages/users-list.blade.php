<div class="container-fluid">
    <livewire:components.navigator title="users"/>
    <div wire:loading>
        <livewire:components.progress-loader/>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex align-items-start">
                    <table id="zero_config"
                    class="table border table-striped table-bordered text-nowrap">
                    <thead>
                        <!-- start row -->
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Total Leads</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <!-- end row -->
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->phone }}
                            </td>
                            <td>
                                {{ $user->role->name }}
                            </td>
                            <td>
                                {{ count($user->leads) }}
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" onchange="userStatusChange({{ $user->id }},{{ $user->is_active }})" size="large" {{ $user->is_active ? "checked" : "" }} />
                                </div>
                            </td>
                            <td>
                                <a target="_BLANK" href="{{ URL::to('user/daily-report') }}/{{ $user->id }}" class="btn mb-1 btn-sm btn-info">
                                    User Activity
                                </a>
                                <button type="button" class="btn mb-1 btn-sm btn-danger" onclick="deleteUser({{ $user->id }},'{{ $user->name }}')">
                                    Delete
                                  </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $users->links() }}
                </div>
                
            </div>
        </div>
    </div>
</div>
