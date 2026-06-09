@extends('layouts.app')

@section('title', setting('site_name') . ' — ' . setting('tagline'))

@push('head')
    @include('partials.jsonld')
@endpush

@section('content')
    {{-- ============ HERO ============ --}}
    <section class="relative min-h-[92vh] overflow-hidden bg-ink-950">
        <div class="absolute inset-0">
            <img src="{{ media_url(setting('hero_image')) }}" alt="OtoPro atölye" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-ink-950 via-ink-950/90 to-ink-950/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-transparent to-ink-950/40"></div>
        </div>

        <div class="container-px relative flex min-h-[92vh] flex-col justify-center pt-28 pb-16">
            <div class="max-w-2xl">
                <p class="eyebrow mb-5"><span class="h-px w-10 bg-accent-500"></span>{{ setting('tagline', 'Aracınız emin ellerde') }}</p>
                <h1 class="text-4xl font-extrabold leading-[1.05] text-white sm:text-5xl lg:text-6xl">
                    Aracınız İçin
                    <span class="text-accent-500">Profesyonel</span>
                    Servis & Kaporta
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink-200">
                    Periyodik bakımdan kaza sonrası kaporta-boyaya, mekanik onarımdan elektronik arıza tespitine kadar
                    her işlemde orijinal parça, uzman ekip ve {{ setting('stat_warranty', 24) }} ay garanti.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('appointment') }}" class="btn-accent text-base">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        Servis Randevusu Al
                    </a>
                    <a href="{{ route('services.index') }}" class="btn-outline text-base">Hizmetlerimiz</a>
                </div>

                {{-- Trust badges --}}
                <div class="mt-12 flex flex-wrap gap-x-8 gap-y-4">
                    @foreach([
                        ['Orijinal Parça', 'm4.5 12.75 6 6 9-13.5'],
                        [setting('stat_warranty', 24).' Ay Garanti', 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                        ['Uzman Ekip', 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
                    ] as $badge)
                        <div class="flex items-center gap-2.5 text-sm font-semibold text-white">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent-500/15 text-accent-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $badge[1] }}" /></svg>
                            </span>
                            {{ $badge[0] }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ STATS ============ --}}
    <section class="relative z-10 -mt-px bg-accent-500">
        <div class="container-px">
            <div class="grid grid-cols-2 divide-x divide-ink-950/10 lg:grid-cols-4">
                @foreach([
                    ['val' => (int) setting('stat_years', 18), 'suffix' => '+', 'label' => 'Yıllık Tecrübe'],
                    ['val' => (int) setting('stat_vehicles', 24000), 'suffix' => '+', 'label' => 'Bakımı Yapılan Araç'],
                    ['val' => (int) setting('stat_experts', 12), 'suffix' => '', 'label' => 'Uzman Teknisyen'],
                    ['val' => (int) setting('stat_warranty', 24), 'suffix' => ' Ay', 'label' => 'İşçilik Garantisi'],
                ] as $stat)
                    <div class="px-4 py-8 text-center text-ink-950"
                         x-data="{ n: 0, target: {{ $stat['val'] }} }"
                         x-init="let s = Date.now(); let t = setInterval(() => { let p = Math.min((Date.now()-s)/1400, 1); n = Math.floor(p*target); if(p>=1){n=target; clearInterval(t);} }, 30)">
                        <div class="font-tech text-4xl font-bold sm:text-5xl">
                            <span x-text="n.toLocaleString('tr-TR')">{{ $stat['val'] }}</span>{{ $stat['suffix'] }}
                        </div>
                        <div class="mt-1 text-sm font-semibold uppercase tracking-wide text-ink-800">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ SERVICES ============ --}}
    <section class="bg-ink-50 py-20 lg:py-28">
        <div class="container-px">
            <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                <x-section-heading
                    eyebrow="Hizmetlerimiz"
                    title="Aracınızın İhtiyacı Olan Her Şey"
                    subtitle="Tek bir adreste, tam donanımlı atölyemizde tüm bakım ve onarım hizmetleri." />
                <a href="{{ route('services.index') }}" class="btn-dark shrink-0">Tüm Hizmetler</a>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}"
                       class="card-hover group relative flex flex-col overflow-hidden rounded-2xl bg-white p-7 shadow-sm ring-1 ring-ink-100">
                        <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-ink-900 text-accent-500 transition group-hover:bg-accent-500 group-hover:text-ink-950">
                            @svg('heroicon-o-' . $service->icon, 'h-7 w-7')
                        </span>
                        <h3 class="mt-5 text-xl font-bold text-ink-900">{{ $service->name }}</h3>
                        <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-500">{{ $service->summary }}</p>
                        <div class="mt-5 flex items-center justify-between border-t border-ink-100 pt-4">
                            @if($service->price_from)
                                <span class="text-sm font-semibold text-ink-700">{{ number_format($service->price_from, 0, ',', '.') }} ₺'den başlayan</span>
                            @else
                                <span class="text-sm font-semibold text-ink-700">Detaylı bilgi</span>
                            @endif
                            <span class="flex items-center gap-1 text-sm font-bold text-accent-600 transition group-hover:gap-2">
                                İncele
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ WHY US ============ --}}
    <section class="relative overflow-hidden bg-ink-900 py-20 text-white lg:py-28">
        <div class="container-px">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="relative">
                    <img src="{{ media_url(setting('about_image')) }}" alt="OtoPro ekip"
                         class="aspect-[4/3] w-full rounded-2xl object-cover shadow-2xl">
                    <div class="absolute -bottom-6 -right-2 hidden rounded-xl bg-accent-500 px-6 py-5 text-ink-950 shadow-xl sm:block lg:-right-6">
                        <div class="font-tech text-4xl font-bold">{{ setting('stat_years', 18) }}+</div>
                        <div class="text-sm font-semibold">yıllık tecrübe</div>
                    </div>
                </div>

                <div>
                    <x-section-heading light eyebrow="Neden OtoPro?"
                        title="Güvenle Teslim Edin, Zamanında Teslim Alın" />
                    <p class="mt-4 text-ink-300">
                        İşini severek yapan uzman ekibimiz, son teknoloji cihazlarımız ve şeffaf fiyat politikamızla
                        aracınızı ilk günkü performansına kavuşturuyoruz.
                    </p>

                    <div class="mt-8 grid gap-5 sm:grid-cols-2">
                        @foreach([
                            ['Orijinal & OEM Parça', 'Tüm işlemlerde garantili orijinal veya OEM eşdeğeri parça.'],
                            ['Şeffaf Fiyatlandırma', 'Onayınız olmadan işleme başlamıyor, sürpriz fatura çıkarmıyoruz.'],
                            ['Dijital Araç Raporu', 'Her bakımda 40 noktada kontrol ve dijital rapor.'],
                            ['Sigorta Anlaşmaları', 'Hasar sürecinizi baştan sona biz yönetiyoruz.'],
                        ] as $item)
                            <div class="flex gap-3">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-accent-500/15 text-accent-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                </span>
                                <div>
                                    <h4 class="font-bold text-white">{{ $item[0] }}</h4>
                                    <p class="mt-1 text-sm text-ink-400">{{ $item[1] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('appointment') }}" class="btn-accent mt-9">Hemen Randevu Al</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ BRANDS ============ --}}
    <section class="border-b border-ink-100 bg-white py-16">
        <div class="container-px">
            <p class="text-center text-sm font-bold uppercase tracking-[0.2em] text-ink-400">
                Uzman olduğumuz markalar
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-x-10 gap-y-5">
                @foreach($brands as $brand)
                    <a href="{{ route('brands.index') }}" class="font-tech text-2xl font-bold text-ink-300 transition hover:text-ink-900">
                        {{ $brand->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ GALLERY ============ --}}
    <section class="bg-ink-50 py-20 lg:py-28">
        <div class="container-px">
            <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                <x-section-heading eyebrow="Galeri" title="Atölyemizden ve İşlerimizden" />
                <a href="{{ route('gallery.index') }}" class="btn-dark shrink-0">Tüm Galeri</a>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-4 md:grid-cols-3">
                @foreach($gallery as $i => $item)
                    <div class="group relative overflow-hidden rounded-xl {{ $i === 0 ? 'col-span-2 row-span-2 md:col-span-1' : '' }}">
                        <img src="{{ media_url($item->image) }}" alt="{{ $item->title }}"
                             class="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-950/80 via-transparent opacity-0 transition group-hover:opacity-100"></div>
                        <div class="absolute bottom-0 left-0 p-4 opacity-0 transition group-hover:opacity-100">
                            <span class="text-xs font-bold uppercase tracking-wide text-accent-400">{{ $item->category }}</span>
                            <p class="font-semibold text-white">{{ $item->title }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONIALS ============ --}}
    @if($testimonials->isNotEmpty())
    <section class="bg-white py-20 lg:py-28">
        <div class="container-px">
            <x-section-heading align="center" eyebrow="Müşteri Yorumları"
                title="Binlerce Sürücünün Güvendiği Adres" />
            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($testimonials as $t)
                    <figure class="flex flex-col rounded-2xl bg-ink-50 p-7 ring-1 ring-ink-100">
                        <div class="flex gap-0.5 text-accent-500">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="h-5 w-5 {{ $i < $t->rating ? '' : 'text-ink-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                            @endfor
                        </div>
                        <blockquote class="mt-4 flex-1 text-ink-700">"{{ $t->body }}"</blockquote>
                        <figcaption class="mt-5 flex items-center gap-3 border-t border-ink-100 pt-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-ink-900 font-bold text-accent-500">
                                {{ mb_substr($t->name, 0, 1) }}
                            </span>
                            <div>
                                <div class="font-bold text-ink-900">{{ $t->name }}</div>
                                @if($t->vehicle)<div class="text-sm text-ink-500">{{ $t->vehicle }}</div>@endif
                            </div>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ BLOG ============ --}}
    @if($posts->isNotEmpty())
    <section class="bg-ink-50 py-20 lg:py-28">
        <div class="container-px">
            <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                <x-section-heading eyebrow="Blog" title="Bakım İpuçları & Rehberler" />
                <a href="{{ route('blog.index') }}" class="btn-dark shrink-0">Tüm Yazılar</a>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach($posts as $post)
                    @include('partials.blog-card', ['post' => $post])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ CTA ============ --}}
    @include('partials.cta')
@endsection
