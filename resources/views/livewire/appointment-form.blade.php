@php
    $inputClass = 'w-full rounded-lg border-ink-200 bg-white px-4 py-3 text-ink-900 shadow-sm focus:border-accent-500 focus:ring-accent-500';
    $steps = ['Hizmet', 'Araç', 'Tarih & Saat', 'İletişim'];
@endphp

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-ink-100 sm:p-8">
    @if($done)
        {{-- ===== SUCCESS ===== --}}
        <div class="py-8 text-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600">
                <svg class="h-11 w-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <h3 class="mt-6 text-2xl font-extrabold text-ink-900">Randevu talebiniz alındı!</h3>
            <p class="mt-2 text-ink-500">En kısa sürede sizi arayarak randevunuzu netleştireceğiz.</p>
            <div class="mx-auto mt-6 inline-flex flex-col items-center rounded-xl bg-ink-50 px-8 py-5 ring-1 ring-ink-100">
                <span class="text-xs font-bold uppercase tracking-wide text-ink-400">Referans No</span>
                <span class="font-tech text-2xl font-bold text-accent-600">{{ $reference }}</span>
            </div>
            <div class="mt-8">
                <button wire:click="resetForm" class="btn-dark">Yeni Randevu Oluştur</button>
            </div>
        </div>
    @else
        {{-- ===== STEPPER ===== --}}
        <div class="mb-8 flex items-center">
            @foreach($steps as $i => $label)
                @php($n = $i + 1)
                <div class="flex items-center {{ $n < count($steps) ? 'flex-1' : '' }}">
                    <button type="button" wire:click="goTo({{ $n }})" @class([
                        'flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-bold transition',
                        'bg-accent-500 text-ink-950' => $step >= $n,
                        'bg-ink-100 text-ink-400' => $step < $n,
                    ])>
                        @if($step > $n)
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        @else
                            {{ $n }}
                        @endif
                    </button>
                    @if($n < count($steps))
                        <div class="mx-2 h-0.5 flex-1 {{ $step > $n ? 'bg-accent-500' : 'bg-ink-100' }}"></div>
                    @endif
                </div>
            @endforeach
        </div>
        <p class="mb-6 text-sm font-semibold uppercase tracking-wide text-ink-400">
            Adım {{ $step }} / {{ count($steps) }} — {{ $steps[$step - 1] }}
        </p>

        {{-- ===== STEP 1: SERVICE ===== --}}
        @if($step === 1)
            <h3 class="text-xl font-bold text-ink-900">Hangi hizmete ihtiyacınız var?</h3>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                @foreach($this->services as $service)
                    <button type="button" wire:click="selectService({{ $service->id }})" @class([
                        'flex items-start gap-3 rounded-xl border-2 p-4 text-left transition',
                        'border-accent-500 bg-accent-50' => $service_id === $service->id,
                        'border-ink-100 hover:border-accent-300' => $service_id !== $service->id,
                    ])>
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-ink-900 text-accent-500">
                            @svg('heroicon-o-' . $service->icon, 'h-6 w-6')
                        </span>
                        <span>
                            <span class="block font-bold text-ink-900">{{ $service->name }}</span>
                            <span class="mt-0.5 block text-xs text-ink-500">{{ \Illuminate\Support\Str::limit($service->summary, 60) }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
            @error('service_id') <p class="mt-3 text-sm text-red-600">{{ $message }}</p> @enderror
        @endif

        {{-- ===== STEP 2: VEHICLE ===== --}}
        @if($step === 2)
            <h3 class="text-xl font-bold text-ink-900">Araç bilgileriniz</h3>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">Marka *</label>
                    <input type="text" wire:model="vehicle_make" placeholder="Örn. BMW" class="{{ $inputClass }}">
                    @error('vehicle_make') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">Model *</label>
                    <input type="text" wire:model="vehicle_model" placeholder="Örn. 320i" class="{{ $inputClass }}">
                    @error('vehicle_model') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">Model Yılı</label>
                    <input type="number" wire:model="vehicle_year" placeholder="2020" min="1950" max="{{ date('Y') + 1 }}" class="{{ $inputClass }}">
                    @error('vehicle_year') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">Plaka</label>
                    <input type="text" wire:model="plate" placeholder="34 ABC 123" class="{{ $inputClass }} uppercase">
                    @error('plate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="mt-7 flex justify-between">
                <button wire:click="goTo(1)" class="btn-dark bg-ink-100 !text-ink-700 hover:bg-ink-200">Geri</button>
                <button wire:click="nextFromVehicle" class="btn-accent">Devam Et</button>
            </div>
        @endif

        {{-- ===== STEP 3: DATE & SLOT ===== --}}
        @if($step === 3)
            <h3 class="text-xl font-bold text-ink-900">Tarih ve saat seçin</h3>
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-semibold text-ink-700">Tarih</label>
                <input type="date" wire:model.live="preferred_date" min="{{ $this->minDate }}" max="{{ $this->maxDate }}" class="{{ $inputClass }} max-w-xs">
                @error('preferred_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6" wire:loading.class="opacity-40" wire:target="preferred_date">
                <label class="mb-2 block text-sm font-semibold text-ink-700">Uygun saatler</label>
                @if($this->slots->isEmpty())
                    <div class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-800 ring-1 ring-amber-200">
                        Seçtiğiniz gün servisimiz kapalı. Lütfen başka bir gün seçin.
                    </div>
                @else
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-5">
                        @foreach($this->slots as $slot)
                            <button type="button"
                                    @if(!$slot['available']) disabled @else wire:click="selectSlot('{{ $slot['time'] }}')" @endif
                                    @class([
                                        'rounded-lg border px-2 py-2.5 text-sm font-semibold transition',
                                        'border-accent-500 bg-accent-500 text-ink-950' => $preferred_time === $slot['time'],
                                        'border-ink-200 text-ink-700 hover:border-accent-400' => $preferred_time !== $slot['time'] && $slot['available'],
                                        'cursor-not-allowed border-ink-100 bg-ink-50 text-ink-300 line-through' => !$slot['available'],
                                    ])>
                                {{ $slot['time'] }}
                            </button>
                        @endforeach
                    </div>
                    <p class="mt-3 text-xs text-ink-400">Üzeri çizili saatler doludur.</p>
                @endif
                @error('preferred_time') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-7 flex justify-between">
                <button wire:click="goTo(2)" class="btn-dark bg-ink-100 !text-ink-700 hover:bg-ink-200">Geri</button>
                <button wire:click="nextFromDate" class="btn-accent">Devam Et</button>
            </div>
        @endif

        {{-- ===== STEP 4: CONTACT ===== --}}
        @if($step === 4)
            <h3 class="text-xl font-bold text-ink-900">İletişim bilgileriniz</h3>

            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">Ad Soyad *</label>
                    <input type="text" wire:model="name" class="{{ $inputClass }}">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">Telefon *</label>
                    <input type="tel" wire:model="phone" placeholder="0532 000 00 00" class="{{ $inputClass }}">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">E-posta</label>
                    <input type="email" wire:model="email" class="{{ $inputClass }}">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-semibold text-ink-700">Not (opsiyonel)</label>
                    <textarea wire:model="notes" rows="3" placeholder="Aracınızla ilgili belirtmek istedikleriniz..." class="{{ $inputClass }}"></textarea>
                    @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Summary --}}
            <div class="mt-6 rounded-xl bg-ink-50 p-4 text-sm ring-1 ring-ink-100">
                <p class="font-bold text-ink-900">Randevu Özeti</p>
                <dl class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-ink-600">
                    <dt class="text-ink-400">Hizmet</dt><dd class="text-right font-medium">{{ optional($this->services->firstWhere('id', $service_id))->name ?? '—' }}</dd>
                    <dt class="text-ink-400">Araç</dt><dd class="text-right font-medium">{{ trim($vehicle_make.' '.$vehicle_model) ?: '—' }}</dd>
                    <dt class="text-ink-400">Tarih</dt><dd class="text-right font-medium">{{ $preferred_date ? \Illuminate\Support\Carbon::parse($preferred_date)->translatedFormat('d F Y') : '—' }} · {{ $preferred_time }}</dd>
                </dl>
            </div>

            <div class="mt-7 flex justify-between">
                <button wire:click="goTo(3)" class="btn-dark bg-ink-100 !text-ink-700 hover:bg-ink-200">Geri</button>
                <button wire:click="submit" wire:loading.attr="disabled" class="btn-accent">
                    <span wire:loading.remove wire:target="submit">Randevuyu Onayla</span>
                    <span wire:loading wire:target="submit">Gönderiliyor...</span>
                </button>
            </div>
        @endif
    @endif
</div>
