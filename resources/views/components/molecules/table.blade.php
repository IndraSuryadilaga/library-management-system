@props([
    'headers' => [],
    'emptyMessage' => 'Tidak ada data tersedia.'
])

<div {{ $attributes->merge(['class' => 'bg-parchment border border-cream-200 rounded-card-lg overflow-hidden paper-grain']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-ink">
            <thead class="h-14 text-xs text-bark-600 uppercase bg-cream-200/80">
            <tr>
                @foreach($headers as $header)
                    <th scope="col" class="px-6 py-3 font-body tracking-wider {{ $header === 'Aksi' ? 'text-center' : '' }}">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
