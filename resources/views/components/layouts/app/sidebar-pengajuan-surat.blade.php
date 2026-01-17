<div>
  <flux:navlist.group heading="Modul Surat Tugas">

    <flux:navlist.item icon="list-bullet" href="{{ route('letter.assignment.index') }}"
      :current="request()->routeIs('letter.assignment.index')">
      Daftar Pengajuan
    </flux:navlist.item>

    <flux:navlist.item icon="plus-circle" href="{{ route('letter.assignment.create') }}"
      :current="request()->routeIs('letter.assignment.create')">
      Ajukan Surat Baru
    </flux:navlist.item>

  </flux:navlist.group>

  @role('reviewer|super-admin')
  <flux:separator class="my-4" />

  <flux:navlist.group heading="Area Reviewer">
    <flux:navlist.item icon="inbox-stack" href="{{ route('letter.assignment.reviewer.inbox') }}"
      :current="request()->routeIs('letter.assignment.reviewer.*')">
      Inbox Review Surat
    </flux:navlist.item>
  </flux:navlist.group>
  @endrole

  <flux:separator class="my-6" />

  <flux:navlist.item icon="arrow-left" href="{{ route('portal') }}">
    Portal LPPM
  </flux:navlist.item>
</div>