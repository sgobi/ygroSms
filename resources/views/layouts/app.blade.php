<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – Y GRO SMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #1e3a5f;
            --accent: #f59e0b;
        }
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; }
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-width); background: var(--primary);
            color: #fff; overflow-y: auto; z-index: 1040; transition: transform .3s;
        }
        .sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .sidebar .brand h5 { font-size: .9rem; font-weight: 700; margin: 0; line-height: 1.3; }
        .sidebar .brand small { font-size: .72rem; color: rgba(255,255,255,.55); }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75); padding: .55rem 1.5rem;
            font-size: .85rem; display: flex; align-items: center; gap: .6rem;
            border-radius: 0; transition: background .2s, color .2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.12); color: #fff; }
        .sidebar .nav-section { padding: .75rem 1.5rem .25rem; font-size: .7rem; font-weight: 600; color: rgba(255,255,255,.4); letter-spacing: .08em; text-transform: uppercase; }
        .main-wrap { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 1030;
        }
        .topbar .page-title { font-size: 1rem; font-weight: 600; color: var(--primary); margin: 0; }
        .content-area { flex: 1; padding: 1.75rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .card-header { border-bottom: 1px solid #f0f4f8; background: #fff; border-radius: 12px 12px 0 0 !important; }
        .stat-card { border-radius: 12px; color: #fff; padding: 1.25rem 1.5rem; }
        .stat-card .stat-icon { font-size: 2.2rem; opacity: .8; }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 700; }
        .stat-card .stat-label { font-size: .8rem; opacity: .85; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: #162c4a; border-color: #162c4a; }
        .badge-grade { display: inline-block; padding: .2em .55em; border-radius: 6px; font-size: .78rem; font-weight: 600; background: #e0e7ff; color: #3730a3; }
        .table th { font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #64748b; }
        .table td { vertical-align: middle; font-size: .875rem; }
        .sidebar-logo { width: 36px; height: 36px; border-radius: 8px; background: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary); font-size: 1rem; margin-bottom: .5rem; }
        @media(max-width:768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="brand">
        <div class="sidebar-logo">YG</div>
        <h5>Y GRO Student<br>Management System</h5>
        <small>Admin Panel</small>
    </div>
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
        </li>

        <div class="nav-section">Students</div>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                <i class="bi bi-people"></i> Students
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('schools.*') ? 'active' : '' }}" href="{{ route('schools.index') }}">
                <i class="bi bi-building"></i> Schools
            </a>
        </li>

        <div class="nav-section">Academics</div>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">
                <i class="bi bi-journal-bookmark"></i> Subjects
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('marks.*') ? 'active' : '' }}" href="{{ route('marks.index') }}">
                <i class="bi bi-pencil-square"></i> Marks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('academic-years.*') ? 'active' : '' }}" href="{{ route('academic-years.index') }}">
                <i class="bi bi-calendar3"></i> Academic Years
            </a>
        </li>

        <div class="nav-section">Welfare</div>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('distributions.*') ? 'active' : '' }}" href="{{ route('distributions.index') }}">
                <i class="bi bi-gift"></i> Distributions
            </a>
        </li>

        <div class="nav-section">Reports</div>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Reports & PDFs
            </a>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<div class="main-wrap">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <span class="page-title">@yield('title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
