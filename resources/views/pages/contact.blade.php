@extends('layouts.app')

@section('title', 'İletişim — ' . setting('site_name'))
@section('meta_description', 'Bize ulaşın: adres, telefon, e-posta ve çalışma saatleri. Soru ve randevu talepleriniz için iletişim formu.')

@section('content')
    <x-page-hero
        eyebrow="İletişim"
        title="Bize Ulaşın"
        subtitle="Sorularınız, randevu ve fiyat talepleriniz için bize yazın ya da atölyemize uğrayın."
        :image="media_url(setting('hero_image'))"
        :crumbs="['İletişim' => null]" />

    <section class="bg-white py-16 lg:py-24">
        <div class="container-px grid gap-10 lg:grid-cols-2">
            {{-- Info --}}
            <div>
                <h2 class="text-2xl font-extrabold text-ink-900">İletişim Bilgileri</h2>
                <p class="mt-2 text-ink-500">Aşağıdaki kanallardan bize her zaman ulaşabilirsiniz.</p>

                <div class="mt-8 space-y-5">
                    @foreach([
                        ['M15 10.5a3 3 0 11-6 0 3 3 0 016 0z||M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z', 'Adres', setting('address'), null],
                        ['M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z', 'Telefon', setting('phone'), 'tel:'.preg_replace('/[^0-9+]/', '', (string) setting('phone'))],
                        ['M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75', 'E-posta', setting('email'), 'mailto:'.setting('email')],
                        ['M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'Çalışma Saatleri', setting('working_text'), null],
                    ] as $row)
                        @if($row[2])
                            <div class="flex gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-accent-500/10 text-accent-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        @foreach(explode('||', $row[0]) as $d)<path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}" />@endforeach
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-sm font-bold uppercase tracking-wide text-ink-400">{{ $row[1] }}</div>
                                    @if($row[3])
                                        <a href="{{ $row[3] }}" class="text-lg font-semibold text-ink-900 hover:text-accent-600">{{ $row[2] }}</a>
                                    @else
                                        <div class="text-lg font-semibold text-ink-900">{{ $row[2] }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if(setting('map_embed'))
                    <div class="mt-8 overflow-hidden rounded-2xl ring-1 ring-ink-200">
                        <iframe src="{{ setting('map_embed') }}" width="100%" height="280" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Harita"></iframe>
                    </div>
                @endif
            </div>

            {{-- Form --}}
            <div class="rounded-2xl bg-ink-50 p-8 ring-1 ring-ink-100">
                <h2 class="text-2xl font-extrabold text-ink-900">Mesaj Gönderin</h2>
                <p class="mt-2 text-ink-500">Formu doldurun, en kısa sürede size dönelim.</p>
                <div class="mt-6">
                    @livewire('contact-form')
                </div>
            </div>
        </div>
    </section>
@endsection
