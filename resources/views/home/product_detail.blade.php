@extends('frontend')
@section('css_before')
    <style>
        :root {
            --nexa-ink: #0A1330;
            --nexa-navy: #0B1F5C;
            --nexa-blue: #1660C7;
            --nexa-sky: #2FB2F0;
            --nexa-mist: #EAF3FC;
            --nexa-steel: #5A6B85;
            --nexa-line: #DCE6F5;
        }

        .pd-wrap {
            display: flex;
            gap: 40px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        /* ---------- Breadcrumb ---------- */
        .pd-breadcrumb {
            font-size: 13px;
            color: var(--nexa-steel);
            margin-bottom: 20px;
        }

        .pd-breadcrumb a {
            color: var(--nexa-steel);
            text-decoration: none;
        }

        .pd-breadcrumb a:hover {
            color: var(--nexa-blue);
        }

        .pd-breadcrumb span {
            margin: 0 6px;
        }

        /* ---------- Gallery ---------- */
        .pd-gallery {
            flex: 0 0 420px;
            max-width: 420px;
            width: 100%;
        }

        .pd-main-img-box {
            background: #fff;
            border: 1px solid var(--nexa-line);
            border-radius: 12px;
            overflow: hidden;
            height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .pd-main-img-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .pd-main-img-none {
            color: var(--nexa-steel);
            font-size: 13px;
        }

        .pd-thumbs-row {
            position: relative;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pd-thumbs {
            display: flex;
            gap: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-bottom: 2px;
        }

        .pd-thumbs::-webkit-scrollbar {
            display: none;
        }

        .pd-thumb {
            width: 76px;
            height: 76px;
            flex: 0 0 auto;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--nexa-line);
            cursor: pointer;
            padding: 0;
            background: #fff;
            transition: border-color .15s ease;
        }

        .pd-thumb-nav {
            flex: 0 0 auto;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1.5px solid var(--nexa-line);
            background: #fff;
            color: var(--nexa-steel);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color .15s ease, color .15s ease;
        }

        .pd-thumb-nav:hover {
            border-color: var(--nexa-sky);
            color: var(--nexa-navy);
        }

        .pd-thumb-nav:disabled {
            opacity: .35;
            cursor: default;
        }

        .pd-thumb-nav:disabled:hover {
            border-color: var(--nexa-line);
            color: var(--nexa-steel);
        }

        .pd-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .pd-thumb:hover {
            border-color: var(--nexa-sky);
        }

        .pd-thumb.active {
            border-color: var(--nexa-blue);
        }

        /* ---------- Info ---------- */
        .pd-info {
            flex: 1 1 340px;
            min-width: 300px;
        }

        .pd-category {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            color: var(--nexa-blue);
            background: var(--nexa-mist);
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 12px;
        }

        .pd-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 26px;
            color: var(--nexa-ink);
            margin-bottom: 12px;
            line-height: 1.3;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .pd-price {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--nexa-blue);
            margin-bottom: 20px;
        }

        .pd-price small {
            font-size: 14px;
            font-weight: 500;
            color: var(--nexa-steel);
        }

        .pd-divider {
            border: none;
            border-top: 1px solid var(--nexa-line);
            margin: 20px 0;
        }

        .pd-desc-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--nexa-ink);
            margin-bottom: 8px;
        }

        .pd-desc {
            font-size: 14px;
            color: var(--nexa-steel);
            white-space: pre-line;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .pd-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pd-actions-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--nexa-ink);
            margin-bottom: 12px;
        }

        .btn-fb-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #1877F2;
            color: #fff;
            text-decoration: none;
            padding: 13px 26px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-fb-custom:hover {
            background: #1461D1;
        }

        .btn-line-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #06C755;
            color: #fff;
            text-decoration: none;
            padding: 13px 26px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-back-list {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--nexa-line);
            color: var(--nexa-steel);
            text-decoration: none;
            padding: 13px 26px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-back-list:hover {
            border-color: var(--nexa-sky);
            color: var(--nexa-navy);
        }

        /* ---------- Copy icon button (transparent, no border) ---------- */
        .icon-btn-copy {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: transparent;
            border: none;
            color: var(--nexa-steel);
            cursor: pointer;
            padding: 0;
            border-radius: 6px;
            transition: color .15s ease;
        }

        .icon-btn-copy:hover {
            background: transparent;
            color: var(--nexa-navy);
        }

        .icon-btn-copy.copied {
            background: transparent;
            color: var(--nexa-blue);
        }

        @media (max-width: 767px) {
            .pd-gallery {
                flex: 1 1 100%;
                max-width: 100%;
            }

            .pd-main-img-box {
                height: 320px;
            }
        }
    </style>
