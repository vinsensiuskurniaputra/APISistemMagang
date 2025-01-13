@extends('layouts.admin')

@section('title', 'Edit Student')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-300">Edit Student</h1>
            <a href="{{ route('admin.students.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="bg-gray-800 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="name">
                        Full Name
                    </label>
                    <input type="text" name="name" id="name" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('name', $student->user->name) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input type="email" name="email" id="email" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('email', $student->user->email) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="username">
                        Username/NIM
                    </label>
                    <input type="text" name="username" id="username" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('username', $student->user->username) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="class">
                        Class
                    </label>
                    <input type="text" name="class" id="class" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('class', $student->class) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="academic_year">
                        Academic Year
                    </label>
                    <input type="text" name="academic_year" id="academic_year" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('academic_year', $student->academic_year) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="study_program_id">
                        Study Program
                    </label>
                    <select name="study_program_id" id="study_program_id" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" required>
                        <option value="">Select Study Program</option>
                        @foreach($studyPrograms as $program)
                            <option value="{{ $program->id }}" 
                                {{ (old('study_program_id', $student->study_program_id) == $program->id) ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="lecturer_id">
                        Supervisor Lecturer
                    </label>
                    <select name="lecturer_id" id="lecturer_id" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" required>
                        <option value="">Select Lecturer</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" 
                                {{ (old('lecturer_id', $student->lecturer_id) == $lecturer->id) ? 'selected' : '' }}>
                                {{ $lecturer->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Student
                </button>
            </div>
        </form>

        <!-- Separate section for internships -->
        <div class="bg-gray-800 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 mt-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-300">Internships History</h2>
                <div x-data="{ open: false }" @keydown.escape.window="open = false">
                    <button type="button" @click="open = true" 
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Add New Internship
                    </button>

                    <!-- Modal -->
                    <div x-show="open" 
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        
                        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md"
                            @click.away="open = false">
                            <h3 class="text-xl font-bold text-gray-300 mb-4">Add New Internship</h3>
                            
                            <form id="addInternshipForm" class="space-y-4">
                                <div>
                                    <label class="block text-gray-300 text-sm font-bold mb-2">Industry</label>
                                    <select id="modal_industry_id" class="bg-gray-700 text-white rounded w-full p-2.5" required>
                                        <option value="">Select Industry</option>
                                        @foreach($industries as $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-300 text-sm font-bold mb-2">Start Date</label>
                                    <input type="date" id="modal_start_date" class="bg-gray-700 text-white rounded w-full p-2.5" required>
                                </div>

                                <div>
                                    <label class="block text-gray-300 text-sm font-bold mb-2">End Date</label>
                                    <input type="date" id="modal_end_date" class="bg-gray-700 text-white rounded w-full p-2.5">
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <button type="button" @click="open = false" 
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        Cancel
                                    </button>
                                    <button type="button" @click="submitInternship(); open = false" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Industry</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">End Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600" id="internships-container">
                        @foreach($student->internships as $index => $internship)
                        <tr class="internship-row" id="internship-row-{{$index}}">
                            <td class="px-6 py-4">
                                <input type="hidden" name="internships[{{$index}}][id]" value="{{ $internship->id }}">
                                <select name="internships[{{$index}}][industry_id]" 
                                    class="bg-gray-600 text-white rounded w-full p-2" required>
                                    <option value="">Select Industry</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}" 
                                            {{ $internship->industry_id == $industry->id ? 'selected' : '' }}>
                                            {{ $industry->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <input type="date" name="internships[{{$index}}][start_date]"
                                    class="bg-gray-600 text-white rounded w-full p-2"
                                    value="{{ $internship->start_date }}" required>
                            </td>
                            <td class="px-6 py-4">
                                <input type="date" name="internships[{{$index}}][end_date]"
                                    class="bg-gray-600 text-white rounded w-full p-2"
                                    value="{{ $internship->end_date }}">
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" 
                                    onclick="deleteInternshipRow('{{ route('admin.internships.destroy', $internship->id) }}', {{$index}}, {{ $internship->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let internshipIndex = {{ count($student->internships) }};

    function submitInternship() {
        const industry_id = document.getElementById('modal_industry_id').value;
        const start_date = document.getElementById('modal_start_date').value;
        const end_date = document.getElementById('modal_end_date').value;

        if (!industry_id || !start_date) {
            alert('Please fill in all required fields');
            return;
        }

        const formData = {
            industry_id: industry_id,
            start_date: start_date,
            end_date: end_date
        };

        fetch('{{ route('admin.internships.store', $student->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Get industry name for the selected option
                const industrySelect = document.getElementById('modal_industry_id');
                const industryName = industrySelect.options[industrySelect.selectedIndex].text;

                // Add new row to table
                const template = `
                    <tr class="internship-row" id="internship-row-${data.data.id}">
                        <td class="px-6 py-4">
                            <input type="hidden" name="internships[${internshipIndex}][id]" value="${data.data.id}">
                            <select name="internships[${internshipIndex}][industry_id]" 
                                class="bg-gray-600 text-white rounded w-full p-2" required>
                                <option value="${industry_id}" selected>${industryName}</option>
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <input type="date" name="internships[${internshipIndex}][start_date]"
                                class="bg-gray-600 text-white rounded w-full p-2"
                                value="${start_date}" required>
                        </td>
                        <td class="px-6 py-4">
                            <input type="date" name="internships[${internshipIndex}][end_date]"
                                class="bg-gray-600 text-white rounded w-full p-2"
                                value="${end_date || ''}">
                        </td>
                        <td class="px-6 py-4">
                            <button type="button" 
                                onclick="deleteInternshipRow('{{ url('admin/internships') }}/${data.data.id}', ${internshipIndex})"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                Delete
                            </button>
                        </td>
                    </tr>
                `;
                
                document.querySelector('#internships-container').insertAdjacentHTML('beforeend', template);
                internshipIndex++;

                // Reset form and close modal
                document.getElementById('modal_industry_id').value = '';
                document.getElementById('modal_start_date').value = '';
                document.getElementById('modal_end_date').value = '';
                document.querySelector('[x-data]').__x.$data.open = false;
            } else {
                throw new Error(data.message || 'Error adding internship');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Error adding internship');
        });
    }

    function deleteInternshipRow(url, index, internshipId) {
        if (confirm('Are you sure you want to delete this internship?')) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the row from the table
                    const row = document.getElementById(`internship-row-${index}`);
                    if (row) {
                        row.remove();
                    }
                    // Show success message
                    alert('Internship deleted successfully');
                } else {
                    throw new Error(data.message || 'Error deleting internship');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Error deleting internship');
            });
        }
    }

</script>
@endpush
