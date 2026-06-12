@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between font-body text-sm">

        {{-- Tampilan Mobile (Previous & Next Saja) --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-dusty bg-cream-50 border border-cream-200 rounded-full cursor-not-allowed">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-bark-600 bg-white border border-cream-200 rounded-full hover:bg-cream-100 transition-colors">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-bark-600 bg-white border border-cream-200 rounded-full hover:bg-cream-100 transition-colors">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-dusty bg-cream-50 border border-cream-200 rounded-full cursor-not-allowed">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Tampilan Desktop --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">

            {{-- Informasi Data (Showing 1 to 10 of 100 results) --}}
            <div>
                <p class="text-sm text-dusty leading-5">
                    Menampilkan
                    <span class="font-medium text-bark-600">{{ $paginator->firstItem() }}</span>
                    hingga
                    <span class="font-medium text-bark-600">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-medium text-bark-600">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            {{-- Angka Navigasi Pagination --}}
            <div>
                {{-- Di sini rounded-btn diubah menjadi rounded-full --}}
                <span class="relative z-0 inline-flex shadow-sm rounded-full overflow-hidden border border-cream-200">

                    {{-- Tombol Previous --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-cream-300 bg-cream-50 cursor-not-allowed" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-bark-500 bg-white hover:bg-cream-100 transition-colors" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                    @endif

                    {{-- Loop Angka Halaman --}}
                    @foreach ($elements as $element)
                        {{-- Pemisah Tiga Titik "..." --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-dusty bg-white border-l border-cream-200 cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Link Angka Biasa --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    {{-- Halaman Aktif: Diubah menjadi bg-terra-400 dan border-terra-400 --}}
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-white bg-terra-400 border-l border-terra-400 cursor-default">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-bark-600 bg-white border-l border-cream-200 hover:bg-cream-100 transition-colors" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-bark-500 bg-white border-l border-cream-200 hover:bg-cream-100 transition-colors" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-cream-300 bg-cream-50 border-l border-cream-200 cursor-not-allowed" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
