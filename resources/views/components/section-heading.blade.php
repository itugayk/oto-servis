@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
    'align' => 'left',
    'light' => false,
])

<div class="{{ $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}">
    @if($eyebrow)
        <p class="eyebrow mb-3 {{ $align === 'center' ? 'justify-center' : '' }}">
            <span class="h-px w-8 bg-accent-500"></span>{{ $eyebrow }}
        </p>
    @endif
    <h2 class="text-3xl font-extrabold leading-tight sm:text-4xl {{ $light ? 'text-white' : 'text-ink-900' }}">
        {{ $title }}
    </h2>
    @if($subtitle)
        <p class="mt-4 text-lg {{ $light ? 'text-ink-300' : 'text-ink-500' }}">{{ $subtitle }}</p>
    @endif
</div>
