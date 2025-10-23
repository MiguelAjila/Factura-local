@php
    $user = Auth::user();
    $empresa = \DB::table('empresas')->where('id', $user->empresa_id)->first();
@endphp
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="d-flex">
    <!-- Sidebar -->
    <aside class="d-flex flex-column bg-white border-end vh-100 p-3" style="width: 250px; min-width: 200px;">
        <div class="mb-4 text-center">
            @if($empresa && $empresa->ruta_logo)
                <img src="{{ asset('storage/' . $empresa->ruta_logo) }}" alt="Logo" class="mb-2" style="max-width: 80px; max-height: 80px;">
            @else
                <span class="fw-bold fs-5">{{ $empresa ? $empresa->nombre : 'Empresa' }}</span>
            @endif
        </div>
        <nav class="nav flex-column flex-md-column mb-auto">
            <a class="nav-link {{ request()->is('bienvenida') ? 'active' : '' }}" href="{{ route('bienvenida') }}">Dashboard</a>
            <a class="nav-link" href="#">Facturas</a>
            <a class="nav-link" href="#">Clientes</a>
            <a class="nav-link" href="#">Productos</a>
            <a class="nav-link" href="#">Reportes</a>
        </nav>
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">Cerrar sesión</button>
            </form>
        </div>
    </aside>
    <style>
        .sidebar-collapsed {
            width: 70px !important;
            transition: width 0.2s;
            overflow-x: hidden;
        }
        .sidebar-expanded {
            width: 250px !important;
            transition: width 0.2s;
        }
        .sidebar-collapsed .sidebar-label {
            display: none;
        }
        .sidebar-collapsed .nav-link {
            text-align: center;
            padding: 0.75rem 0.5rem;
        }
        .user-avatar {
            transform: scale(1.05);
        }
    </style>
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
                    <span class="bi bi-house-fill sidebar-icon"></span>
                    <span class="sidebar-label">Dashboard</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="bi bi-receipt-fill sidebar-icon"></span>
                    <span class="sidebar-label">Facturas</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="bi bi-people-fill sidebar-icon"></span>
                    <span class="sidebar-label">Clientes</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="bi bi-box-fill sidebar-icon"></span>
                    <span class="sidebar-label">Productos</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="bi bi-bar-chart-fill sidebar-icon"></span>
                    <span class="sidebar-label">Reportes</span>
                </a>
            </nav>
        </aside>
        <!-- Topbar con usuario -->
        <div class="flex-grow-1">
            <div class="d-flex justify-content-end align-items-center p-3 border-bottom bg-white" style="min-height: 70px;">
                <span class="me-2 fw-semibold">{{ $user->nombre }}</span>
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" 
                     alt="Avatar" 
                     width="40" 
                     height="40" 
                     class="rounded-circle border user-avatar"
                     data-bs-toggle="modal" 
                     data-bs-target="#userSettingsModal">
            </div>
            <!-- User Settings Modal -->
            <div class="modal fade" id="userSettingsModal" tabindex="-1" aria-labelledby="userSettingsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userSettingsModalLabel">Configuración de Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form id="userSettingsForm">
                                <div class="mb-3 text-center">
                                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" 
                                         alt="Avatar" 
                                         width="100" 
                                         height="100" 
                                         class="rounded-circle border mb-2">
                                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $user->nombre }}">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nueva contraseña (dejar en blanco para no cambiar)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="saveUserSettings">Guardar cambios</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                @yield('contenido')
            </div>
        </div>
    </div>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
