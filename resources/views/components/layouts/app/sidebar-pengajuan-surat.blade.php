<div>
  <flux:navlist.group heading="Modul Surat Tugas">


    <flux:navlist.item icon="list-bullet" href="{{ route('letter.index') }}"
      :current="request()->routeIs('letter.index')">
      Riwayat Pengajuan
    </flux:navlist.item>

    <flux:navlist.item icon="plus-circle" href="{{ route('letter.create') }}"
      :current="request()->routeIs('letter.create')">
      Buat Surat Tugas
    </flux:navlist.item>

  </flux:navlist.group>

  {{-- Reviewer Area --}}
  @role('reviewer|super-admin')
  <flux:separator class="my-4" />

  <flux:navlist.group heading="Area Reviewer">
    <flux:navlist.item icon="inbox-stack" href="{{ route('letter.reviewer') }}"
      :current="request()->routeIs('letter.reviewer')">
      Inbox Review Surat
    </flux:navlist.item>
  </flux:navlist.group>
  @endrole

  <flux:separator class="my-6" />

  <flux:navlist.item icon="arrow-left" href="{{ route('portal') }}">
    Portal LPPM
  </flux:navlist.item>
</div>