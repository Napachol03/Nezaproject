@extends('frontend')
@section('css_before')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap');

        :root {
            --ink: #0A1330;
            --navy: #0B1F5C;
            --blue: #1660C7;
            --sky: #2FB2F0;
            --mist: #EAF3FC;
            --steel: #5A6B85;
            --line: #DCE6F5;
            --paper: #FFFFFF;
            /* named the same as before elsewhere in this file */
            --gold: var(--sky);
            --canvas: var(--mist);
        }

        * {
            box-sizing: border-box;
        }

        /* ---------- Hero ---------- */
        .hero {
            background: var(--navy);
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 32px;
            align-items: center;
            padding: 72px 48px;
        }

        .hero-left {
            color: #fff;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--sky);
            margin-bottom: 20px;
        }

        .hero-eyebrow::before {
            content: '';
            width: 24px;
            height: 2px;
            background: var(--sky);
        }

        .hero h1 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 42px;
            line-height: 1.18;
            color: #fff;
            max-width: 560px;
            margin-bottom: 18px;
        }

        .hero h1 em {
            font-style: italic;
            color: var(--sky);
        }

        .hero p {
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            line-height: 1.65;
            color: #B9CBEA;
            max-width: 460px;
            margin-bottom: 30px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        /* ---------- Social Buttons ---------- */
        .hero-actions {
            display: flex;
            flex-direction: column;
            /* ทำให้เรียงลง */
            gap: 12px;
            max-width: 320px;
            /* คุมความกว้าง */
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            width: 100%;
            /* สำคัญ ทำให้ยาวเท่ากัน */
            padding: 12px 16px;

            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;

            transition: 0.25s;
        }

        /* LINE */
        .btn-line {
            background: #06C755;
            color: #fff;
        }

        .btn-line img {
            height: 20px;
        }

        /* Facebook */
        .btn-facebook {
            background: #1877F2;
            color: #fff;
        }

        /* Hover */
        .btn-social:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .fb-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue);
            color: #fff;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid var(--blue);
            transition: background .15s ease, transform .15s ease;
        }

        .fb-btn img {
            height: 16px;
            filter: brightness(0) invert(1);
        }

        .fb-btn:hover {
            background: var(--sky);
            border-color: var(--sky);
            transform: translateY(-1px);
        }

        /* Stat "patches" — styled like embroidered patches sewn onto the hero,
                           the one intentional signature flourish tying the hero back to the craft. */
        .hero-patches {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .patch {
            background: rgba(255, 255, 255, 0.08);
            border: 2px dashed var(--sky);
            border-radius: 10px;
            padding: 16px 22px;
            color: #fff;
        }

        .patch:nth-child(1) {
            transform: rotate(-2deg);
        }

        .patch:nth-child(2) {
            transform: rotate(1.5deg);
        }

        .patch:nth-child(3) {
            transform: rotate(-1deg);
        }

        .patch .num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 26px;
            font-weight: 600;
            color: var(--sky);
            line-height: 1;
        }

        .patch .label {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #DCEBFB;
            margin-top: 4px;
        }

        /* ---------- Quote strip (kept for reuse elsewhere) ---------- */
        .quote-strip {
            background: var(--paper);
            border-top: 1px dashed var(--line);
            border-bottom: 1px dashed var(--line);
            padding: 22px 48px;
            display: flex;
            gap: 40px;
            align-items: center;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: var(--steel);
            flex-wrap: wrap;
        }

        .quote-strip b {
            color: var(--ink);
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
        }

        /* ---------- Sections ---------- */
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
            border-bottom: 1px dashed var(--line);
            padding-bottom: 18px;
        }

        .section-head h2 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 26px;
            color: var(--ink);
        }

        .section-head .sub {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: var(--steel);
        }

        .chip-row {
            display: flex;
            gap: 10px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .chip {
            padding: 8px 16px;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid var(--line);
            color: var(--steel);
            background: var(--paper);
            text-decoration: none;
            display: inline-block;
            transition: border-color .15s ease, color .15s ease;
        }

        .chip.active {
            background: var(--ink);
            color: #fff;
            border-color: var(--ink);
        }

        .chip:hover {
            border-color: var(--gold);
            color: var(--ink);
        }

        /* ---------- Product cards ---------- */
        .nexa-card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            text-decoration: none;
            display: block;
            transition: border .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .nexa-card:hover {
            border: 1.5px dashed var(--gold);
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(27, 31, 59, 0.10);
        }

        .nexa-card-img {
            height: 200px;
            object-fit: contain;
            background: var(--canvas);
            display: block;
            width: 100%;
        }

        .nexa-card-noimg {
            height: 200px;
            background: var(--canvas);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--steel);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
        }

        .nexa-card-body {
            padding: 16px;
        }

        .nexa-card-title {
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .nexa-card-desc {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: var(--steel);
            margin-bottom: 10px;
        }

        .nexa-badge {
            display: inline-block;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: var(--ink);
            background: var(--canvas);
            border: 1px solid var(--line);
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* ---------- Search ---------- */
        .nexa-search-form {
            width: 100%;
        }

        .nexa-search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--paper);
            border: 1.5px solid var(--line);
            border-radius: 10px;
            padding: 6px 6px 6px 16px;
            max-width: 520px;
            transition: border-color .15s ease;
        }

        .nexa-search-box:focus-within {
            border-color: var(--gold);
        }

        .nexa-search-icon {
            color: var(--steel);
            flex-shrink: 0;
        }

        .nexa-search-input {
            flex: 1;
            border: none;
            outline: none;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: transparent;
            min-width: 0;
        }

        .nexa-search-input::placeholder {
            color: var(--steel);
        }

        .nexa-search-clear {
            color: var(--steel);
            text-decoration: none;
            font-size: 20px;
            line-height: 1;
            padding: 0 4px;
            flex-shrink: 0;
        }

        .nexa-search-clear:hover {
            color: var(--ink);
        }

        .nexa-search-btn {
            background: var(--ink);
            color: #fff;
            border: none;
            padding: 9px 20px;
            border-radius: 6px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .nexa-search-btn:hover {
            background: #2A2F55;
        }

        .nexa-search-result-info {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: var(--steel);
            margin-top: 10px;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 860px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 48px 24px;
            }

            .hero-patches {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .patch {
                flex: 1 1 140px;
            }

            .section {
                padding: 40px 24px;
            }

            .hero h1 {
                font-size: 32px;
            }
        }
    </style>
@endsection

@section('navbar')
@endsection

@section('content')

    <div class="hero">
        <div class="hero-left">
            <div class="hero-eyebrow">Corporate &amp; Premium Supply</div>
            <h1>สกรีนและปักโลโก้ <em>คุณภาพระดับองค์กร</em></h1>
            <p>ผลิตสินค้าพรีเมี่ยมสำหรับองค์กร ตั้งแต่เสื้อ กระเป๋า ไปจนถึงของพรีเมี่ยมสั่งทำ
<<<<<<< HEAD
                โดยเฉพาะ</p>
=======
                โดนเฉพาะ</p>
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
            {{-- <div class="hero-actions">

                <!-- LINE -->
                <a href="https://lin.ee/6rSd8Cy" target="_blank" class="btn-social btn-line">
                    <img src="https://scdn.line-apps.com/n/line_add_friends/btn/th.png" alt="">
                    <span>เพิ่มเพื่อน LINE</span>
                </a>

                <!-- Facebook -->
                <a href="https://www.facebook.com/Premium2546" target="_blank" class="btn-social btn-facebook">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z" />
                    </svg>
                    <span>ติดตามเราบน Facebook</span>
                </a>

            </div> --}}
        </div>
        <div class="hero-patches">
            <div class="patch">
                <div class="num">{{ number_format($totalProducts ?? 0) }}+</div>
                <div class="label">รายการสินค้า</div>
            </div>
            <div class="patch">
                <div class="num">{{ number_format($totalCustomers ?? 0) }}+</div>
                <div class="label">ลูกค้าองค์กรที่ไว้วางใจ</div>
            </div>
            {{-- <div class="patch">
                <div class="num">7–10</div>
                <div class="label">วันผลิต</div>
            </div> --}}
        </div>
    </div>

    <div class="section">
        <div class="section-head">
            <h2>สินค้าแนะนำ</h2>
            <span class="sub">อัปเดตล่าสุด</span>
        </div>

        <div class="chip-row" id="categories">
            <a href="{{ url('/') }}" class="chip {{ !request('category_id') ? 'active' : '' }}">ทั้งหมด</a>
            @foreach ($categories ?? [] as $cat)
                <a href="{{ url('/?category_id=' . $cat->category_id) }}"
                    class="chip {{ request('category_id') == $cat->category_id ? 'active' : '' }}">
                    {{ $cat->category_name }}
                </a>
            @endforeach
        </div>

        <div class="row">

            <div class="col-12 mb-4">
                <form action="{{ url('/') }}" method="GET" class="nexa-search-form">
                    <div class="nexa-search-box">
                        <svg class="nexa-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                            <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <input type="text" name="search" class="nexa-search-input" placeholder="ค้นหาชื่อสินค้า..."
                            value="{{ request('search') }}" autocomplete="off">

                        @if (request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif

                        @if (request('search'))
                            <a href="{{ url('/' . (request('category_id') ? '?category_id=' . request('category_id') : '')) }}"
                                class="nexa-search-clear" title="ล้างการค้นหา">
                                &times;
                            </a>
                        @endif

                        <button type="submit" class="nexa-search-btn">ค้นหา</button>
                    </div>
                </form>

                @if (request('search'))
                    <div class="nexa-search-result-info">
                        ผลการค้นหา "<b>{{ request('search') }}</b>" พบ {{ $products->total() }} รายการ
                    </div>
                @endif
            </div>

            @if ($products->count() > 0)
                @foreach ($products as $data)
                    @php
                        $primaryImage = $data->images->firstWhere('is_primary', true) ?? $data->images->first();
                    @endphp
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex mb-3" style="object-fit: contain;">
                        <a href="{{ url('/detail/' . $data->product_id) }}" class="nexa-card w-100">
                            @if ($primaryImage)
                                <img src="{{ $primaryImage->image_url }}" class="nexa-card-img"
                                    alt="{{ $data->product_name }}">
                            @else
                                <div class="nexa-card-noimg">
                                    <span>ไม่มีรูปภาพ</span>
                                </div>
                            @endif
                            <div class="nexa-card-body">
                                <h5 class="nexa-card-title">{{ $data->product_name }}</h5>
                                <p class="nexa-card-desc">
                                    {{ \Illuminate\Support\Str::limit($data->description, 50) }}
                                </p>
                                @if ($data->category)
                                    <span class="nexa-badge">{{ $data->category->category_name }}</span>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center text-muted py-5">
                    @if (request('search'))
                        ไม่พบสินค้าที่ตรงกับ "{{ request('search') }}"
                    @else
                        ยังไม่มีสินค้า
                    @endif
                </div>
            @endif

        </div>

        <div class="row mt-2 mb-2">
            <div class="col-sm-5 col-md-5"></div>
            <div class="col-sm-3 col-md-3">
                <center>
                    {{ $products->links() }}
                </center>
            </div>
        </div>

    </div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection
