<x-school-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->guard('school')->user()->name . " - Dashboard" ?? 'School - Dashboard' }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto p-4 bg-white shadow-sm sm:rounded-lg mt-4" style="width: 50%;">
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Edit Student') }}
        </h2>

        <form action="{{ route('School.updateStudent', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $student->name }}" required autofocus />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $student->email }}" required />
                </div>

                <div>
                    <x-input-label for="class" :value="__('Class')" />
                    <select id="class" name="class" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="">Select Class</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" @selected($student->class == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('class') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="age" :value="__('Age')" />
                    <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" value="{{ $student->age }}" required />
                </div>

                <div>
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select name="gender" id="gender" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Male" @selected($student->gender == 'Male')>{{ __('Male') }}</option>
                        <option value="Female" @selected($student->gender == 'Female')>{{ __('Female') }}</option>
                        <option value="Other" @selected($student->gender == 'Other')>{{ __('Other') }}</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                    
                    <div class="flex items-center gap-4">
                        <x-text-input id="profile_picture" class="block mt-1 w-full" style="border-radius: 0px;" type="file" name="profile_picture" />
                        
                        @if($student->profile_picture)
                            <img src="{{ asset('storage/' . $student->profile_picture) }}" 
                                 alt="Profile Picture" 
                                 class="w-12 h-12 rounded cursor-pointer border" 
                                 id="thumbnail">
                        @endif
                    </div>
                </div>
                

                <div>
                    <x-input-label for="country" :value="__('Country')" />
                    <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" value="{{ $student->country }}" required />
                </div>

                <div>
                    <x-input-label for="state" :value="__('State')" />
                    <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" value="{{ $student->state }}" required />
                </div>

                <div>
                    <x-input-label for="city" :value="__('City')" />
                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" value="{{ $student->city }}" required />
                </div>

                <div>
                    <x-input-label for="zip_code" :value="__('Zip Code')" />
                    <x-text-input id="zip_code" class="block mt-1 w-full" type="number" name="zip_code" value="{{ $student->zip_code }}" required />
                </div>
            </div>

            <x-primary-button class="mt-4">
                {{ __('Update Student') }}
            </x-primary-button>
        </form>
    </div>

    <div id="popup-container" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <img id="popup-image" class="max-w-full max-h-full rounded-lg shadow-lg">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const thumbnail = document.getElementById("thumbnail");
            const popupContainer = document.getElementById("popup-container");
            const popupImage = document.getElementById("popup-image");

            if (thumbnail) {
                thumbnail.addEventListener("click", function () {
                    popupImage.src = thumbnail.src;
                    popupContainer.classList.remove("hidden");
                });
            }

            popupContainer.addEventListener("click", function (event) {
                if (event.target !== popupImage) {
                    popupContainer.classList.add("hidden");
                }
            });
        });
    </script>
    
</x-school-app-layout>
