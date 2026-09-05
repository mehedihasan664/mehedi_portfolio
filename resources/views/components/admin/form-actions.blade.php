@props(['reset', 'editing' => null])

<div class="flex gap-3 md:col-span-full">
    <button class="rounded-md bg-teal-400 px-5 py-3 font-semibold text-zinc-950">{{ $editing ? 'Update' : 'Add' }}</button>
    @if ($editing)
        <button type="button" wire:click="{{ $reset }}" class="rounded-md border border-white/10 px-5 py-3 font-semibold text-zinc-200">Cancel</button>
    @endif
</div>
