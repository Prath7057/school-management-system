<x-school-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight text-center">
            {{ auth()->guard('school')->user()->name . ' - QR Codes' }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 mt-6">
        <div class="bg-white shadow-lg sm:rounded-xl p-6">
            <h2 class="text-center text-xl font-bold text-gray-700 mb-6">Student QR Codes</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($students as $student)
                    <div class="bg-white rounded-lg shadow-md p-5 flex flex-col items-center border border-gray-200 hover:shadow-lg transition">
                        <!-- Profile Picture -->
                        @if($student->profile_picture)
                            <img src="{{ asset('storage/' . $student->profile_picture) }}" 
                                 alt="Profile Picture"
                                 class="w-20 h-20 rounded-full border border-gray-300 shadow-sm">
                        @else
                            <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 text-xs">
                                No Image
                            </div>
                        @endif

                        <!-- Student Name -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-3">{{ $student->name }}</h3>
                        
                        <!-- QR Code -->
                        <div id="qrcode-{{ $student->id }}" class="my-3"></div>

                        <!-- Student Details -->
                        <div class="text-sm text-gray-700 space-y-1 text-center w-full">
                            <p><span class="font-semibold">Email:</span> {{ $student->email }}</p>
                            <p><span class="font-semibold">Class:</span> {{ $student->class }}</p>
                            <p><span class="font-semibold">Age:</span> {{ $student->age }}</p>
                            <p><span class="font-semibold">Gender:</span> {{ ucfirst($student->gender) }}</p>
                            <p><span class="font-semibold">School ID:</span> {{ $student->school_id }}</p>
                            <p><span class="font-semibold">Country:</span> {{ $student->country }}</p>
                            <p><span class="font-semibold">State:</span> {{ $student->state }}</p>
                            <p><span class="font-semibold">City:</span> {{ $student->city }}</p>
                            <p><span class="font-semibold">ZIP Code:</span> {{ $student->zip_code }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('School.listStudents') }}" 
                   class="bg-blue-600 text-white px-5 py-2 rounded-md text-sm font-semibold shadow-md hover:bg-blue-700 transition">
                    Back to Students
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
      
    </script>
</x-school-app-layout>
