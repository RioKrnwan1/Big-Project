<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Minuman Sehat</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-bg: #0f172a; 
            --sidebar-width: 260px;
            --primary: #3b82f6;
            --bg-body: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: #334155;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background-color: var(--sidebar-bg);
            color: #94a3b8;
            padding: 24px;
            z-index: 100;
        }

        .sidebar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-label {
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: #475569;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 4px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.05);
            color: white;
        }

        .nav-link.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .nav-link i { width: 20px; margin-right: 12px; text-align: center; }

        /* CONTENT AREA */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 32px;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Styles Tambahan untuk Card & Table */
        .card { border: none; border-radius: 16px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; }
        .card-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 20px 24px; }
        .btn-logout { background: rgba(255,255,255,0.05); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); width: 100%; text-align: left; margin-top: auto; }
        .btn-logout:hover { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column">
        <div class="sidebar-brand">
            <div style="width: 32px; height: 32px; background: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-leaf text-white" style="font-size: 14px;"></i>
            </div>
            <span>HealthyLife</span>
        </div>

        <div class="nav-label">Dashboard</div>
        <a href="{{ route('spk.index') }}" class="nav-link {{ request()->is('spk*') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Ranking
        </a>

        <div class="nav-label">Master Data</div>
        <a href="{{ route('drinks.index') }}" class="nav-link {{ request()->is('drinks*') ? 'active' : '' }}">
            <i class="fas fa-wine-bottle"></i> Minuman
        </a>
        <a href="{{ route('criterias.index') }}" class="nav-link {{ request()->is('criterias*') ? 'active' : '' }}">
            <i class="fas fa-sliders-h"></i> Kriteria
        </a>
        <a href="{{ route('subcriterias.index') }}" class="nav-link {{ request()->is('subcriterias*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Range Nilai
        </a>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Admin
        </a>

        <div style="margin-top: auto;">
             <a href="#" class="nav-link btn-logout">
                <i class="fas fa-sign-out-alt"></i> Keluar
             </a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-header">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Selamat Datang, Admin 👋</h4>
                <p class="text-muted small mb-0">Kelola data SPK dengan mudah.</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white px-3 py-2 rounded-pill shadow-sm d-flex align-items-center border">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0f172a&color=fff" class="rounded-circle me-2" width="32">
                    <span class="fw-bold small">Administrator</span>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>