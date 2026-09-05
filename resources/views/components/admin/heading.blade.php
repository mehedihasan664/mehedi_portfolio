@props(['title', 'editing' => null])

<div class="flex flex-wrap items-center justify-between gap-3">
    <h2 class="text-2xl font-semibold">{{ $title }}</h2>
    @if ($editing)
        <span class="rounded-full bg-amber-400/15 px-3 py-1 text-sm text-amber-200">Editing #{{ $editing }}</span>
    @endif
</div>
