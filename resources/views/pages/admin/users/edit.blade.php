@extends('pages.admin.admin')

@section('title', 'Ubah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Pengguna</h1>
            <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk <span class="font-medium text-bark-500">{{ $user->name }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.users.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-card relative mb-bento-gap" role="alert">
            <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            @php
                $userFields = [
                    ['name' => 'name', 'label' => 'Nama', 'value' => old('name', $user->name), 'required' => true],
                    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => old('email', $user->email), 'required' => true],
                    ['name' => 'password', 'label' => 'Password Baru (Opsional)', 'type' => 'password'],
                    ['name' => 'password_confirmation', 'label' => 'Konfirmasi Password Baru', 'type' => 'password'],
                    [
                        'name' => 'role',
                        'label' => 'Role',
                        'type' => 'select',
                        'options' => ['admin' => 'Admin', 'user' => 'User'],
                        'value' => old('role', $user->role),
                        'required' => true
                    ],
                ];
            @endphp

            <x-organisms.dynamic-form :fields="$userFields" />
        </form>
    </div>
</div>
@endsection
