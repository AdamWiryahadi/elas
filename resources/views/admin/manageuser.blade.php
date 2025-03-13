<x-admin-layout>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-users mr-2"></i> User Management
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <!-- Admin Count Card -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $adminCount }}</h3>
                            <p>Total Admins</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </div>

                <!-- User Count Card -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $userCount }}</h3>
                            <p>Total Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">Manage Users</h3>
                            <a href="{{ route('admin.createuser') }}" class="btn btn-primary ms-auto">
                                <i class="fas fa-user-plus"></i> Add New User
                            </a>
                        </div>
                        <div class="card-body">
                            <!-- Search & Pagination Controls -->
                            <div class="d-flex justify-content-between mb-3">
                                <!-- Search Form -->
                                <form method="GET" action="{{ route('admin.manageuser') }}" class="d-flex">
                                    <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>

                                <!-- Pagination Dropdown -->
                                <form method="GET" action="{{ route('admin.manageuser') }}">
                                    <select name="per_page" class="form-select" onchange="this.form.submit()">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    </select>
                                </form>
                            </div>
                            @if ($users->isEmpty())
                                <p class="text-muted">No users found in the database.</p>
                            @else
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Quota</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="text-left">{{ $user->name }}</td>
                                                <td class="text-left">{{ $user->email }}</td>
                                                <td class="text-center">{{ $user->role }}</td>
                                                <td class="text-center">{{ $user->created_at->format('d-m-Y') }}</td>
                                                <td class="text-center">
                                                    @if ($settings->quota_enabled)
                                                        <form action="{{ route('admin.updatequota', $user->id) }}" method="POST" 
                                                            class="d-inline d-flex flex-column align-items-center">
                                                            @csrf
                                                            @method('PATCH')

                                                            <!-- Create a 2-column layout under "Quota" column -->
                                                            <div class="d-flex w-100 justify-content-center align-items-center">
                                                                <!-- Left Column: Quota Number -->
                                                                <div class="fw-bold text-center" style="width: 50px;">
                                                                    {{ $user->quota }}
                                                                </div>

                                                                <!-- Right Column: Input & Buttons (Inline) -->
                                                                <div class="d-flex align-items-center gap-1">
                                                                    <!-- Minus Button (Rounded) -->
                                                                    <button type="submit" name="action" value="decrease" 
                                                                            class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                                                            style="width: 30px; height: 30px;">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>

                                                                    <!-- Compact Input for Quota Adjustment -->
                                                                    <input type="number" name="amount" class="form-control form-control-sm text-center"
                                                                        style="width: 50px; padding: 2px;" min="1" placeholder="0" required>

                                                                    <!-- Plus Button (Rounded) -->
                                                                    <button type="submit" name="action" value="increase" 
                                                                            class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                                                            style="width: 30px; height: 30px;">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button> 
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @else
                                                        Unlimited
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Reset Password Button with Icon -->
                                                    <a href="{{ route('admin.resetpassword', $user->id) }}" class="btn btn-warning btn-sm" title="Reset Password">
                                                        <i class="fas fa-key"></i>
                                                    </a>

                                                    <!-- Delete Button with Icon -->
                                                    <form action="{{ route('admin.deleteuser', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete User">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $users->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>