@endsection
@section('navbar')
@endsection
@section('content')

    <div class="col-12 p-5">
        <div class="pd-breadcrumb">
            <a href="{{ url('/') }}">สินค้าทั้งหมด</a>
            @if ($products->category ?? null)
                <span>/</span>
                <a href="{{ url('/?category_id=' . $products->category_id) }}">{{ $products->category->category_name }}</a>
            @endif
            <span>/</span>
            {{ $products->product_name }}
        </div>

        <div class="pd-wrap">
            <div class="pd-gallery">
                <div class="pd-main-img-box" id="pdMainImgBox">
                    @if ($products->images->count() > 0)
                        <img id="pdMainImg" src="{{ $products->images->first()->image_url }}"
                            alt="{{ $products->product_name }}">
                    @else
                        <div class="pd-main-img-none">ไม่มีรูปภาพ</div>
                    @endif
                </div>

                @if ($products->images->count() > 1)
                    <div class="pd-thumbs-row">
                        <button type="button" class="pd-thumb-nav" id="pdThumbPrev" onclick="pdScrollThumbs(-1)"
                            aria-label="เลื่อนซ้าย">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6" />
                            </svg>
                        </button>
                        <div class="pd-thumbs" id="pdThumbs">
                            @foreach ($products->images as $index => $pic)
                                <button type="button" class="pd-thumb {{ $index === 0 ? 'active' : '' }}"
                                    data-img="{{ $pic->image_url }}" onclick="pdSwitchImage(this)">
                                    <img src="{{ $pic->image_url }}"
                                        alt="{{ $products->product_name }} {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>
                        <button type="button" class="pd-thumb-nav" id="pdThumbNext" onclick="pdScrollThumbs(1)"
                            aria-label="เลื่อนขวา">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <div class="pd-info">
                @if ($products->category ?? null)
                    <span class="pd-category">{{ $products->category->category_name }}</span>
                @endif

                <h1 class="pd-title">
                    {{ $products->product_name }}
                    <button type="button" class="icon-btn-copy" title="คัดลอกชื่อสินค้า" onclick="pdCopyName(this)"
                        data-text="สอบถามสินค้า: {{ $products->product_name }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="9" y="9" width="13" height="13" rx="2" />
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                        </svg>
                    </button>
                </h1>

                {{-- <div class="pd-price">
                {{ number_format($products->price) }} <small>THB</small>
            </div> --}}

                <hr class="pd-divider">

                <div class="pd-desc-title">รายละเอียดสินค้า</div>
                <p class="pd-desc">{{ $products->description ?: 'ไม่มีรายละเอียดเพิ่มเติม' }}</p>

                @if (!empty($products->attributes) && is_array($products->attributes))
                    <div class="pd-desc-title">สเปก</div>
                    <p class="pd-desc">
                        @foreach ($products->attributes as $key => $value)
                            <strong>{{ $key }}:</strong> {{ $value }}<br>
                        @endforeach
                    </p>
                @endif

                <div class="pd-actions-wrap">
                    <h3 class="pd-actions-title">สอบถาม / สั่งซื้อผ่าน</h3>
                    <div class="pd-actions">
                        <a href="https://lin.ee/6rSd8Cy" target="_blank" rel="noopener" class="btn-line-custom">
                            LINE
                        </a>
                        <a href="https://m.me/Premium2546" target="_blank" rel="noopener" class="btn-fb-custom">Facebook</a>

                        <a href="{{ url('/') }}" class="btn-back-list">← กลับไปหน้าสินค้าทั้งหมด</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
@endsection

@section('js_before')
    <script>
        function pdSwitchImage(btn) {
            const mainImg = document.getElementById('pdMainImg');
            const newSrc = btn.getAttribute('data-img');
            if (mainImg && newSrc) {
                mainImg.src = newSrc;
            }
            document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
        }

        function pdScrollThumbs(direction) {
            const track = document.getElementById('pdThumbs');
            if (!track) return;
            track.scrollBy({
                left: direction * 200,
                behavior: 'smooth'
            });
        }

        (function() {
            const track = document.getElementById('pdThumbs');
            const prevBtn = document.getElementById('pdThumbPrev');
            const nextBtn = document.getElementById('pdThumbNext');
            if (!track || !prevBtn || !nextBtn) return;

            function updateThumbNavState() {
                const maxScroll = track.scrollWidth - track.clientWidth;
                prevBtn.disabled = track.scrollLeft <= 2;
                nextBtn.disabled = track.scrollLeft >= maxScroll - 2;
            }

            track.addEventListener('scroll', updateThumbNavState);
            window.addEventListener('resize', updateThumbNavState);
            updateThumbNavState();
        })();

        function pdCopyName(btn) {
            const text = btn.getAttribute('data-text');
            navigator.clipboard.writeText(text).then(() => {
                const original = btn.innerHTML;
                btn.innerHTML =
                    `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>`;
                btn.classList.add('copied');
                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.classList.remove('copied');
                }, 1500);
            });
        }
    </script>
@endsection
