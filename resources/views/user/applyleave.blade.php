<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply Leave') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Leave Application Form</h3>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.storeleave') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="leave_type" class="block text-sm font-medium text-gray-700">Leave Type</label>
                        <select name="leave_type" id="leave_type" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>Select Leave Type</option>
                            <option value="annual">Annual</option>
                            <option value="emergency">Emergency</option>
                            <option value="medical">Medical</option>
                            <option value="maternity">Maternity</option>
                            <option value="paternity">Paternity</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea name="reason" id="reason" rows="4" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-black font-semibold py-2 px-4 rounded-md border-2 border-indigo-500 hover:bg-indigo-700 hover:border-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Apply for Leave
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
