<li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
    <a href="{{ url('/') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Pages</span>
</li>
 {{-- pelanggan --}}
<li class="menu-item {{ request()->is('pelanggan') ? 'active' : '' }}">
    <a href="{{ url('/pelanggan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-user-account"></i>
        <div data-i18n="Pelanggan">Data Pelanggan</div>
    </a>
</li>

{{-- sewa --}}

<li class="menu-item {{ request()->is('sewa*') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bxs-data"></i>
        <div data-i18n="Sewa">Sewa</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ request()->is('sewa/penyewaan') ? 'active' : '' }}">
            <a href="{{ url('/sewa/penyewaan') }}" class="menu-link">
                <div data-i18n="Penyewaan">Penyewaan</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('sewa/pengembalian') ? 'active' : '' }}">
            <a href="{{ url('/sewa/pengembalian') }}" class="menu-link">
                <div data-i18n="Pengembalian">Pengembalian</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('sewa/riwayat') ? 'active' : '' }}">
            <a href="{{ url('/sewa/riwayat') }}" class="menu-link">
                <div data-i18n="Riwayat">Riwayat Penyewaan</div>
            </a>
        </li>
    </ul>
</li>


<li class="menu-item {{ request()->is('merek') || request()->is('motor*') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-taxi"></i>
        <div data-i18n="Account Settings">Motor</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ request()->is('merek') ? 'active' : '' }}">
            <a href="{{ url('/merek') }}" class="menu-link">
                <div data-i18n="Merek">Merek</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('motor') ? 'active' : '' }}">
            <a href="{{ url('/motor') }}" class="menu-link">
                <div data-i18n="Data Motor">Data Motor</div>
            </a>
        </li>
    </ul>
</li>


