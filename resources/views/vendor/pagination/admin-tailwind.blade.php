@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 px-1">
        {{-- Result summary --}}
        <p class="text-xs text-gray-500 dark:text-gray-400 order-2 sm:order-1">
            Menampilkan
            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $paginator->total() }}</span>
            hasil
        </p>

        {{-- Page controls --}}
        <div class="flex items-center gap-1 order-1 sm:order-2">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Halaman sebelumnya"
                      class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-gray-300 dark:text-gray-600 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg cursor-not-allowed">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    <span>Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya"
                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    <span>Sebelumnya</span>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="inline-flex items-center justify-center w-8 h-8 text-xs font-semibold text-gray-400 dark:text-gray-500">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array of links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                  class="inline-flex items-center justify-center w-8 h-8 text-xs font-extrabold text-white bg-indigo-600 dark:bg-indigo-500 rounded-lg shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" aria-label="Halaman {{ $page }}"
                               class="inline-flex items-center justify-center w-8 h-8 text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya"
                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <span>Berikutnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="Halaman berikutnya"
                      class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-gray-300 dark:text-gray-600 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg cursor-not-allowed">
                    <span>Berikutnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>
    </nav>
@endif
