<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'NEXA Supply Premium')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="google-site-verification" content="13yCGhkx5JXxUR7cKFDNeSd-Z8NvjzMcSXP0kJIyGLI" />
    <link rel="icon" type="image/x-icon" href="{{ asset('NEXA.ico.png') }}">

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
        
    </style>

    @yield('css_before')
</head>

<body>

    <div class="navbar">
        <div class="nav-logo">NEXA <span>SUPPLY PREMIUM</span></div>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/') }}#categories">สินค้า</a></li>
            <li><a href="{{ url('/about') }}">เกี่ยวกับเรา</a></li>
            <li><a href="{{ url('/contact') }}">ติดต่อเรา</a></li>
        </ul>

    </div>

    @yield('navbar')

    @yield('showFromLogin')

    
    @yield('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    </script>


    @yield('js_before')
</body>

</html>
