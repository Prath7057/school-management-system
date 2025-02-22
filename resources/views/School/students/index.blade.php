<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <a href="{{ route('School.addStudent') }}">
                <x-primary-button class="mb-4">{{ __('Add Student') }}</x-primary-button>
            </a>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Class</th>
                        <th class="border px-4 py-2">Age</th>
                        <th class="border px-4 py-2">Gender</th>
                        <th class="border px-4 py-2">City</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td class="border px-4 py-2">{{ $student->name }}</td>
                        <td class="border px-4 py-2">{{ $student->email }}</td>
                        <td class="border px-4 py-2">{{ $student->class }}</td>
                        <td class="border px-4 py-2">{{ $student->age }}</td>
                        <td class="border px-4 py-2">{{ $student->gender }}</td>
                        <td class="border px-4 py-2">{{ $student->city }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('School.editStudent', $student->id) }}" 
                               class="text-blue-600 edit-student"
                               data-name="{{ $student->name }}">
                                Edit
                            </a>

                            <form action="{{ route('School.deleteStudent', $student->id) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2 delete-student" data-name="{{ $student->name }}">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $students->links() }} <!-- Pagination -->
            </div>
        </div>
    </div>

    <!-- JavaScript for Confirmation Alerts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Edit Confirmation
            document.querySelectorAll('.edit-student').forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    let studentName = this.getAttribute('data-name');
                    if (confirm(`Are you sure you want to edit ${studentName}?`)) {
                        window.location.href = this.href;
                    }
                });
            });

            // Delete Confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    let studentName = this.querySelector('.delete-student').getAttribute('data-name');
                    if (confirm(`Are you sure you want to delete ${studentName}? This action cannot be undone.`)) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
