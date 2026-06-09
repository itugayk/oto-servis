@props([
    'title',
    'subtitle' => null,
    'eyebrow' => null,
    'image' => null,
    'crumbs' => [],
])

<section class="relative overflow-hidden bg-ink-900 pt-32 pb-16 text-white">
    @if($image)
        <div class="absolute inset-0">
            <img src="{{ $image }}" alt="" class="h-full w-full object-cover opacity-25">
            <div class="absolute inset-0 bg-gradient-to-r from-ink-950 via-ink-900/90 to-ink-900/50"></div>
        </div>
    @else
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,theme(colors.accent.900/40),transparent_60%)]"></div>
    @endif

    <div class="container-px relative">
        @if($eyebrow)
            <p class="eyebrow mb-3"><span class="h-px w-8 bg-accent-500"></span>{{ $eyebrow }}</p>
        @endif
        <h1 class="max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-ink-200">{{ $subtitle }}</p>
        @endif

        <nav class="mt-6 flex items-center gap-2 text-sm text-ink-300">
            <a href="{{ route('home') }}" class="hover:text-accent-400">Ana Sayfa</a>
            @foreach($crumbs as $label => $url)
                <span class="text-ink-500">/</span>
                @if($url)
                    <a href="{{ $url }}" class="hover:text-accent-400">{{ $label }}</a>
                @else
                    <span class="text-accent-400">{{ $label }}</span>
                @endif
            @endforeach
        </nav>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-3 bg-accent-500"></div>
</section>
