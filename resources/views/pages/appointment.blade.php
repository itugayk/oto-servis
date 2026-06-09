@extends('layouts.app')

@section('title', 'Servis Randevusu — ' . setting('site_name'))
@section('meta_description', 'Online servis randevusu alın. Hizmet türünü ve aracınızı seçin, size uygun saati saniyeler içinde belirleyin.')

@section('content')
    <x-page-hero
        eyebrow="Online Randevu"
        title="Servis Randevunuzu Oluşturun"
        subtitle="4 basit adımda aracınız için en uygun günü ve saati seçin. Sıra beklemeden servise gelin."
        :image="media_url(setting('hero_image'))"
        :crumbs="['Randevu' => null]" />

    <section class="bg-ink-50 py-16 lg:py-24">
        <div class="container-px">
            <div class="grid gap-10 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    @livewire('appointment-form', ['service' => request('service') ? (int) request('service') : null])
                </div>

                <aside class="space-y-6">
                    <div class="rounded-2xl bg-white p-7 shadow-sm ring-1 ring-ink-100">
                        <h3 class="text-lg font-bold text-ink-900">Nasıl çalışır?</h3>
                        <ol class="mt-5 space-y-5">
                            @foreach([
                                ['Hizmet seçin', 'İhtiyacınız olan servis türünü belirleyin.'],
                                ['Araç bilgisi', 'Marka, model ve plaka bilgilerini girin.'],
                                ['Tarih & saat', 'Uygun günü ve boş saat dilimini seçin.'],
                                ['İletişim', 'Bilgilerinizi bırakın, sizi arayalım.'],
                            ] as $i => $step)
                                <li class="flex gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent-500 font-bold text-ink-950">{{ $i + 1 }}</span>
                                    <div>
                                        <div class="font-semibold text-ink-900">{{ $step[0] }}</div>
                                        <div class="text-sm text-ink-500">{{ $step[1] }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="rounded-2xl bg-ink-900 p-7 text-white">
                        <h3 class="text-lg font-bold">Acil mi?</h3>
                        <p class="mt-2 text-sm text-ink-300">Telefonla da randevu oluşturabilir, sorularınızı sorabilirsiniz.</p>
                        @if(setting('phone'))
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('phone')) }}" class="btn-accent mt-4 w-full">{{ setting('phone') }}</a>
                        @endif
                        @if(setting('working_text'))
                            <p class="mt-4 text-xs text-ink-400">{{ setting('working_text') }}</p>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
