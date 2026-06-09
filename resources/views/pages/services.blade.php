@extends('layouts.app')

@section('title', 'Hizmetlerimiz — ' . setting('site_name'))
@section('meta_description', 'Periyodik bakım, mekanik onarım, kaporta-boya, lastik ve elektronik arıza tespiti hizmetlerimizi keşfedin.')

@section('content')
    <x-page-hero
        eyebrow="Hizmetlerimiz"
        title="Tam Donanımlı Oto Servis Hizmetleri"
        subtitle="Aracınızın ihtiyaç duyduğu tüm bakım ve onarım işlemleri, tek çatı altında uzman ekibimizle."
        :image="media_url(setting('hero_image'))"
        :crumbs="['Hizmetler' => null]" />

    <section class="bg-ink-50 py-20 lg:py-28">
        <div class="container-px space-y-8">
            @foreach($services as $i => $service)
                <div class="grid items-center gap-8 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-ink-100 lg:grid-cols-2 {{ $i % 2 === 1 ? 'lg:[&>*:first-child]:order-2' : '' }}">
                    <div class="relative h-64 lg:h-full lg:min-h-[22rem]">
                        <img src="{{ media_url($service->image, media_url(setting('hero_image'))) }}" alt="{{ $service->name }}"
                             class="h-full w-full object-cover">
                        <span class="absolute left-5 top-5 flex h-14 w-14 items-center justify-center rounded-xl bg-ink-900/90 text-accent-500 backdrop-blur">
                            @svg('heroicon-o-' . $service->icon, 'h-7 w-7')
                        </span>
                    </div>
                    <div class="p-8 lg:p-10">
                        @if($service->is_featured)
                            <span class="eyebrow mb-2">Öne çıkan hizmet</span>
                        @endif
                        <h2 class="text-2xl font-extrabold text-ink-900 sm:text-3xl">{{ $service->name }}</h2>
                        <p class="mt-3 text-ink-500">{{ $service->summary }}</p>

                        @if($service->features)
                            <ul class="mt-5 grid gap-2 sm:grid-cols-2">
                                @foreach(array_slice((array) $service->features, 0, 4) as $feature)
                                    <li class="flex items-start gap-2 text-sm text-ink-700">
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                        {{ is_array($feature) ? ($feature['item'] ?? reset($feature)) : $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="mt-7 flex flex-wrap items-center gap-4">
                            <a href="{{ route('services.show', $service->slug) }}" class="btn-dark">Detayları Gör</a>
                            <a href="{{ route('appointment', ['service' => $service->id]) }}" class="btn-accent">Randevu Al</a>
                            @if($service->price_from)
                                <span class="text-sm font-semibold text-ink-600">{{ number_format($service->price_from, 0, ',', '.') }} ₺'den başlayan fiyatlarla</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @include('partials.cta')
@endsection
