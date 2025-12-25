<div>
    <flux:navlist.group heading="Modul HKI">

        <flux:navlist.item icon="home" href="{{ route('hki.dashboard') }}"
            :current="request()->routeIs('hki.dashboard')">
            Dashboard HKI
        </flux:navlist.item>

        <flux:navlist.item icon="plus-circle" href="{{ route('hki.create') }}"
            :current="request()->routeIs('hki.create')">
            Ajukan Baru
        </flux:navlist.item>


    </flux:navlist.group>

    @can('review-hki')
        <flux:separator class="my-2" />

        <flux:navlist.group heading="Area Petugas">
            <flux:navlist.item icon="inbox-stack" href="{{ route('hki.reviewer.inbox') }}"
                :current="request()->routeIs('hki.reviewer.*')">
                Inbox Review
            </flux:navlist.item>
        </flux:navlist.group>
    @endcan

    <flux:separator class="my-4" />

    <flux:navlist.item icon="arrow-left" href="{{ route('portal') }}">
        Kembali ke Portal
    </flux:navlist.item>
</div>