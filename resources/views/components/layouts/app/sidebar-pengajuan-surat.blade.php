<div>
    <flux:navlist.group heading="Modul Surat Tugas">


        <flux:navlist.item icon="list-bullet" href="{{ route('grants.list') }}" 
            :current="request()->routeIs('grants.list')">
            Riwayat Pengajuan
        </flux:navlist.item>

        <flux:navlist.item icon="plus-circle" href="{{ route('grants.create') }}"
            :current="request()->routeIs('grants.create')">
            Buat Surat Tugas
        </flux:navlist.item>

    </flux:navlist.group>

    {{-- Permission disesuaikan dengan yang kita buat di seeder tadi ('approve surat tugas') --}}
    @can('approve surat tugas')
        <flux:separator class="my-2" />

        <flux:navlist.group heading="Area Pejabat">
            {{-- Nanti kita buat route approval ini --}}
            <flux:navlist.item icon="inbox-stack" href="#" 
                :current="request()->routeIs('surat-tugas.approval')">
                Inbox Persetujuan
                
                {{-- Optional: Badge jumlah antrean --}}
                {{-- <flux:badge color="red" size="sm" class="ms-auto">5</flux:badge> --}}
            </flux:navlist.item>
        </flux:navlist.group>
    @endcan

    <flux:separator class="my-4" />

    <flux:navlist.item icon="arrow-left" href="{{ route('portal') }}">
        Kembali ke Portal
    </flux:navlist.item>
</div>