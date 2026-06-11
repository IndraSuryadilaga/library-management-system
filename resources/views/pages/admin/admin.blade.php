@extends('templates.app')

@section('title', 'Admin Panel - Pustaka Nusantara')

@section('slot')
    <div class="flex min-h-screen bg-cream-50 font-body">
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-parchment border-b border-cream-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="font-display text-3xl font-semibold text-bark-500">@yield('title', 'Dashboard')</h1>
                    <!-- User profile can go here -->
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-cream-50 p-bento-gap">
                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
@endsection
