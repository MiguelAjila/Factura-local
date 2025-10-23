@php
    $user = Auth::user();
    $empresa = \DB::table('empresas')->where('id', $user->empresa_id)->first();
@endphp
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Facturación')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .sidebar-collapsed { width: 60px !important; transition: width 0.2s; overflow-x: hidden; }
        .sidebar-expanded { width: 250px !important; transition: width 0.2s; }
        .sidebar-collapsed .sidebar-label { display: none; }
        .sidebar-collapsed .nav-link { text-align: center; padding-left: 0.5rem; padding-right: 0.5rem; }
        /* Sidebar dark mode */
        [data-bs-theme="dark"] #sidebar {
            background-color: #23272b !important;
            border-color: #343a40 !important;
        }
        [data-bs-theme="dark"] #sidebar .nav-link {
            color: #adb5bd;
        }
        [data-bs-theme="dark"] #sidebar .nav-link.active,
        [data-bs-theme="dark"] #sidebar .nav-link:hover {
            background: #343a40;
            color: #fff;
        }
        [data-bs-theme="dark"] #sidebar .bi {
            color: #adb5bd;
        }
        [data-bs-theme="dark"] #sidebar .bi.active,
        [data-bs-theme="dark"] #sidebar .nav-link.active .bi {
            color: #fff;
        }
        /* Topbar dark mode */
        [data-bs-theme="dark"] .topbar {
            background: #23272b !important;
            border-color: #343a40 !important;
        }
        [data-bs-theme="dark"] .topbar .dropdown-toggle,
        [data-bs-theme="dark"] .topbar .fw-semibold {
            color: #fff !important;
        }
        /* General background dark */
        [data-bs-theme="dark"] body, [data-bs-theme="dark"] #mainBody {
            background-color: #181a1b !important;
        }
        /* Card dark mode */
        [data-bs-theme="dark"] .card {
            background-color: #23272b;
            color: #fff;
            border-color: #343a40;
        }
        [data-bs-theme="dark"] .card-header {
            background-color: #181a1b;
            color: #fff;
            border-color: #343a40;
        }
    </style>
</head>
<body class="bg-light" id="mainBody">
<div class="d-flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="d-flex flex-column bg-white border-end vh-100 p-3 sidebar-collapsed" style="min-width: 60px;">
        <div class="mb-4 text-center">
            @if($empresa && $empresa->ruta_logo)
                <img src="{{ asset('storage/' . $empresa->ruta_logo) }}" alt="Logo" class="mb-2" style="max-width: 40px; max-height: 40px;">
            @else
                <span class="fw-bold fs-5">{{ $empresa ? $empresa->nombre : 'Empresa' }}</span>
            @endif
        </div>
        <nav class="nav flex-column flex-md-column mb-auto">
            <a class="nav-link {{ request()->is('bienvenida') ? 'active' : '' }}" href="{{ route('bienvenida') }}">
                <span class="bi bi-house"></span>
                <span class="sidebar-label">Dashboard</span>
            </a>
            <a class="nav-link" href="#">
                <span class="bi bi-receipt"></span>
                <span class="sidebar-label">Facturas</span>
            </a>
            <a class="nav-link" href="#">
                <span class="bi bi-people"></span>
                <span class="sidebar-label">Clientes</span>
            </a>
            <a class="nav-link" href="#">
                <span class="bi bi-box"></span>
                <span class="sidebar-label">Productos</span>
            </a>
            <a class="nav-link" href="#">
                <span class="bi bi-bar-chart"></span>
                <span class="sidebar-label">Reportes</span>
            </a>
        </nav>
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 sidebar-label">Cerrar sesión</button>
                <span class="bi bi-box-arrow-right d-block d-md-none"></span>
            </form>
        </div>
    </aside>
    <!-- Topbar y contenido principal -->
    <div class="flex-grow-1">
        <div class="d-flex justify-content-end align-items-center p-3 border-bottom bg-white topbar" style="min-height: 70px;">
            <button id="toggleTheme" class="btn btn-outline-secondary btn-sm me-3" title="Cambiar modo claro/oscuro">
                <span class="bi bi-moon" id="themeIcon"></span>
            </button>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 fw-semibold">{{ $user->nombre }}</span>
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" alt="Avatar" width="40" height="40" class="rounded-circle border">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="p-4">
            @yield('contenido')
        </div>
    </div>
</div>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar hover
    const sidebar = document.getElementById('sidebar');
    sidebar.addEventListener('mouseenter', function() {
        sidebar.classList.remove('sidebar-collapsed');
        sidebar.classList.add('sidebar-expanded');
    });
    sidebar.addEventListener('mouseleave', function() {
        sidebar.classList.remove('sidebar-expanded');
        sidebar.classList.add('sidebar-collapsed');
    });

    // Modo oscuro automático y manual
    const html = document.documentElement;
    const themeBtn = document.getElementById('toggleTheme');
    const themeIcon = document.getElementById('themeIcon');
    function setTheme(mode) {
        html.setAttribute('data-bs-theme', mode);
        localStorage.setItem('theme', mode);
        themeIcon.className = mode === 'dark' ? 'bi bi-sun' : 'bi bi-moon';
    }
    // Detectar preferencia del sistema
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        setTheme(savedTheme);
    } else if (prefersDark) {
        setTheme('dark');
    } else {
        setTheme('light');
    }
    themeBtn.addEventListener('click', function() {
        const current = html.getAttribute('data-bs-theme');
        setTheme(current === 'dark' ? 'light' : 'dark');
    });
</script>
</body>
</html>
