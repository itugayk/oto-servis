@extends('layouts.app')

@section('title', $post->title . ' — ' . setting('site_name'))
@section('meta_description', $post->excerpt)

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post->title,
    'description' => $post->excerpt,
    'image' => media_url($post->cover_image),
    'datePublished' => optional($post->published_at)->toIso8601String(),
    'author' => ['@type' => 'Organization', 'name' => $post->author],
    'publisher' => ['@type' => 'Organization', 'name' => setting('site_name')],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
    <x-page-hero
        :eyebrow="$post->category"
        :title="$post->title"
        :image="media_url($post->cover_image)"
        :crumbs="['Blog' => route('blog.index'), \Illuminate\Support\Str::limit($post->title, 30) => null]" />

    <article class="bg-white py-16 lg:py-24">
        <div class="container-px max-w-3xl">
            <div class="flex items-center gap-4 text-sm font-semibold uppercase tracking-wide text-ink-400">
                <span>{{ optional($post->published_at)->translatedFormat('d F Y') }}</span>
                <span>·</span>
                <span>{{ $post->read_minutes }} dk okuma</span>
                <span>·</span>
                <span>{{ $post->author }}</span>
            </div>

            @if($post->cover_image)
                <img src="{{ media_url($post->cover_image) }}" alt="{{ $post->title }}"
                     class="mt-6 aspect-video w-full rounded-2xl object-cover shadow-sm">
            @endif

            <div class="prose prose-lg mt-8 max-w-none prose-headings:font-display prose-headings:text-ink-900 prose-a:text-accent-600 prose-blockquote:border-accent-500 prose-blockquote:text-ink-700">
                {!! $post->body !!}
            </div>

            <div class="mt-12 flex flex-wrap items-center justify-between gap-4 rounded-2xl bg-ink-50 p-6 ring-1 ring-ink-100">
                <div>
                    <p class="font-bold text-ink-900">Aracınız bakıma mı ihtiyaç duyuyor?</p>
                    <p class="text-sm text-ink-500">Online randevu sistemimizle hemen yerinizi ayırtın.</p>
                </div>
                <a href="{{ route('appointment') }}" class="btn-accent shrink-0">Randevu Al</a>
            </div>
        </div>
    </article>

    @if($related->isNotEmpty())
        <section class="bg-ink-50 py-16 lg:py-20">
            <div class="container-px">
                <x-section-heading eyebrow="Devamı" title="İlgini Çekebilir" />
                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach($related as $post)
                        @include('partials.blog-card', ['post' => $post])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
