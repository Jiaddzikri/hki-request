<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            {{-- Slot Sidebar Custom (Jika ada view yang override) --}}
            @if (isset($sidebar))
                {{ $sidebar }}
            @else
                
                {{-- 1. DASHBOARD UTAMA --}}
                <flux:navlist.group>
                    <flux:navlist.item icon="home" href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')">
                        Dashboard
                    </flux:navlist.item>
                    
                    <flux:navlist.item icon="globe-alt" href="{{ route('portal') }}">
                        Portal LPPM
                    </flux:navlist.item>
                </flux:navlist.group>


                {{-- 2. MODUL SENTRA HKI --}}
                <flux:navlist.group heading="Sentra HKI">
                    <flux:navlist.item icon="document-plus" href="{{ route('hki.create') }}" :current="request()->routeIs('hki.create')">
                        Ajukan HKI Baru
                    </flux:navlist.item>

                    <flux:navlist.item icon="archive-box" href="{{ route('hki.dashboard') }}" :current="request()->routeIs('hki.dashboard*')">
                        Arsip HKI Saya
                    </flux:navlist.item>
                </flux:navlist.group>


                {{-- 3. MODUL PENELITIAN & SURAT TUGAS --}}
                <flux:navlist.group heading="Administrasi Penelitian">
                    <flux:navlist.item icon="academic-cap" href="{{ route('grants.create') }}" :current="request()->routeIs('grants.create')">
                        Pengajuan Hibah
                    </flux:navlist.item>

                    <flux:navlist.item icon="clipboard-document-list" href="#" :current="request()->routeIs('surat-tugas.*')">
                        Surat Tugas & SK
                    </flux:navlist.item>
                </flux:navlist.group>


                {{-- 4. AREA PEJABAT (REVIEWER) --}}
                @can('review-hki')
                    <flux:navlist.group heading="Area Reviewer">
                        <flux:navlist.item icon="inbox-arrow-down" href="{{ route('hki.reviewer.inbox') }}" 
                            :current="request()->routeIs('hki.reviewer.*')"
                            badge="{{ \App\Models\HkiProposal::where('status', 'SUBMITTED')->count() }}">
                            Inbox Review HKI
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endcan


                {{-- 5. AREA ADMIN SYSTEM --}}
                @role('super-admin')
                    <flux:navlist.group heading="System Admin">
                        <flux:navlist.item icon="users" href="{{ route('admin.users') }}" :current="request()->routeIs('admin.users')">
                            Manajemen User
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endrole


                {{-- 6. PENGATURAN AKUN --}}
                <flux:navlist.group heading="Pengaturan">
                    <flux:navlist.item icon="user-circle" href="{{ route('profile.edit') }}" :current="request()->routeIs('profile.*')">
                        Profile Saya
                    </flux:navlist.item>
                </flux:navlist.group>

            @endif
        </flux:navlist>

        <flux:spacer />

        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :avatar="auth()->user()->profile_photo_url ?? asset('images/default-avatar.png')" icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <img class="w-full h-full" src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.png') }}" alt="">
                            </span>
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog">
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="end">
            {{-- Saya sesuaikan avatar logicnya agar aman --}}
            <flux:profile :avatar="auth()->user()->profile_photo_url ?? asset('images/default-avatar.png')" icon-trailing="chevron-down" />
            
            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </span>
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog">
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>
</html>