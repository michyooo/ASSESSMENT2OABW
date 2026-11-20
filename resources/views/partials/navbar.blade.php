<nav class="navbar">
 
 
    {{-- ===========================
         BRAND
    ============================ --}}
 
    <a
        href="{{ route('dashboard') }}"
        class="navbar-brand"
    >
        FoodShare
    </a>
 
 
 
    {{-- ===========================
         MENU
    ============================ --}}
 
    <div class="navbar-menu">
 
 
        {{-- DASHBOARD --}}
 
        <a
            href="{{ route('dashboard') }}"
 
            class="{{ request()->routeIs('dashboard')
                ? 'active'
                : '' }}"
        >
            Dashboard
        </a>
 
 
 
        {{-- KATALOG
             Admin + Pemohon boleh melihat
        --}}
 
        <a
            href="{{ route('donasi.index') }}"
 
            class="{{ request()->routeIs('donasi.*')
                ? 'active'
                : '' }}"
        >
            Katalog
        </a>
 
 
 
        {{-- PENGAJUAN
             Admin melihat seluruh transaksi
             Pemohon melihat miliknya
        --}}
 
        <a
            href="{{ route('pengajuan.index') }}"
 
            class="{{ request()->routeIs('pengajuan.*')
                ? 'active'
                : '' }}"
        >
            Pengajuan
        </a>
 
 
 
        {{-- PROFILE --}}
 
        <a
            href="{{ route('profile') }}"
 
            class="{{ request()->routeIs('profile')
                ? 'active'
                : '' }}"
        >
            Profil
        </a>
 
 
 
        {{-- ===========================
             USER INFO
        ============================ --}}
 
        <div class="user-info">
 
            <strong>
                {{ auth()->user()->name }}
            </strong>
 
            <span class="user-role">
 
                {{ ucfirst(auth()->user()->role) }}
 
            </span>
 
        </div>
 
 
 
        {{-- ===========================
             LOGOUT
        ============================ --}}
 
        <form
            action="{{ route('logout') }}"
            method="POST"
            class="logout-form"
        >
 
            @csrf
 
 
            <button
                type="submit"
                class="btn-logout"
            >
                Logout
            </button>
 
        </form>
 
 
    </div>
 
</nav>