<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="/assets/image/logo-harber.png" alt=""
                            class="block h-14 w-auto fill-current text-gray-800">
                        <!-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> -->
                    </a>
                </div>

                <!-- Navigation Links -->


                @auth
                    @if (auth()->user()->usertype === 'admin')
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.tambah-user')" :active="request()->routeIs('admin.tambah-user')">
                                {{ __('Tambah User') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.show')" :active="request()->routeIs('admin.show')">
                                {{ __('Daftar User') }}
                            </x-nav-link>

                            <x-nav-link :href="route('form.settings')" :active="request()->routeIs('form.settings')">
                                {{ __('Form Setting') }}
                            </x-nav-link>
                             <x-nav-link :href="route('tahun.index')" :active="request()->routeIs('tahun.index')">
                                {{ __('Tahun Akademik') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endauth


                @if (auth()->user()->usertype === 'user')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Instrumen Laporan Evaluasi Diri Internal') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tambah-dosen.create')" :active="request()->routeIs('tambah-dosen.create')">
                            {{ __('Tambah Dosen') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tambah-dosen.index')" :active="request()->routeIs('tambah-dosen.index')">
                            {{ __('Daftar Dosen') }}
                        </x-nav-link>
                        <div class="sm:flex sm:items-center sm:ms-6">
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false"
                                @close.stop="open = false">
                                <div @click="open = ! open">
                                    <a href="#" class="text-gray-700 hover:text-gray-900">
                                        <i class="fa-solid fa-bell mr-2"></i>
                                    </a>
                                </div>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute mt-2 w-64 rounded-md shadow-lg" style="display: none;">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white py-1">
                                        @php
                                            $notifications = App\Models\Notifikasi::where(
                                                'prodi_id',
                                                auth()->user()->id,
                                            )
                                                ->orderByDesc('created_at')
                                                ->get();

                                            $groupedNotifications = $notifications->groupBy(function ($item) {
                                                return $item->created_at->format('d M Y');
                                            });

                                        @endphp
                                        @if ($groupedNotifications->isNotEmpty())
                                            @foreach ($groupedNotifications as $date => $items)
                                                <h3 class="px-4 pt-3 text-xs font-semibold text-black ">
                                                    {{ $date }}</h3>
                                                @foreach ($items as $notification)
                                                    <p class="px-6 py-1 text-xs text-gray-700">
                                                        {{ $notification->pesan }}
                                                    </p>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <p class="px-4 py-2 text-sm text-black-700">Tidak ada notifikasi</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif

                @if (auth()->user()->usertype === 'dosen')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('dosen.dashboard')" :active="request()->routeIs('dosen.dashboard')">
                            {{ __('Dashboard Dosen') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dosen.dashboard')" :active="request()->routeIs('dosen.dashboard')">
                            {{ __('Profil Dosen') }}
                        </x-nav-link>
                    </div>
                @endif

            </div>




            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
