<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Your Leave Requests</h3>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($leaveRequests->isEmpty())
                    <div class="text-gray-500">
                        You have not submitted any leave requests yet.
                    </div>
                @else
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 border text-left">Start Date</th>
                                <th class="px-4 py-2 border text-left">End Date</th>
                                <th class="px-4 py-2 border text-left">Leave Type</th>
                                <th class="px-4 py-2 border text-left">Reason</th>
                                <th class="px-4 py-2 border text-left">Status</th>
                                <th class="px-4 py-2 border text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaveRequests as $leaveRequest)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $leaveRequest->start_date }}</td>
                                    <td class="px-4 py-2 border">{{ $leaveRequest->end_date }}</td>
                                    <td class="px-4 py-2 border">{{ $leaveRequest->leave_type }}</td>
                                    <td class="px-4 py-2 border">{{ $leaveRequest->reason }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($leaveRequest->status === 'pending')
                                            <span class="text-yellow-500">Pending</span>
                                        @elseif ($leaveRequest->status === 'approved')
                                            <span class="text-green-500">Approved</span>
                                        @else
                                            <span class="text-red-500">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('user.editleave', $leaveRequest->id) }}"
                                               class="text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('user.deleteleave', $leaveRequest->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this leave request?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
