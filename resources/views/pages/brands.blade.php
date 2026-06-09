@extends('layouts.app')

@section('title', 'Uzman Olduğumuz Markalar — ' . setting('site_name'))
@section('meta_description', 'BMW, Mercedes, Audi, Volkswagen, Ford ve daha birçok markada uzman servis ve diagnostik desteği.')

@section('content')
    <x-page-hero
        eyebrow="Marka Uzmanlığı"
        title="Markanıza Özel Uzman Servis"
        subtitle="Üretici seviyesindeki diagnostik cihazlarımız ve marka bazlı tecrübemizle aracınıza özel çözümler sunuyoruz."
        :image="media_url(setting('hero_image'))"
        :crumbs="['Markalar' => null]" />

    <section class="bg-white py-20 lg:py-28">
        <div class="container-px">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($brands as $brand)
                    <div class="card-hover group flex items-start gap-4 rounded-2xl bg-ink-50 p-6 ring-1 ring-ink-100">
                        <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-ink-900 font-tech text-lg font-bold text-accent-500">
                            @if($brand->logo)
                                <img src="{{ media_url($brand->logo) }}" alt="{{ $brand->name }}" class="h-10 w-10 object-contain">
                            @else
                                {{ mb_strtoupper(mb_substr($brand->name, 0, 2)) }}
                            @endif
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-ink-900">{{ $brand->name }}</h3>
                            @if($brand->note)
                                <p class="mt-1 text-sm text-ink-500">{{ $brand->note }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 rounded-3xl bg-ink-900 p-8 text-center text-white lg:p-14">
                <h2 class="text-2xl font-extrabold sm:text-3xl">Markanız listede yok mu?</h2>
                <p class="mx-auto mt-3 max-w-xl text-ink-300">
                    Tüm marka ve modellerde genel bakım, mekanik onarım ve kaporta-boya hizmeti veriyoruz.
                    Aracınız için bize ulaşın.
                </p>
                <div class="mt-7 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('appointment') }}" class="btn-accent">Randevu Al</a>
                    <a href="{{ route('contact') }}" class="btn-outline">İletişime Geç</a>
                </div>
            </div>
        </div>
    </section>
@endsection
