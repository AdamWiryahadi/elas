<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Leave') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Edit Leave Request</h3>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.updateleave', $leaveRequest->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="leave_type" class="block text-sm font-medium text-gray-700">Leave Type</label>
                        <select name="leave_type" id="leave_type" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="annual" {{ $leaveRequest->leave_type === 'annual' ? 'selected' : '' }}>Annual</option>
                            <option value="emergency" {{ $leaveRequest->leave_type === 'emergency' ? 'selected' : '' }}>Emergency</option>
                            <option value="medical" {{ $leaveRequest->leave_type === 'medical' ? 'selected' : '' }}>Medical</option>
                            <option value="maternity" {{ $leaveRequest->leave_type === 'maternity' ? 'selected' : '' }}>Maternity</option>
                            <option value="paternity" {{ $leaveRequest->leave_type === 'paternity' ? 'selected' : '' }}>Paternity</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" required value="{{ $leaveRequest->start_date }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" required value="{{ $leaveRequest->end_date }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea name="reason" id="reason" rows="4" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ $leaveRequest->reason }}</textarea>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-black font-semibold py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Update Leave
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
