<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-sm sm:rounded-lg" style="width: 50%">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center mb-4">
            {{ __('Add Student Form') }}
        </h2>
        <form action="{{ route('School.storeStudent') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="class" :value="__('Class')" />
                    <x-text-input id="class" class="block mt-1 w-full" type="text" name="class" required />
                    @error('class') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="age" :value="__('Age')" />
                    <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" required />
                    @error('age') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select name="gender" id="gender" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Male">{{ __('Male') }}</option>
                        <option value="Female">{{ __('Female') }}</option>
                        <option value="Other">{{ __('Other') }}</option>
                    </select>
                    @error('gender') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="country" :value="__('Country')" />
                    <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" required />
                    @error('country') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="state" :value="__('State')" />
                    <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" required />
                    @error('state') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="city" :value="__('City')" />
                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" required />
                    @error('city') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label for="zip_code" :value="__('Zip Code')" />
                    <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" required />
                    @error('zip_code') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                <x-text-input id="profile_picture" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="file" name="profile_picture" />
                @error('profile_picture') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 text-center">
                <x-primary-button>
                    {{ __('Add Student') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
