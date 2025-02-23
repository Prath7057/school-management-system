<x-school-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->guard('school')->user()->name . ' - Dashboard' ?? 'School - Dashboard' }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-sm sm:rounded-lg mt-4" style="width: 50%">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center mb-4">
            {{ __('Import Students') }}
        </h2>

        @if ($errors->has('import_file'))
            <div class="alert alert-danger">
                {{ $errors->first('import_file') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{!! session('error') !!}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green text-red px-4 py-3 rounded relative" style="color:green;border:1px solid green;"
                role="alert">
                <strong class="font-bold bg-green text-red">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('School.importStudents') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div>
                <x-input-label for="file" :value="__('Upload CSV File')" />
                <x-text-input id="file" class="block mt-1 w-full border-gray-300 shadow-sm"
                    style="border-radius: 0px;" type="file" name="file" required />
                @error('file')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 text-center">
                <x-primary-button>
                    {{ __('Import Students') }}
                </x-primary-button>
            </div>
        </form>

        <p class="mt-3 text-sm text-gray-600"><strong>CSV Format:</strong> name, email, class, age, gender,
            profile_picture, country, state, city, zip_code</p>
        <a href="{{ asset('storage/Students.csv') }}"
            class="inline-block text-red font-bold rounded-md text-sm text-red-600" download>
            Click Here To Download Sample CSV
        </a>
    </div>
</x-school-app-layout>
