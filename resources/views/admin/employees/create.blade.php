@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-4">Add Employee</h1>

        <form method="POST" action="{{ route('employees.store') }}">
            @csrf

            <input class="input" name="name" placeholder="Name" required>
            <input class="input mt-2" name="email" placeholder="Email" required>
            <input class="input mt-2" name="phone" placeholder="Phone" required>
            <input class="input mt-2" name="password" type="password" placeholder="Password" required>

            <button class="bg-blue-600 text-white px-4 py-2 mt-4 rounded">
                Save
            </button>
        </form>
    </div>
@endsection
