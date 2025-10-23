@php
    $user = Auth::user();
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Facturación</a>
        <div class="d-flex align-items-center ms-auto">
            <span class="me-3">{{ $user->nombre }}</span>
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" alt="Avatar" width="40" height="40" class="rounded-circle me-3" style="object-fit:cover;">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
            </form>
        </div>
    </div>
</nav>
