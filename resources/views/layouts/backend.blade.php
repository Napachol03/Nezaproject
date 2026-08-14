<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="13yCGhkx5JXxUR7cKFDNeSd-Z8NvjzMcSXP0kJIyGLI" />
    <title>NEXA Supply Premium</title>
     <link rel="icon" type="image/x-icon" href="{{ asset('NEXA.ico.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<meta name="google-site-verification" content="13yCGhkx5JXxUR7cKFDNeSd-Z8NvjzMcSXP0kJIyGLI" />
    <style>
        :root {
            --nexa-navy: #22303F;
            --nexa-navy-dark: #16212C;
            --nexa-amber: #E8963B;
            --nexa-amber-dark: #C97A22;
            --nexa-bg: #F7F5F1;
        }

        body {
            background-color: var(--nexa-bg);
        }

        .navbar-nexa {
            background-color: var(--nexa-navy);
        }

        .navbar-nexa h4 {
            color: #fff;
            margin: 0;
        }

        .navbar-nexa .brand-amber {
            color: var(--nexa-amber);
        }

        .list-group-item.active {
            background-color: var(--nexa-navy);
            border-color: var(--nexa-navy);
        }

        .list-group-item:not(.active):hover {
            background-color: #EFEAE0;
        }

        .btn-primary {
            background-color: var(--nexa-amber);
            border-color: var(--nexa-amber);
            color: #fff;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--nexa-amber-dark);
            border-color: var(--nexa-amber-dark);
        }

        .table-info,
        .table> :not(caption)>*>.table-info {
            --bs-table-bg: var(--nexa-navy);
            --bs-table-color: #fff;
            --bs-table-border-color: var(--nexa-navy-dark);
        }

        .badge.bg-success {
            background-color: var(--nexa-amber) !important;
        }

        footer {
            color: #8A8578;
        }

        /* ===== Form Card Style (NEXA theme) ===== */
        .card-header {
            background-color: #22303F !important;
            color: #fff;
            border-radius: 15px 15px 0 0 !important;
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(34, 48, 63, 0.10);
            padding: 2rem 2.5rem;
            max-width: 560px;
            margin: 0 auto;
        }

        .form-card h3 {
            text-align: center;
            font-weight: 700;
            color: var(--nexa-navy);
            margin-bottom: 1.5rem;
        }

        .form-card label {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.3rem;
        }

        .form-card .form-control,
        .form-card .form-select {
            background-color: #F4F4F2;
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 0.6rem 1rem;
        }

        .form-card .form-control:focus,
        .form-card .form-select:focus {
            background-color: #fff;
            border-color: var(--nexa-amber);
            box-shadow: 0 0 0 0.2rem rgba(232, 150, 59, 0.25);
        }

        .form-card textarea.form-control {
            border-left: 4px solid;
            border-image: linear-gradient(180deg, var(--nexa-navy), var(--nexa-amber)) 1;
        }

        .form-card .form-check-input:checked {
            background-color: var(--nexa-navy);
            border-color: var(--nexa-navy);
        }

        .form-card .remove-row-btn {
            height: 100%;
            width: 100%;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== Form buttons (NEXA theme) ===== */
        .btn-submit-gradient,
        .btn-cancel-gradient {
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            color: #fff;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-submit-gradient {
            background: linear-gradient(90deg, var(--nexa-navy), var(--nexa-navy-dark));
        }

        .btn-submit-gradient:hover {
            background: linear-gradient(90deg, var(--nexa-amber), var(--nexa-amber-dark));
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
        }

        .btn-cancel-gradient {
            background: linear-gradient(90deg, #E74C3C, #C0392B);
        }

        .btn-cancel-gradient:hover {
            background: linear-gradient(90deg, #FF3B30, #E74C3C);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
        }

        .card {
            border-radius: 15px;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 14px;
            padding: 8px 12px;
        }

        .btn {
            border-radius: 8px;
        }

        .category-btn {
            border: 1px solid #22303F;
            color: #22303F;
            background: #fff;
            border-radius: 20px;
            padding: 6px 16px;
            font-weight: 500;
            transition: all .2s;
        }

        .category-btn:hover {
            background: #22303F;
            color: #fff;
        }

        .category-btn.active {
            background: #22303F;
            color: #fff;
            border-color: #22303F;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 10px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 2px;
            transition: .25s;
        }

        .action-btn i {
            font-size: 15px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, .15);
        }

        /* ===== Navbar (โลโก้ซ้าย + โปรไฟล์ผู้ใช้ขวา) ===== */
        .navbar-nexa .navbar-brand-text {
            color: #fff;
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0;
        }

        .navbar-nexa .user-profile {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .navbar-nexa .user-profile:hover {
            color: #fff;
            opacity: 0.85;
        }

        .navbar-nexa .user-profile-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fff;
            color: var(--nexa-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .navbar-nexa .user-profile-name {
            font-size: 1.05rem;
        }
    </style>

    @yield('css_before')
</head>

<body>

    <div class="container-fluid navbar-nexa py-3 mb-3">
        <div class="d-flex align-items-center justify-content-between">

            <h4 class="navbar-brand-text">
                NEXA <span class="brand-amber">SUPPLY PREMIUM</span></span>
            </h4>

            {{-- ใช้ guard('admin') เพราะระบบ login ผ่าน Auth::guard('admin')->attempt()
                 field ที่มีจริงใน AdminModel คือ username (ไม่มี name) --}}
            <a class="user-profile">
                <span class="user-profile-name">ยินดีต้อนรับ </span>
                <span class="user-profile-name">
                    {{ Auth::guard('admin')->user()->username ?? 'User' }}
                </span>
            </a>

        </div>
    </div>

    @yield('header')

    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="list-group">
                    <a href="/dashboard" class="list-group-item list-group-item-action active" aria-current="true">
                        Dashboard
                    </a>

                    <a href="/product" class="list-group-item list-group-item-action"> Product</a>
                    <a href="/admin" class="list-group-item list-group-item-action"> Admin</a>
                    <a href="/quotation" class="list-group-item list-group-item-action"> Quotation</a>
                    <a href="/customer" class="list-group-item list-group-item-action"> Customer</a>
                    <a href="#" class="list-group-item list-group-item-action list-group-item-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                </div>
                @yield('sidebarMenu')
            </div>

            <div class="col-md-9">
                @yield('content')
            </div>

        </div>
    </div>

    {{-- form ที่ซ่อนไว้สำหรับ logout (ปุ่ม "ออกจากระบบ" ด้านบน submit form นี้) --}}
    <form id="logout-form" action="/logout" method="POST" class="d-none">
        @csrf
    </form>

    <footer class="mt-5 mb-2">
        <p class="text-center">NEXA Supply Premium</p>
    </footer>

    @yield('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    @yield('js_before')

    @include('sweetalert::alert')

</body>

</html>