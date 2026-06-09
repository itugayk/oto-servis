@php
    $nav = [
        ['label' => 'Ana Sayfa', 'route' => 'home'],
        ['label' => 'Hizmetler', 'route' => 'services.index'],
        ['label' => 'Markalar', 'route' => 'brands.index'],
        ['label' => 'Galeri', 'route' => 'gallery.index'],
        ['label' => 'Blog', 'route' => 'blog.index'],
        ['label' => 'İletişim', 'route' => 'contact'],
    ];
@endphp

<header x-data="{ open: false, scrolled: false }"
        @scroll.window="scrolled = window.pageYOffset > 20"
        class="fixed inset-x-0 top-0 z-40 transition-all duration-300"
        :class="scrolled ? 'bg-ink-900/95 backdrop-blur shadow-lg shadow-black/20' : 'bg-gradient-to-b from-ink-950/80 to-transparent'">
    <div class="container-px">
        <div class="flex h-20 items-center justify-between gap-4">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-white">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-accent-500 text-ink-950">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-9m9 0V5.625m0 13.125V5.625m0 0c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125v8.625" />
                    </svg>
                </span>
                <span class="font-display text-xl font-extrabold leading-none">
                    Oto<span class="text-accent-500">Pro</span>
                    <span class="block text-[10px] font-tech font-semibold uppercase tracking-[0.25em] text-ink-300">Servis & Kaporta</span>
                </span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden items-center gap-1 lg:flex">
                @foreach($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="rounded-md px-3.5 py-2 text-sm font-semibold uppercase tracking-wide transition
                              {{ request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*')
                                 ? 'text-accent-500'
                                 : 'text-ink-100 hover:text-accent-400' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                @php($phone = setting('phone'))
                @if($phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="flex items-center gap-2 text-sm font-semibold text-white">
                        <svg class="h-5 w-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                        {{ $phone }}
                    </a>
                @endif
                <a href="{{ route('appointment') }}" class="btn-accent">Randevu Al</a>
            </div>

            {{-- Mobile toggle --}}
            <button @click="open = !open" class="text-white lg:hidden" aria-label="Menü">
                <svg x-show="!open" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                <svg x-show="open" x-cloak class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak x-transition class="border-t border-white/10 bg-ink-900 lg:hidden">
        <div class="container-px space-y-1 py-4">
            @foreach($nav as $item)
                <a href="{{ route($item['route']) }}"
                   class="block rounded-md px-3 py-2.5 text-base font-semibold text-ink-100 hover:bg-white/5 hover:text-accent-400">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a href="{{ route('appointment') }}" class="btn-accent mt-3 w-full">Randevu Al</a>
        </div>
    </div>
</header>
