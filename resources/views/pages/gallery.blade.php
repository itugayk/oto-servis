@extends('layouts.app')

@section('title', 'Galeri — ' . setting('site_name'))
@section('meta_description', 'Atölyemizden, ekipmanlarımızdan ve tamamladığımız işlerden kareler.')

@section('content')
    <x-page-hero
        eyebrow="Galeri"
        title="Atölyemizden ve İşlerimizden"
        subtitle="Çalışma ortamımıza, ekipmanlarımıza ve tamamladığımız işlere göz atın."
        :image="media_url(setting('hero_image'))"
        :crumbs="['Galeri' => null]" />

    <section class="bg-ink-50 py-20 lg:py-28" x-data="{ filter: 'Tümü' }">
        <div class="container-px">
            {{-- Filters --}}
            <div class="flex flex-wrap justify-center gap-2">
                @foreach(collect(['Tümü'])->merge($categories) as $cat)
                    <button type="button" @click="filter = '{{ $cat }}'"
                            class="rounded-full px-5 py-2 text-sm font-semibold transition"
                            :class="filter === '{{ $cat }}' ? 'bg-accent-500 text-ink-950' : 'bg-white text-ink-600 ring-1 ring-ink-200 hover:ring-accent-500'">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($items as $item)
                    <div x-show="filter === 'Tümü' || filter === '{{ $item->category }}'" x-transition
                         class="group relative overflow-hidden rounded-2xl">
                        <img src="{{ media_url($item->image) }}" alt="{{ $item->title }}"
                             class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-950/85 via-ink-950/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-5">
                            <span class="text-xs font-bold uppercase tracking-wide text-accent-400">{{ $item->category }}</span>
                            <p class="text-lg font-bold text-white">{{ $item->title }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta')
@endsection
