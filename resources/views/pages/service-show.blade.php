@extends('layouts.app')

@section('title', $service->name . ' — ' . setting('site_name'))
@section('meta_description', $service->summary)

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => $service->name,
    'description' => $service->summary,
    'provider' => ['@type' => 'AutoRepair', 'name' => setting('site_name')],
    'areaServed' => 'TR',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
    <x-page-hero
        eyebrow="Hizmet Detayı"
        :title="$service->name"
        :subtitle="$service->summary"
        :image="media_url($service->image, media_url(setting('hero_image')))"
        :crumbs="['Hizmetler' => route('services.index'), $service->name => null]" />

    <section class="bg-white py-16 lg:py-24">
        <div class="container-px grid gap-12 lg:grid-cols-3">
            {{-- Main --}}
            <div class="lg:col-span-2">
                @if($service->image)
                    <img src="{{ media_url($service->image) }}" alt="{{ $service->name }}"
                         class="aspect-video w-full rounded-2xl object-cover shadow-sm">
                @endif

                <div class="prose prose-lg mt-8 max-w-none prose-headings:font-display prose-headings:text-ink-900 prose-a:text-accent-600">
                    {!! $service->description ?: '<p>'.e($service->summary).'</p>' !!}
                </div>

                @if($service->features)
                    <div class="mt-10">
                        <h3 class="text-xl font-bold text-ink-900">Bu hizmete neler dahil?</h3>
                        <ul class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach((array) $service->features as $feature)
                                <li class="flex items-start gap-3 rounded-xl bg-ink-50 p-4 ring-1 ring-ink-100">
                                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                    <span class="text-sm font-medium text-ink-700">{{ is_array($feature) ? ($feature['item'] ?? reset($feature)) : $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($service->faqs)
                    <div class="mt-12" x-data="{ open: 0 }">
                        <h3 class="text-xl font-bold text-ink-900">Sıkça Sorulan Sorular</h3>
                        <div class="mt-5 space-y-3">
                            @foreach((array) $service->faqs as $idx => $faq)
                                <div class="overflow-hidden rounded-xl ring-1 ring-ink-200">
                                    <button type="button" @click="open = open === {{ $idx }} ? null : {{ $idx }}"
                                            class="flex w-full items-center justify-between gap-4 bg-ink-50 px-5 py-4 text-left font-semibold text-ink-900">
                                        {{ $faq['q'] ?? '' }}
                                        <svg class="h-5 w-5 shrink-0 text-accent-500 transition" :class="open === {{ $idx }} ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                                    </button>
                                    <div x-show="open === {{ $idx }}" x-collapse x-cloak class="bg-white px-5 py-4 text-ink-600">
                                        {{ $faq['a'] ?? '' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <div class="sticky top-24 space-y-6">
                    <div class="rounded-2xl bg-ink-900 p-7 text-white">
                        <h3 class="text-lg font-bold">Bu hizmet için randevu alın</h3>
                        <div class="mt-5 space-y-3 text-sm">
                            @if($service->price_from)
                                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                    <span class="text-ink-300">Başlangıç fiyatı</span>
                                    <span class="font-bold text-accent-500">{{ number_format($service->price_from, 0, ',', '.') }} ₺</span>
                                </div>
                            @endif
                            @if($service->duration_min)
                                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                    <span class="text-ink-300">Tahmini süre</span>
                                    <span class="font-semibold">{{ $service->duration_min }} dakika</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="text-ink-300">Garanti</span>
                                <span class="font-semibold">{{ setting('stat_warranty', 24) }} ay</span>
                            </div>
                        </div>
                        <a href="{{ route('appointment', ['service' => $service->id]) }}" class="btn-accent mt-6 w-full">Randevu Al</a>
                        @if(setting('phone'))
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('phone')) }}" class="mt-3 block text-center text-sm font-semibold text-ink-200 hover:text-accent-400">
                                veya arayın: {{ setting('phone') }}
                            </a>
                        @endif
                    </div>

                    @if($others->isNotEmpty())
                        <div class="rounded-2xl bg-ink-50 p-7 ring-1 ring-ink-100">
                            <h3 class="text-lg font-bold text-ink-900">Diğer Hizmetler</h3>
                            <ul class="mt-4 space-y-2">
                                @foreach($others as $other)
                                    <li>
                                        <a href="{{ route('services.show', $other->slug) }}"
                                           class="flex items-center gap-3 rounded-lg p-2 text-sm font-medium text-ink-700 transition hover:bg-white hover:text-accent-600">
                                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-accent-500 ring-1 ring-ink-100">
                                                @svg('heroicon-o-' . $other->icon, 'h-5 w-5')
                                            </span>
                                            {{ $other->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    @include('partials.cta')
@endsection
