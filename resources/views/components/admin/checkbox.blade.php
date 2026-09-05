@props(['label', 'model'])

<label {{ $attributes->merge(['class' => 'flex items-end gap-3 pb-3']) }}>
    <input type="checkbox" wire:model="{{ $model }}" class="h-5 w-5 rounded border-white/10 bg-zinc-900 text-teal-400">
    <span class="text-sm font-medium text-zinc-300">{{ $label }}</span>
</label>
