<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Leave') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Pending Requests -->
                <h3 class="text-lg font-semibold mb-4">Pending Leave Requests</h3>
                @if ($pendingRequests->isEmpty())
                    <div class="text-gray-500">No pending leave requests.</div>
                @else
                    @include('admin.partials.leave_table', ['leaveRequests' => $pendingRequests, 'status' => 'Pending'])
                @endif

                <br><br>

                <!-- Approved Requests -->
                <h3 class="text-lg font-semibold mb-4 mt-8">Approved Leave Requests</h3>
                @if ($approvedRequests->isEmpty())
                    <div class="text-gray-500">No approved leave requests.</div>
                @else
                    @include('admin.partials.leave_table', ['leaveRequests' => $approvedRequests, 'status' => 'Approved'])
                @endif

                <br><br>

                <!-- Rejected Requests -->
                <h3 class="text-lg font-semibold mb-4 mt-8">Rejected Leave Requests</h3>
                @if ($rejectedRequests->isEmpty())
                    <div class="text-gray-500">No rejected leave requests.</div>
                @else
                    @include('admin.partials.leave_table', ['leaveRequests' => $rejectedRequests, 'status' => 'Rejected'])
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
