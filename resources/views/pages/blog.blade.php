@extends('layouts.app')

@section('title', 'Blog — Bakım İpuçları — ' . setting('site_name'))
@section('meta_description', 'Araç bakımı, lastik, arıza tespiti ve sürüş hakkında uzman ipuçları ve rehberler.')

@section('content')
    <x-page-hero
        eyebrow="Blog"
        title="Bakım İpuçları & Rehberler"
        subtitle="Aracınızı daha uzun ömürlü ve güvenli kullanmanız için uzman ekibimizden öneriler."
        :image="media_url(setting('hero_image'))"
        :crumbs="['Blog' => null]" />

    <section class="bg-ink-50 py-20 lg:py-28">
        <div class="container-px">
            @if($posts->isEmpty())
                <p class="text-center text-ink-500">Henüz yazı eklenmedi.</p>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        @include('partials.blog-card', ['post' => $post])
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
