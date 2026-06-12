@extends('pages.admin.admin')

@section('title', 'Ubah Penerbit')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-bento-gap">
            <div>
                <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Penerbit</h1>
                <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk <span class="font-medium text-bark-500">{{ $publisher->name }}</span>.</p>
            </div>
            <x-atoms.button variant="tertiary" href="{{ route('admin.publishers.index') }}">
                ← Kembali ke Daftar
            </x-atoms.button>
        </div>

        @if ($errors->any())
            {{-- Alert Error --}}
        @endif

        <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
            <form action="{{ route('admin.publishers.update', $publisher) }}" method="POST">
                @csrf
                @method('PUT')
                <x-organisms.dynamic-form
                    :fields="$publisherFields"
                    :cancelUrl="route('admin.publishers.index')"
                    submitLabel="Perbarui Penerbit"
                />
            </form>
        </div>
    </div>
@endsection
