<x-school-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->guard('school')->user()->name . " - Dashboard" ?? 'School - Dashboard' }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <a href="{{ route('School.addStudent') }}">
                <x-primary-button class="mb-4">{{ __('Add Student') }}</x-primary-button>
            </a>

            <!--filter
                
            <form method="GET" action="{{ route('School.listStudents') }}" class="mb-2">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="class" value="{{ request('class') }}" class="form-control"
                            placeholder="Enter Class">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="age" value="{{ request('age') }}" class="form-control"
                            placeholder="Enter Age">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="city" value="{{ request('city') }}" class="form-control"
                            placeholder="Enter City">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('School.listStudents') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

        -->
            <div class="table-responsive">
                <table id="studentsTable" class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Class</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>City</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : 'https://dummyimage.com/48X48/5c5b5c/ffffff.png&text=Image' }}" 
                                        alt="Profile Picture" 
                                        class="w-12 h-12 rounded-md object-cover mx-auto border border-gray-300 shadow-md">
                                </td>
                                
                                
                                
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->class }}</td>
                                <td>{{ $student->age }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>{{ $student->city }}</td>
                                <td>
                                    <a href="{{ route('School.editStudent', $student->id) }}"
                                        class="btn btn-primary btn-sm edit-student" data-name="{{ $student->name }}">
                                        Edit
                                    </a>

                                    <form action="{{ route('School.deleteStudent', $student->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-student"
                                            data-name="{{ $student->name }}">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#studentsTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 5,
                "searching": true,
                "lengthChange": true,
                "lengthMenu": [5, 10, 20, 50, 100],
                
            });

            $('.edit-student').on('click', function(event) {
                event.preventDefault();
                let studentName = $(this).data('name');
                if (confirm(`Are you sure you want to edit ${studentName}?`)) {
                    window.location.href = $(this).attr('href');
                }
            });

            $('.delete-form').on('submit', function(event) {
                event.preventDefault();
                let studentName = $(this).find('.delete-student').data('name');
                if (confirm(
                        `Are you sure you want to delete ${studentName}? This action cannot be undone.`)) {
                    this.submit();
                }
            });
        });
    </script>
</x-school-app-layout>
