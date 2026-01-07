<div>
  <flux:navlist.group heading="Modul Permohonan ISBN">

    <flux:navlist.item icon="book-open" href="{{ route('book.index') }}" :current="request()->routeIs('book.index')">
      Daftar Permohonan
    </flux:navlist.item>

    <flux:navlist.item icon="plus-circle" href="{{ route('book.create') }}"
      :current="request()->routeIs('book.create')">
      Ajukan ISBN Baru
    </flux:navlist.item>

  </flux:navlist.group>

  @role('reviewer|super-admin')
    <flux:separator class="my-4" />

    <flux:navlist.group heading="Area Reviewer">
      <flux:navlist.item icon="inbox-stack" href="{{ route('book.reviewer.index') }}"
        :current="request()->routeIs('book.reviewer.*')">
        Inbox Review ISBN
      </flux:navlist.item>
    </flux:navlist.group>
  @endrole

  <flux:separator class="my-6" />

  <flux:navlist.item icon="arrow-left" href="{{ route('portal') }}">
    Portal LPPM
  </flux:navlist.item>
</div>