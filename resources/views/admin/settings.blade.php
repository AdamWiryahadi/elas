<x-admin-layout>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-sliders-h"></i> Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Settings Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-cogs"></i> Quota Settings</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Toggle Quota System -->
                                <div class="form-group">
                                    <label>Enable Quota System:</label>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="quota_enabled" value="0">
                                        <input type="checkbox" class="custom-control-input" id="quota_enabled" name="quota_enabled" value="1" {{ $settings->quota_enabled ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="quota_enabled">Enable</label>
                                    </div>
                                </div>

                                <!-- Quota Limit -->
                                <div class="form-group">
                                    <label>Set Quota Limit:</label>
                                    <input type="number" class="form-control" name="quota_limit" value="{{ $settings->quota_limit }}" placeholder="Enter quota limit or leave blank for unlimited">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
                            </form>
                        </div>
                    </div>

                    <!-- Holiday Management Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Holiday Management</h3>
                        </div>
                        <div class="card-body">
                            <!-- Add New Holiday Form -->
                            <form action="{{ route('admin.holidays.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Holiday Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter holiday name" required>
                                </div>

                                <div class="form-group">
                                    <label>Holiday Date:</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>

                                <button type="submit" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Holiday</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Existing Holidays List -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-list"></i> Existing Holidays</h3>
                        </div>
                        <div class="card-body">
                            <!-- Search & Pagination Controls -->
                            <div class="d-flex justify-content-between mb-3">
                                <!-- Search Form -->
                                <form method="GET" action="{{ route('admin.settings') }}" class="d-flex">
                                    <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>

                                <!-- Pagination Dropdown -->
                                <form method="GET" action="{{ route('admin.settings') }}">
                                    <!-- Preserve Search Query When Changing Per Page -->
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <select name="per_page" class="form-select" onchange="this.form.submit()">
                                        <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                    </select>
                                </form>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($holidays as $holiday)
                                        <tr>
                                            <td class="text-left">{{ $holiday->name }}</td>
                                            <td class="text-center">{{ $holiday->date }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $holiday->id }})">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>

                                                <form id="delete-form-{{ $holiday->id }}" action="{{ route('admin.holidays.delete', $holiday->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                             <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $holidays->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
                            </div>
                        </div>
                    </div>
                </div>                
            </div> 
        </div>
    </div>
</x-admin-layout>

<style>
    .pagination {
        display: flex !important; /* Ensure it shows */
        justify-content: center;
    }
</style>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This holiday will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

