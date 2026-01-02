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
            --sidebar-bg: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            --sidebar-width: 280px;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --bg-body: #f8fafc;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%), var(--bg-body);
            color: #334155;
            min-height: 100vh;
        }

        /* SIDEBAR WITH GLASSMORPHISM */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: var(--sidebar-bg);
            color: #94a3b8;
            padding: 28px 24px;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.35rem;
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.5s ease-out;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nav-label {
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #64748b;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            padding-left: 16px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            margin-bottom: 6px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--gradient-primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(4px);
        }

        .nav-link:hover::before {
            transform: scaleY(1);
        }

        .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.35), 0 0 20px rgba(102, 126, 234, 0.2);
            transform: translateX(4px);
        }

        .nav-link.active::before {
            transform: scaleY(1);
        }

        .nav-link i { 
            width: 22px; 
            margin-right: 14px; 
            text-align: center;
            font-size: 16px;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 36px 40px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            animation: slideInLeft 0.6s ease-out;
        }

        .top-header h4 {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.75rem;
        }

        .user-badge {
            background: white;
            padding: 8px 20px;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .user-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border-color: var(--primary);
        }

        .user-badge img {
            border: 2px solid var(--primary);
        }

        /* ENHANCED CARDS */
        .card { 
            border: none; 
            border-radius: 20px; 
            background: white; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInLeft 0.7s ease-out;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        .card-header { 
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            border-bottom: 2px solid #e2e8f0; 
            padding: 24px 28px;
            font-weight: 600;
            color: #1e293b;
        }

        .card-body {
            padding: 28px;
        }

        /* BUTTONS */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: var(--gradient-success);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.4);
        }

        .btn-danger {
            background: var(--gradient-warning);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
        }

        .btn-logout { 
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444; 
            border: 2px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            width: 100%; 
            text-align: left; 
            margin-top: auto;
            transition: all 0.3s ease;
        }

        .btn-logout:hover { 
            background: rgba(239, 68, 68, 0.2);
            color: #dc2626;
            border-color: rgba(239, 68, 68, 0.5);
            transform: translateX(4px);
        }

        /* ALERTS WITH ANIMATION */
        .alert {
            border: none;
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* TABLE ENHANCEMENTS */
        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background: var(--gradient-primary);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 16px;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f1f5f9;
            transform: scale(1.01);
        }

        /* FORM ENHANCEMENTS */
        .form-control {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* BADGES */
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        /* SCROLL ANIMATION */
        .animate-on-scroll {
            opacity: 0;
            animation: slideInLeft 0.6s ease-out forwards;
        }

        /* CUSTOM SCROLLBAR */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fas fa-leaf text-white" style="font-size: 18px;"></i>
            </div>
            <span>HealthyLife</span>
        </div>


        <div class="nav-label">Dashboard</div>
        <a href="{{ route('spk.index') }}" class="nav-link {{ request()->is('spk*') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Ranking
        </a>

        <div class="nav-label">Master Data</div>
        <a href="{{ route('comparisons.index') }}" class="nav-link {{ request()->is('comparisons*') ? 'active' : '' }}">
            <i class="fas fa-balance-scale"></i> Perbandingan
        </a>
        <a href="{{ route('drinks.index') }}" class="nav-link {{ request()->is('drinks*') ? 'active' : '' }}">
            <i class="fas fa-wine-bottle"></i> Minuman
        </a>
        <a href="{{ route('criterias.index') }}" class="nav-link {{ request()->is('criterias*') ? 'active' : '' }}">
            <i class="fas fa-sliders-h"></i> Kriteria
        </a>
        <a href="{{ route('subcriterias.index') }}" class="nav-link {{ request()->is('subcriterias*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Range Nilai
        </a>
        <a href="{{ route('profile') }}" class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> Profile
        </a>

        <div style="margin-top: auto;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn-logout border-0">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="top-header">
            <div>
                <h4 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }} 👋</h4>
                <p class="text-muted small mb-0">Kelola data SPK dengan mudah dan efisien.</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-badge">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" class="rounded-circle me-2" width="38" height="38">
                    <div>
                        <div class="fw-bold small text-dark">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Sistem SPK</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>