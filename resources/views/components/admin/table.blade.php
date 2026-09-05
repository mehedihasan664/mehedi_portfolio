@props(['items', 'columns', 'edit', 'delete'])

<div class="mt-8 overflow-x-auto">
    <table class="w-full min-w-[720px] text-left text-sm">
        <thead class="text-zinc-400">
            <tr class="border-b border-white/10">
                @foreach ($columns as $label)
                    <th class="py-3 pr-4 font-medium">{{ $label }}</th>
                @endforeach
                <th class="py-3 text-right font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr class="border-b border-white/5">
                    @foreach ($columns as $key => $label)
                        <td class="max-w-xs truncate py-3 pr-4 text-zinc-300">
                            @if (is_bool($item->{$key}))
                                {{ $item->{$key} ? 'Yes' : 'No' }}
                            @else
                                {{ $item->{$key} }}
                            @endif
                        </td>
                    @endforeach
                    <td class="py-3 text-right">
                        <button wire:click="{{ $edit }}({{ $item->id }})" class="rounded-md border border-white/10 px-3 py-2 text-zinc-200">Edit</button>
                        <button wire:click="{{ $delete }}({{ $item->id }})" wire:confirm="Delete this item?" class="ml-2 rounded-md border border-red-400/30 px-3 py-2 text-red-200">Delete</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ count($columns) + 1 }}" class="py-6 text-center text-zinc-500">No items yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
