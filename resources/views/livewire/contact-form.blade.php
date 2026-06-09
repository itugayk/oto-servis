@php
    $inputClass = 'w-full rounded-lg border-ink-200 bg-white px-4 py-3 text-ink-900 shadow-sm focus:border-accent-500 focus:ring-accent-500';
@endphp

<div>
    @if($sent)
        <div class="rounded-xl bg-green-50 p-6 text-center ring-1 ring-green-200">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <h3 class="mt-4 text-lg font-bold text-ink-900">Mesajınız alındı!</h3>
            <p class="mt-1 text-sm text-ink-600">En kısa sürede size geri dönüş yapacağız.</p>
            <button wire:click="$set('sent', false)" class="mt-5 text-sm font-bold text-accent-600">Yeni mesaj gönder</button>
        </div>
    @else
        <form wire:submit="submit" class="grid gap-4 sm:grid-cols-2">
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
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-ink-700">E-posta</label>
                <input type="email" wire:model="email" class="{{ $inputClass }}">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-ink-700">Konu</label>
                <input type="text" wire:model="subject" class="{{ $inputClass }}">
                @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-sm font-semibold text-ink-700">Mesajınız *</label>
                <textarea wire:model="message" rows="5" class="{{ $inputClass }}"></textarea>
                @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <button type="submit" wire:loading.attr="disabled" class="btn-accent w-full">
                    <span wire:loading.remove wire:target="submit">Gönder</span>
                    <span wire:loading wire:target="submit">Gönderiliyor...</span>
                </button>
            </div>
        </form>
    @endif
</div>
