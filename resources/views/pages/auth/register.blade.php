@extends('templates.app')

@section('title', 'Register')

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Register your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @if ($errors->any())
                <div class="mt-6 bg-red-200 px-4 py-6">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block">Name</label>
                    <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400"
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required>
                </div>

                <div>
                    <label for="email" class="block">Email</label>
                    <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400"
                           type="email"
                           name="email" id="email"
                           required>
                </div>

                <div>
                    <label for="password" class="block">Password</label>
                    <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400"
                           type="password"
                           name="password"
                           id="password"
                           required>
                </div>

                <div>
                    <label for="password_confirmation" class="block">Confirm Password</label>
                    <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400"
                           type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           required>
                </div>

                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
            </form>
        </div>
    </div>
@endsection
