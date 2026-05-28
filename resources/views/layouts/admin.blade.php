<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'অ্যাডমিন প্যানেল | দৈনিক ভোলা টাইমস্')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --primary-bg: #090d16;    /* Ultra dark blue-gray background */
            --sidebar-bg: #0f172a;    /* Navy slate */
            --content-bg: #0f172a;    /* Navy slate card */
            --accent: #dc2626;         /* Crimson Accent */
            --accent-hover: #b91c1c;
            --text-main: #e2e8f0;      /* Light gray body */
            --text-dark: #f8fafc;      /* High contrast white */
            --text-sub: #94a3b8;       /* Slate gray */
            --border-color: rgba(255, 255, 255, 0.06);
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Noto Sans Bengali', 'Outfit', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        /* Layout Structure */
        .admin-sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: var(--transition);
        }

        .admin-container {
            flex-grow: 1;
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        /* Sidebar Branding */
        .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #ffffff;
        }

        .brand-title span {
            color: var(--accent);
        }

        /* Sidebar Navigation */
        .sidebar-menu {
            list-style: none;
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-item {
            width: 100%;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            color: var(--text-sub);
            font-size: 0.95rem;
        }

        .menu-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.03);
            transform: translateX(4px);
        }

        .menu-link.active {
            background-color: var(--accent);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .menu-link.active:hover {
            background-color: var(--accent);
            transform: none;
        }

        /* User Profile in Sidebar */
        .sidebar-user {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: rgba(0, 0, 0, 0.15);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--accent);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #ffffff;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-sub);
        }

        /* Admin Header Bar */
        .admin-header {
            background-color: var(--sidebar-bg);
            height: 70px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-toggle-btn {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.3rem;
            cursor: pointer;
        }

        .header-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .view-site-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: var(--primary-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .view-site-btn:hover {
            border-color: var(--accent);
            color: #ffffff;
        }

        /* Main Content Wrapper */
        .admin-content {
            padding: 32px;
            flex-grow: 1;
        }

        /* Base Admin Card Styles */
        .admin-card {
            background-color: var(--content-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .card-header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title i {
            color: var(--accent);
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #a7f3d0;
        }

        /* Buttons Framework */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            outline: none;
            border: none;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--accent);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.45);
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .btn-danger {
            background-color: var(--danger);
            color: #ffffff;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 4px;
        }

        /* Responsive Table Framework */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.95rem;
        }

        .admin-table th {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 14px 16px;
            color: #ffffff;
            font-weight: 700;
            border-bottom: 2px solid var(--border-color);
        }

        .admin-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .admin-table tr:hover td {
            background-color: rgba(255, 255, 255, 0.01);
            color: #ffffff;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-success { background-color: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-warning { background-color: rgba(245, 158, 11, 0.15); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge-danger { background-color: rgba(239, 68, 68, 0.15); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

        /* Forms Framework */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            background-color: rgba(9, 13, 22, 0.5);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: #ffffff;
            font-size: 0.95rem;
            outline: none;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
        }

        .form-text {
            font-size: 0.8rem;
            color: var(--text-sub);
            margin-top: 4px;
        }

        /* Action Buttons */
        .action-flex {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 32px;
            height: 32px;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-view:hover { color: var(--success); border-color: var(--success); }
        .action-edit:hover { color: var(--warning); border-color: var(--warning); }
        .action-delete:hover { color: var(--danger); border-color: var(--danger); }

        /* Responsive Media Queries */
        @media (max-width: 1024px) {
            .admin-sidebar {
                left: -260px;
            }
            .admin-sidebar.open {
                left: 0;
            }
            .admin-container {
                margin-left: 0;
            }
            .menu-toggle-btn {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .admin-content {
                padding: 16px;
            }
            .admin-header {
                padding: 0 16px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Control Bar -->
    <aside class="admin-sidebar" id="sidebarMenu">
        <div class="sidebar-brand">
            <h2 class="brand-title">ভোলা<span>প্যানেল</span></h2>
            <button class="menu-toggle-btn" id="closeSidebar"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>ড্যাশবোর্ড</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.posts.create') }}" class="menu-link {{ request()->routeIs('admin.posts.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>সংবাদ লিখুন</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.posts.index') }}" class="menu-link {{ request()->routeIs('admin.posts.index') || request()->routeIs('admin.posts.edit') ? 'active' : '' }}">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>সকল সংবাদ</span>
                </a>
            </li>
            @can('admin-or-super')
                <li class="menu-item">
                    <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>ক্যাটাগরি সমূহ</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.epaper.index') }}" class="menu-link {{ request()->routeIs('admin.epaper.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>ই-পেপার (E-Paper)</span>
                    </a>
                </li>
            @endcan
            @can('super-admin-only')
                <li class="menu-item">
                    <a href="{{ route('admin.theme.settings') }}" class="menu-link {{ request()->routeIs('admin.theme.settings') ? 'active' : '' }}">
                        <i class="fa-solid fa-palette"></i>
                        <span>থিম ডিজাইন সেটিংস</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.users.index') }}" class="menu-link {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.create') || request()->routeIs('admin.users.edit') ? 'active' : '' }}">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>ইউজার লিস্ট</span>
                    </a>
                </li>
            @endcan
        </ul>

        <!-- Bottom User Info & Logout Form -->
        <div class="sidebar-user">
            <div class="user-avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role">
                    @if(Auth::user()->role === 'super_admin') Super Admin
                    @elseif(Auth::user()->role === 'admin') Admin
                    @else Editor
                    @endif
                </span>
            </div>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="লগআউট করুন" style="margin-left: auto; color: var(--danger); font-size: 1.1rem;">
                <i class="fa-solid fa-power-off"></i>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="admin-container">
        <!-- Dashboard Top Header Bar -->
        <header class="admin-header">
            <div class="header-left">
                <button class="menu-toggle-btn" id="openSidebar"><i class="fa-solid fa-bars"></i></button>
                <h3 class="header-title">@yield('header_title', 'ড্যাশবোর্ড')</h3>
            </div>
            <div class="header-right">
                <a href="{{ route('home') }}" target="_blank" class="view-site-btn">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>ভিজিট সাইট</span>
                </a>
            </div>
        </header>

        <!-- Main Content Slot -->
        <main class="admin-content">
            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Active Menu and Sidebar Toggles -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openSidebarBtn = document.getElementById('openSidebar');
            const closeSidebarBtn = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebarMenu');

            function toggleSidebar() {
                sidebar.classList.toggle('open');
            }

            if(openSidebarBtn) openSidebarBtn.addEventListener('click', toggleSidebar);
            if(closeSidebarBtn) closeSidebarBtn.addEventListener('click', toggleSidebar);
        });
    </script>
    
    <!-- Bootstrap 5.3.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @yield('scripts')
</body>
</html>
