<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <tallstackui:script />
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>