@php
    $services = \App\Models\Service::active()->orderBy('sort_order')->take(5)->get(['name', 'slug']);
@endphp
<footer class="bg-ink-950 text-ink-300">
    <div class="container-px py-16">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            {{-- Brand --}}
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-white">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent-500 text-ink-950">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-9m9 0V5.625m0 13.125V5.625m0 0c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125v8.625" /></svg>
                    </span>
                    <span class="font-display text-lg font-extrabold">Oto<span class="text-accent-500">Pro</span></span>
                </a>
                <p class="mt-4 text-sm leading-relaxed">{{ setting('tagline', 'Aracınız emin ellerde.') }} Orijinal parça, uzman ekip ve {{ setting('stat_warranty', 24) }} ay garanti ile yanınızdayız.</p>
                <div class="mt-5 flex gap-3">
                    @foreach(['instagram' => 'Instagram', 'facebook' => 'Facebook', 'youtube' => 'YouTube'] as $key => $label)
                        @if(setting($key))
                            <a href="{{ setting($key) }}" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-md bg-white/5 text-ink-200 transition hover:bg-accent-500 hover:text-ink-950" aria-label="{{ $label }}">
                                <span class="text-xs font-bold">{{ substr($label, 0, 2) }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Services --}}
            <div>
                <h4 class="font-tech text-sm font-bold uppercase tracking-[0.2em] text-white">Hizmetler</h4>
                <ul class="mt-4 space-y-2.5 text-sm">
                    @foreach($services as $s)
                        <li><a href="{{ route('services.show', $s->slug) }}" class="transition hover:text-accent-400">{{ $s->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="font-tech text-sm font-bold uppercase tracking-[0.2em] text-white">Kurumsal</h4>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('services.index') }}" class="transition hover:text-accent-400">Tüm Hizmetler</a></li>
                    <li><a href="{{ route('brands.index') }}" class="transition hover:text-accent-400">Uzman Olduğumuz Markalar</a></li>
                    <li><a href="{{ route('gallery.index') }}" class="transition hover:text-accent-400">Atölye Galerisi</a></li>
                    <li><a href="{{ route('blog.index') }}" class="transition hover:text-accent-400">Blog & İpuçları</a></li>
                    <li><a href="{{ route('appointment') }}" class="transition hover:text-accent-400">Servis Randevusu</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-tech text-sm font-bold uppercase tracking-[0.2em] text-white">İletişim</h4>
                <ul class="mt-4 space-y-3 text-sm">
                    @if(setting('address'))
                        <li class="flex gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span>{{ setting('address') }}</span>
                        </li>
                    @endif
                    @if(setting('phone'))
                        <li class="flex gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('phone')) }}" class="transition hover:text-accent-400">{{ setting('phone') }}</a>
                        </li>
                    @endif
                    @if(setting('email'))
                        <li class="flex gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            <a href="mailto:{{ setting('email') }}" class="transition hover:text-accent-400">{{ setting('email') }}</a>
                        </li>
                    @endif
                    @if(setting('working_text'))
                        <li class="flex gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ setting('working_text') }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-px flex flex-col items-center justify-between gap-3 py-5 text-xs text-ink-400 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ setting('site_name', 'OtoPro Servis & Kaporta') }}. Tüm hakları saklıdır.</p>
            <p>Demo · <span class="text-accent-500">dijifa.com</span></p>
        </div>
    </div>
</footer>
