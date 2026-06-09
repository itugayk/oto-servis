<section class="relative overflow-hidden bg-accent-500">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, #000 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="container-px relative py-16 lg:py-20">
        <div class="flex flex-col items-center justify-between gap-8 text-center lg:flex-row lg:text-left">
            <div>
                <h2 class="text-3xl font-extrabold text-ink-950 sm:text-4xl">Aracınız için en uygun zamanı seçin</h2>
                <p class="mt-3 max-w-xl text-lg text-ink-900/80">
                    Online randevu sistemimizle saniyeler içinde uygun saati seçin, sıra beklemeden servise gelin.
                </p>
            </div>
            <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                <a href="{{ route('appointment') }}" class="btn bg-ink-950 text-white hover:bg-ink-900">Randevu Al</a>
                @if(setting('phone'))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('phone')) }}" class="btn border-2 border-ink-950/30 text-ink-950 hover:bg-ink-950/5">
                        {{ setting('phone') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
