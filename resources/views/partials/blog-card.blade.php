<article class="card-hover group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-ink-100">
    <a href="{{ route('blog.show', $post->slug) }}" class="relative block aspect-[16/10] overflow-hidden">
        <img src="{{ media_url($post->cover_image) }}" alt="{{ $post->title }}"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        <span class="absolute left-4 top-4 rounded-full bg-accent-500 px-3 py-1 text-xs font-bold uppercase tracking-wide text-ink-950">
            {{ $post->category }}
        </span>
    </a>
    <div class="flex flex-1 flex-col p-6">
        <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-wide text-ink-400">
            <span>{{ optional($post->published_at)->translatedFormat('d M Y') }}</span>
            <span>·</span>
            <span>{{ $post->read_minutes }} dk okuma</span>
        </div>
        <h3 class="mt-3 text-lg font-bold leading-snug text-ink-900 transition group-hover:text-accent-600">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h3>
        <p class="mt-2 flex-1 text-sm text-ink-500">{{ \Illuminate\Support\Str::limit($post->excerpt, 110) }}</p>
        <a href="{{ route('blog.show', $post->slug) }}" class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-accent-600">
            Devamını oku
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
        </a>
    </div>
</article>
