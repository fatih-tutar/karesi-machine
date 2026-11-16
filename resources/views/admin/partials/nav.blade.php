@php
    $links = [
        ['accounting.index', 'accounting*', 'Muhasebe'],
        ['materials.index', 'materials*', 'Malzemeler'],
        ['companies.index', 'companies*', 'Firmalar'],
        ['projects.index', 'projects*', 'Projeler'],
        ['finance.index', 'finance*', 'Grafik'],
        ['machines.index', 'machines*', 'Makineler'],
    ];
@endphp
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('accounting.index') }}">
            <img src="{{ asset('img/mavilogo-2.png') }}" width="120" class="ms-md-5 me-2" alt="Karesi Makine" />
        </a>

        <!-- DESKTOP MENU -->
        <div class="d-none d-md-flex gap-4 align-items-center">
            @foreach ($links as [$route, $pattern, $label])
                <a class="nav-link {{ request()->is($pattern) ? 'fw-bold' : '' }}" href="{{ route($route) }}">{{ $label }}</a>
            @endforeach
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-link nav-link p-0 text-danger">Çıkış</button>
            </form>
        </div>

        <!-- MOBILE DROPDOWN -->
        <div class="dropdown d-md-none">
            <i class="bi bi-list" data-bs-toggle="dropdown" style="font-size: 25px; margin-right:20px;"></i>
            <ul class="dropdown-menu dropdown-menu-end">
                @foreach ($links as [$route, $pattern, $label])
                    <li><a class="dropdown-item" href="{{ route($route) }}">{{ $label }}</a></li>
                @endforeach
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Çıkış</button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>
