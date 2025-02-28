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
                                        <!-- Hidden input to ensure a value is always sent -->
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
                </div>
            </div> 
        </div>
    </div>
</x-admin-layout>
