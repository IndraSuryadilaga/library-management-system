@extends('templates.app')

@section('title', 'Register')

@section('content')
    <div class="flex min-h-full flex-col justify-center py-12 lg:px-8">
        <div
            class="sm:mx-auto sm:w-full sm:max-w-xl bg-parchment border border-cream-200 rounded-card-lg overflow-hidden paper-grain p-8">
            <div class="text-center">
                <h2 class="text-2xl font-bold leading-9 tracking-tight text-bark-900">Register your
                    account</h2>
                <p class="mt-2 text-sm text-dusty">
                    Already have an account?
                    <x-atoms.button :href="route('login')" variant="tertiary">
                        Sign in
                    </x-atoms.button>
                </p>
            </div>

            <div class="mt-10">
                @if ($errors->any())
                    <div class="mt-6 bg-red-200 px-4 py-6 rounded-lg">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <x-molecules.form-group name="name" label="Name">
                        <x-atoms.input type="text" name="name" id="name" value="{{ old('name') }}" required />
                    </x-molecules.form-group>

                    <x-molecules.form-group name="email" label="Email">
                        <x-atoms.input type="email" name="email" id="email" required />
                    </x-molecules.form-group>

                    <x-molecules.form-group name="password" label="Password">
                        <x-atoms.input type="password" name="password" id="password" required />
                    </x-molecules.form-group>

                    <x-molecules.form-group name="password_confirmation" label="Confirm Password">
                        <x-atoms.input type="password" name="password_confirmation" id="password_confirmation"
                            required />
                    </x-molecules.form-group>

                    <div class="mt-8">
                        <div class="my-4">
                            <x-atoms.button type="submit" variant="primary" class="w-full">Sign in</x-atoms.button>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-cream-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="bg-parchment px-2 text-dusty">Or continue with</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-atoms.button variant="secondary" class="w-full">
                                <x-slot name="icon">
                                    {{-- Placeholder for Google Icon --}}
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M21.35,11.1H12.18V13.83H18.69C18.36,17.64 15.19,19.27 12.19,19.27C8.36,19.27 5,16.25 5,12.5C5,8.75 8.36,5.73 12.19,5.73C15.19,5.73 17.5,6.7 17.5,6.7L19.43,4.82C19.43,4.82 16.91,3 12.19,3C6.42,3 2.03,7.23 2.03,12.5C2.03,17.77 6.42,22 12.19,22C17.96,22 21.54,18.22 21.54,12.81C21.54,12.03 21.47,11.56 21.35,11.1Z" />
                                    </svg>
                                </x-slot>
                                <span>Continue with Google</span>
                            </x-atoms.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
