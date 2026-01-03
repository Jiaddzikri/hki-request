<div>
  <flux:navlist.group heading="Modul Sentra HKI">

    <flux:navlist.item icon="home" href="{{ route('hki.dashboard') }}" :current="request()->routeIs('hki.dashboard')">
      Dashboard HKI
    </flux:navlist.item>

    <flux:navlist.item icon="list-bullet" href="{{ route('hki.list') }}" :current="request()->routeIs('hki.list')">
      Daftar Proposal
    </flux:navlist.item>

    <flux:navlist.item icon="plus-circle" href="{{ route('hki.create') }}" :current="request()->routeIs('hki.create')">
      Ajukan Proposal Baru
    </flux:navlist.item>

  </flux:navlist.group>

  @can('review-hki')
    <flux:separator class="my-4" />

    <flux:navlist.group heading="Area Reviewer">
      <flux:navlist.item icon="inbox-stack" href="{{ route('hki.reviewer.inbox') }}"
        :current="request()->routeIs('hki.reviewer.*')">
        Inbox Review HKI
      </flux:navlist.item>
    </flux:navlist.group>
  @endcan

  <flux:separator class="my-6" />

  <flux:navlist.item icon="arrow-left" href="{{ route('portal') }}">
    Portal LPPM
  </flux:navlist.item>
</div>