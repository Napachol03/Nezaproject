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

        .ct-hero {
            background: linear-gradient(135deg, var(--nexa-mist) 0%, #fff 100%);
            border: 1px solid var(--nexa-line);
            border-radius: 16px;
            padding: 48px 40px;
            margin-bottom: 32px;
            text-align: center;
        }

        .ct-eyebrow {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            color: var(--nexa-blue);
            background: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
            border: 1px solid var(--nexa-line);
        }

        .ct-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 34px;
            color: var(--nexa-ink);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .ct-subtitle {
            font-size: 16px;
            color: var(--nexa-steel);
            max-width: 620px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .ct-wrap {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        /* ---------- Channel cards (LINE / Facebook) ---------- */
        .ct-channels {
            flex: 1 1 340px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .ct-channel-card {
            background: #fff;
            border: 1px solid var(--nexa-line);
            border-radius: 14px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            text-decoration: none;
            transition: border-color .15s ease, transform .15s ease;
        }

        .ct-channel-card:hover {
            border-color: var(--nexa-sky);
            transform: translateY(-2px);
        }

        .ct-channel-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            color: #fff;
        }

        .ct-channel-icon.line {
            background: #06C755;
        }

        .ct-channel-icon.fb {
            background: #1877F2;
        }

        .ct-channel-body {
            flex: 1 1 auto;
        }

        .ct-channel-name {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: var(--nexa-ink);
            margin-bottom: 2px;
        }

        .ct-channel-desc {
            font-size: 13px;
            color: var(--nexa-steel);
        }

        .ct-channel-arrow {
            color: var(--nexa-steel);
            flex: 0 0 auto;
        }

        /* ---------- Info panel ---------- */
        .ct-info {
            flex: 1 1 300px;
            background: var(--nexa-navy);
            border-radius: 14px;
            padding: 32px;
            color: #fff;
        }

        .ct-info-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .ct-info-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .ct-info-item:last-child {
            margin-bottom: 0;
        }

        .ct-info-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--nexa-sky);
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .ct-info-label {
            font-size: 12px;
            color: #A9BADB;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 3px;
        }

        .ct-info-value {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.6;
        }

        /* ---------- FAQ ---------- */
        .ct-faq {
            margin-top: 32px;
        }

        .ct-faq-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: var(--nexa-ink);
            margin-bottom: 16px;
        }

        .ct-faq-item {
            background: #fff;
            border: 1px solid var(--nexa-line);
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 10px;
        }

        .ct-faq-q {
            font-size: 14px;
            font-weight: 600;
            color: var(--nexa-ink);
            margin-bottom: 6px;
        }

        .ct-faq-a {
            font-size: 13px;
            color: var(--nexa-steel);
            line-height: 1.7;
        }

        @media (max-width: 767px) {
            .ct-hero {
                padding: 32px 20px;
            }

            .ct-title {
                font-size: 26px;
            }

            .ct-wrap {
                flex-direction: column;
            }
        }
    </style>
@endsection
@section('navbar')
@endsection
@section('content')
    <div class="col-12 p-5">

        <div class="ct-hero">
            <span class="ct-eyebrow" style="font-size: 100%">ติดต่อเรา</span>
            <h1 class="ct-title">พร้อมให้คำแนะนำทุกคำถาม</h1>
            <p class="ct-subtitle">
                {{-- TODO: ปรับข้อความให้ตรงกับร้าน --}}
                สอบถามข้อมูลสินค้า สั่งซื้อ หรือแจ้งปัญหาการใช้งาน ทีมงานของเราพร้อมตอบทุกช่องทางด้านล่าง
            </p>
        </div>

        <div class="ct-wrap">
            <div class="ct-channels">
                <a href="https://lin.ee/RIKGxrUM" target="_blank" rel="noopener" class="ct-channel-card">
                    <div class="ct-channel-icon line">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .348-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>
                    </div>
                    <div class="ct-channel-body">
                        <div class="ct-channel-name">แชทผ่าน LINE</div>
                        <div class="ct-channel-desc">ตอบไว เหมาะกับคำถามด่วน</div>
                    </div>
                    <div class="ct-channel-arrow">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                    </div>
                </a>

                <a href="https://www.facebook.com/Premium2546" target="_blank" rel="noopener" class="ct-channel-card">
                    <div class="ct-channel-icon fb">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <div class="ct-channel-body">
                        <div class="ct-channel-name">ข้อความผ่าน Facebook</div>
                        <div class="ct-channel-desc">ดูรีวิวและอัปเดตสินค้าใหม่ได้ด้วย</div>
                    </div>
                    <div class="ct-channel-arrow">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                    </div>
                </a>
            </div>

            <div class="ct-info">
                <div class="ct-info-title">ข้อมูลติดต่อ</div>

                <div class="ct-info-item">
                    <div class="ct-info-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <div class="ct-info-label">โทรศัพท์</div>
                        {{-- TODO: ใส่เบอร์จริง --}}
                        <a href="tel:0863179475" class="ct-info-value" style="color:#fff; text-decoration:none;">086-317-9475</a>
                        <a class="ct-info-value" style="color:#fff;">,</a>
                        <a href="tel:0863179475" class="ct-info-value" style="color:#fff; text-decoration:none;">081-696-8262</a>
                    </div>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="m22 6-10 7L2 6"/></svg>
                    </div>
                    <div>
                        <div class="ct-info-label">อีเมล</div>
                        {{-- TODO: ใส่อีเมลจริง --}}
                         <div class="ct-info-value"><a href="mailto:mod_2546@WINDOWSLIVE.com" style="color:#fff; text-decoration:none;">mod_2546@WINDOWSLIVE.com</a></div>
                    </div>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="ct-info-label">เวลาทำการ</div>
                        <div class="ct-info-value">ทุกวัน 08:30 - 17:30<br>(หยุดวันอาทิตย์)</div>
                    </div>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <div class="ct-info-label">ที่อยู่</div>
                        {{-- TODO: ใส่ที่อยู่จริง หรือลบถ้าไม่มีหน้าร้าน --}}
                        <div class="ct-info-value">หมู่บ้าน ดี.เค. บางบอน, Bangkok, Thailand, 10150</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="ct-faq">
            <div class="ct-faq-title">คำถามที่พบบ่อย</div>

            <div class="ct-faq-item">
                <div class="ct-faq-q">สั่งซื้อสินค้าอย่างไร?</div>
                {{-- TODO: ปรับให้ตรงกับขั้นตอนจริงของร้าน 
                <div class="ct-faq-a">ทักแชทผ่าน LINE หรือ Facebook พร้อมชื่อสินค้าที่สนใจหรือถ้าพบสินค้าจากที่อื่นสามารถส่งภาพให้เราผลิตได้ ทีมงานจะแจ้งราคาและเงื่อนไขอื่นๆ ให้ทราบ</div>
            </div>

            {{-- <div class="ct-faq-item">
                <div class="ct-faq-q">ใช้เวลาจัดส่งกี่วัน?</div>
                {{-- TODO: ปรับให้ตรงกับระยะเวลาจริง 
                {{-- <div class="ct-faq-a">โดยทั่วไปจัดส่งภายใน 1-3 วันทำการ หลังยืนยันคำสั่งซื้อ</div>
            </div> 

            {{-- <div class="ct-faq-item">
                <div class="ct-faq-q">มีหน้าร้านให้เข้าดูสินค้าจริงไหม?</div>
                TODO: ปรับให้ตรงกับความจริง 
                <div class="ct-faq-a">ปัจจุบัน สามารถสอบถามรายละเอียดสินค้าเพิ่มเติมได้ทาง LINE หรือ Facebook</div>
            </div> 
        </div> --}}

    </div>
@endsection

@section('footer')
@endsection