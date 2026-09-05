<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD
=======
    <meta name="google-site-verification" content="13yCGhkx5JXxUR7cKFDNeSd-Z8NvjzMcSXP0kJIyGLI" />
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
    <title>@yield('title', 'NEXA Supply Premium')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" type="image/x-icon" href="{{ asset('NEXA.ico.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans+Thai:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --nexa-ink: #0A1330;
            --nexa-navy: #0B1F5C;
            --nexa-blue: #1660C7;
            --nexa-sky: #2FB2F0;
            --nexa-mist: #EAF3FC;
            --nexa-paper: #F7F9FC;
            --nexa-steel: #5A6B85;
            --nexa-line: #DCE6F5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'IBM Plex Sans Thai', 'Space Grotesk', sans-serif;
            background: var(--nexa-paper);
            color: var(--nexa-ink);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        .display {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        /* ---------- Navbar ---------- */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 48px;
            background: var(--nexa-navy);
            border-radius: 0;
            flex-wrap: wrap;
            gap: 12px;
        }

        .nav-logo {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.02em;
        }

        .nav-logo span {
            color: var(--nexa-sky);
        }

        .nav-links {
            display: flex;
            gap: 32px;
            list-style: none;
        }

        .nav-links a {
            color: #C9DCF5;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: #fff;
        }

        .nav-cta {
            background: var(--nexa-sky);
            color: var(--nexa-navy);
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .nav-toggle {
            display: none;
            background: transparent;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 4px;
        }

        /* ---------- Hero ---------- */
        .hero {
            position: relative;
            min-height: 420px;
            background: var(--nexa-navy);
            overflow: hidden;
            display: flex;
            align-items: stretch;
        }

        .hero-left {
            position: relative;
            z-index: 2;
            width: 58%;
            padding: 64px 0 64px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }

        .hero-eyebrow {
            font-size: 13px;
            color: var(--nexa-sky);
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .hero h1 {
            font-size: 40px;
            line-height: 1.2;
            color: #fff;
            max-width: 520px;
            margin-bottom: 16px;
        }

        .hero p {
            font-size: 15px;
            color: #B9CBEA;
            max-width: 440px;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-shear {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 52%;
            background: linear-gradient(115deg, var(--nexa-blue) 0%, var(--nexa-sky) 100%);
            clip-path: polygon(18% 0, 100% 0, 100% 100%, 0% 100%);
            z-index: 1;
        }

        .hero-shear-inner {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-left: 12%;
        }

        .hero-stat {
            background: rgba(10, 19, 48, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            padding: 20px 26px;
            color: #fff;
        }

        .hero-stat .num {
            font-size: 30px;
            font-weight: 700;
            font-family: 'Space Grotesk';
        }

        .hero-stat .label {
            font-size: 12px;
            color: #DCEBFB;
            margin-top: 2px;
        }

        /* ---------- Section ---------- */
        .section {
            padding: 56px 48px;
        }

        .section-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-head h2 {
            font-size: 24px;
            color: var(--nexa-ink);
        }

        .section-head .sub {
            font-size: 13px;
            color: var(--nexa-steel);
        }

        /* ---------- Category chips ---------- */
        .chip-row {
            display: flex;
            gap: 10px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .chip {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid var(--nexa-line);
            color: var(--nexa-steel);
            background: #fff;
            text-decoration: none;
            display: inline-block;
        }

        .chip.active {
            background: var(--nexa-navy);
            color: #fff;
            border-color: var(--nexa-navy);
        }

        .chip:hover {
            border-color: var(--nexa-sky);
            color: var(--nexa-navy);
        }

        /* ---------- Buttons matching existing class names ---------- */
        .btn-submit-gradient {
            background: linear-gradient(115deg, var(--nexa-blue), var(--nexa-sky));
            color: #fff;
            border: none;
            padding: 11px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-cancel-gradient {
            background: #fff;
            border: 1.5px solid var(--nexa-line);
            color: var(--nexa-steel);
            padding: 11px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        /* ---------- Quote strip ---------- */
        .quote-strip {
            background: var(--nexa-mist);
            border-top: 1px solid var(--nexa-line);
            border-bottom: 1px solid var(--nexa-line);
            padding: 22px 48px;
            display: flex;
            gap: 40px;
            align-items: center;
            font-size: 13px;
            color: var(--nexa-steel);
            flex-wrap: wrap;
        }

        .quote-strip b {
            color: var(--nexa-ink);
            font-family: 'IBM Plex Mono';
            font-weight: 500;
        }

        /* ---------- Footer ---------- */
        footer {
            background: var(--nexa-navy);
            color: #B9CBEA;
            padding: 36px 48px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        footer .brand {
            color: #fff;
            font-weight: 700;
            font-family: 'Space Grotesk';
        }

        /* =====================================================
           Mobile responsive breakpoints
           ===================================================== */

        /* Tablet and below */
        @media (max-width: 900px) {
            .navbar {
                padding: 16px 24px;
            }

            .section {
                padding: 40px 24px;
            }

            .quote-strip {
                padding: 18px 24px;
                gap: 24px;
            }

            footer {
                padding: 28px 24px;
            }

            .hero-left {
                padding: 48px 0 48px 24px;
                width: 62%;
            }

            .hero h1 {
                font-size: 32px;
            }
        }

        /* Phones: stack the hero, drop the diagonal shear (it only
           reads correctly at wide aspect ratios), stack the footer */
        @media (max-width: 640px) {
            .navbar {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                flex-wrap: nowrap;
                gap: 10px;
                padding: 16px 20px;
                position: relative;
            }

            .nav-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                flex-direction: column;
                gap: 0;
                background: var(--nexa-navy);
                border-top: 1px solid rgba(255, 255, 255, 0.12);
                padding: 8px 20px 16px;
                z-index: 20;
            }

            .nav-links.open {
                display: flex;
            }

            .nav-links li {
                list-style: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .nav-links li:last-child {
                border-bottom: none;
            }

            .nav-links a {
                display: block;
                padding: 12px 0;
            }

            .hero {
                min-height: 0;
                flex-direction: column;
            }

            .hero-left {
                width: 100%;
                padding: 36px 20px 28px;
            }

            .hero h1 {
                font-size: 28px;
                max-width: 100%;
            }

            .hero p {
                max-width: 100%;
                font-size: 14px;
            }

            .hero-shear {
                position: relative;
                inset: auto;
                width: 100%;
                height: 140px;
                clip-path: none;
            }

            .hero-shear-inner {
                position: relative;
                padding: 20px;
                justify-content: flex-start;
                overflow-x: auto;
            }

            .hero-stat {
                padding: 14px 18px;
                flex: 0 0 auto;
            }

            .section {
                padding: 32px 20px;
            }

            .section-head h2 {
                font-size: 20px;
            }

            .quote-strip {
                padding: 16px 20px;
                gap: 16px;
                font-size: 12px;
            }

            footer {
                flex-direction: column;
                align-items: flex-start;
                padding: 24px 20px;
                gap: 6px;
            }
        }

        /* ---------- Footer Pro ---------- */
        footer {
            background: var(--nexa-navy);
            color: #C9DCF5;
            padding: 48px;
            font-size: 13px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 32px;
            margin-bottom: 32px;
        }

        /* Brand */
        .footer-brand {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .footer-desc {
            color: #B9CBEA;
            font-size: 13px;
            line-height: 1.6;
            max-width: 320px;
        }

        /* Title */
        .footer-title {
            color: #fff;
            font-weight: 600;
            margin-bottom: 12px;
        }

        /* Links */
        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-links a {
            color: #C9DCF5;
            text-decoration: none;
            transition: 0.25s;
        }

        .footer-links a:hover {
            color: #fff;
        }

        /* Contact */
        .footer-contact div {
            margin-bottom: 8px;
        }

        /* Bottom */
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 16px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 12px;
            color: #9FB3D9;
        }

        .footer-social {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 260px;
            /* คุมความกว้างให้สวย */
        }

      
        .footer-cta {
            display: block;
            /* สำคัญ */
            width: 100%;
            /* ทำให้ยาวเท่ากัน */
            text-align: center;
            /* จัดข้อความกลาง */

            margin-top: 10px;
            padding: 12px 16px;

            background: linear-gradient(115deg, var(--nexa-blue), var(--nexa-sky));
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;

            transition: 0.25s;
        }

        .footer-cta:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @yield('css_before')
</head>

<body>

    <div class="navbar navbar-expand-lg sticky-top">
        <div class="nav-logo">NEXA <span>SUPPLY PREMIUM</span></div>
        <button type="button" class="nav-toggle" id="navToggle" aria-label="เปิดเมนู" aria-expanded="false">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
        </button>

        <ul class="nav-links" id="navLinks">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/') }}#categories">สินค้า</a></li>
            <li><a href="{{ url('/about') }}">เกี่ยวกับเรา</a></li>
            <li><a href="{{ url('/contact') }}">ติดต่อเรา</a></li>

        </ul>

    </div>

    @yield('navbar')

    @yield('content')

    <footer>
        <div class="footer-container">

            <!-- Brand -->
            <div>
                <div class="footer-brand">NEXA SUPPLY</div>
                <div class="footer-desc">
                    ผู้จัดจำหน่ายสินค้าคุณภาพ สำหรับธุรกิจและบุคคลทั่วไป
                    เน้นมาตรฐาน ความคุ้มค่า และการบริการที่เชื่อถือได้
                </div>

               

            </div>

            <!-- Menu -->
            <div >
                <div class="footer-title">เมนู</div>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">หน้าแรก</a></li>
                    <li><a href="{{ url('/') }}#categories">สินค้า</a></li>
                    <li><a href="{{ url('/about') }}">เกี่ยวกับเรา</a></li>
                    <li><a href="{{ url('/contact') }}">ติดต่อ</a></li>
                </ul>
            </div>



       
        </div>

        <!-- Bottom -->
        {{-- <div class="footer-bottom">
            <div>© {{ date('Y') + 543 }} NEXA Supply Co., Ltd.</div>
            <div>All rights reserved</div>
        </div> --}}
    </footer>

    @yield('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script>
        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', function() {
                this.blur();
            });
        });
        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', () => {
                sessionStorage.setItem('scrollToCategories', '1');
            });
        });

        window.addEventListener('load', () => {
            if (sessionStorage.getItem('scrollToCategories')) {
                sessionStorage.removeItem('scrollToCategories');

                document.getElementById('categories').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
        (function() {
            const toggle = document.getElementById('navToggle');
            const links = document.getElementById('navLinks');
            if (!toggle || !links) return;
            toggle.addEventListener('click', () => {
                links.classList.toggle('open');
            });
        })();
    </script>


    @yield('js_before')
</body>

</html>
