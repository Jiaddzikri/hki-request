<x-layouts.app.sidebar :title="$title ?? null">

    @if (isset($sidebar))
        <x-slot:sidebar>
            {{ $sidebar }}
        </x-slot:sidebar>
    @endif

    <flux:main>
        <tallstackui:script />
        {{ $slot }}
    </flux:main>

</x-layouts.app.sidebar>