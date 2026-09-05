@props(['label', 'model'])

<label {{ $attributes->merge(['class' => 'block']) }}>
    <span class="text-sm font-medium text-zinc-300">{{ $label }}</span>
    <textarea rows="4" wire:model="{{ $model }}" class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 text-zinc-100 outline-none focus:ring-2 focus:ring-teal-400"></textarea>
    @error($model) <span class="mt-1 block text-sm text-red-300">{{ $message }}</span> @enderror
</label>
