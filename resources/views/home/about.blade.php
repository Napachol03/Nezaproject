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

        .ab-hero {
            background: linear-gradient(135deg, var(--nexa-mist) 0%, #fff 100%);
            border: 1px solid var(--nexa-line);
            border-radius: 16px;
            padding: 48px 40px;
            margin-bottom: 32px;
            text-align: center;
        }

        .ab-eyebrow {
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

        .ab-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 34px;
            color: var(--nexa-ink);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .ab-subtitle {
            font-size: 16px;
            color: var(--nexa-steel);
            max-width: 620px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .ab-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .ab-card {
            background: #fff;
            border: 1px solid var(--nexa-line);
            border-radius: 12px;
            padding: 28px 24px;
        }

        .ab-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--nexa-mist);
            color: var(--nexa-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .ab-card-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 17px;
            color: var(--nexa-ink);
            margin-bottom: 8px;
        }

        .ab-card-desc {
            font-size: 14px;
            color: var(--nexa-steel);
            line-height: 1.7;
        }

        .ab-section {
            background: #fff;
            border: 1px solid var(--nexa-line);
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 24px;
        }

        .ab-section-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: var(--nexa-ink);
            margin-bottom: 12px;
        }

        .ab-section-desc {
            font-size: 14px;
            color: var(--nexa-steel);
            line-height: 1.8;
            white-space: pre-line;
        }

        /* ---------- Contact ---------- */
        .ab-contact-wrap {
            background: var(--nexa-navy);
            border-radius: 16px;
            padding: 40px;
            margin-bottom: 24px;
        }

        .ab-contact-head {
            text-align: center;
            margin-bottom: 28px;
        }

        .ab-contact-title {
            font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
            font-weight: 600;
            font-size: 22px;
            color: #fff;
            margin-bottom: 6px;
        }

        .ab-contact-desc {
            font-size: 14px;
            color: #C9D6EE;
        }

        .ab-contact-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }

        .ab-contact-item {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 20px 16px;
            text-align: center;
        }

        .ab-contact-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--nexa-sky);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }

        .ab-contact-item-label {
            font-size: 12px;
            color: #A9BADB;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .ab-contact-item-value {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            word-break: break-word;
        }

        .ab-contact-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-fb-custom,
        .btn-line-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            padding: 13px 26px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-fb-custom {
            background: #1877F2;
            color: #fff;
        }

        .btn-fb-custom:hover {
            background: #1461D1;
        }

        .btn-line-custom {
            background: #06C755;
            color: #fff;
        }

        .btn-line-custom:hover {
            background: #05B04B;
        }

        @media (max-width: 767px) {
            .ab-hero {
                padding: 32px 20px;
            }

            .ab-title {
                font-size: 26px;
            }

            .ab-grid {
                grid-template-columns: 1fr;
            }

            .ab-contact-wrap {
                padding: 28px 20px;
            }

            .ab-contact-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endsection
@section('navbar')
@endsection
@section('content')
    <div class="col-12 p-5">

        <div class="ab-hero">
            <span class="ab-eyebrow" style="font-size: 100%">เกี่ยวกับเรา</span>
            <h1 class="ab-title">NEXA SUPPLY PREMIUM</h1>
            <p class="ab-subtitle">
                {{-- TODO: เปลี่ยนข้อความนี้เป็นคำโปรยสั้นๆ เกี่ยวกับร้าน เช่น จำหน่ายสินค้าอะไร เน้นจุดเด่นอะไร --}}
                เราคัดสรรสินค้าคุณภาพ พร้อมบริการที่ใส่ใจในทุกรายละเอียด
                เพื่อมอบประสบการณ์ที่ดีที่สุดให้กับลูกค้าทุกท่าน
            </p>
        </div>

        <div class="ab-grid">
            <div class="ab-card">
                <div class="ab-card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                </div>
                <div class="ab-card-title">สินค้าคุณภาพ</div>
                <div class="ab-card-desc">
                    {{-- TODO: อธิบายมาตรฐานสินค้า/แหล่งที่มา --}}
                    คัดสรรทุกชิ้นด้วยมาตรฐานคุณภาพ ตรวจสอบก่อนจัดส่งทุกครั้ง
                </div>
            </div>
            <div class="ab-card">
                <div class="ab-card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M2 12h20" />
                    </svg>
                </div>
                <div class="ab-card-title">ตอบไว ใส่ใจทุกคำถาม</div>
                <div class="ab-card-desc">
                    {{-- TODO: อธิบายช่องทาง/เวลาตอบแชท --}}
                    พร้อมให้คำปรึกษาผ่าน LINE และ Facebook
                </div>
            </div>
            <div class="ab-card">
                <div class="ab-card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18" />
                    </svg>
                </div>
                <div class="ab-card-title">จัดส่งเชื่อถือได้</div>
                <div class="ab-card-desc">
                    {{-- TODO: อธิบายเงื่อนไขการจัดส่ง/พื้นที่จัดส่ง --}}
                    บรรจุภัณฑ์แน่นหนา จัดส่งรวดเร็ว ติดตามสถานะได้
                </div>
            </div>
        </div>

        <div class="ab-section ">
            <div class="ab-section-title text-center">เรื่องราวของเรา</div>
            <div class="ab-section-desc text-center">{{-- TODO: แก้ตัวเลข/รายละเอียดให้ตรงกับร้านจริง ห้ามใส่ข้อมูลที่ไม่เป็นจริง --}}
                ทุกอย่างเริ่มต้นจากความตั้งใจง่ายๆ อย่างหนึ่ง คือการหาสินค้าดีๆ ในราคาที่เข้าถึงได้
                ให้กับคนที่มองหาของแบบเดียวกับที่เราเองก็อยากได้ จากจุดเริ่มต้นเล็กๆ
                วันนี้เราได้รับความไว้วางใจจากลูกค้าหลายท่าน ให้เป็นร้านที่นึกถึงเวลาต้องการสินค้าคุณภาพ
                ด้วยการคัดสรรให้ตรงตามความต้องการของลูกค้า และพร้อมตอบทุกคำถามด้วยความจริงใจ
                เราเชื่อว่าการซื้อของที่ดี ไม่ได้มีแค่สินค้าที่ใช่ แต่ต้องมาพร้อมความไว้ใจได้นี่คือสิ่งที่เรายึดถือ
                และตั้งใจส่งต่อให้ลูกค้าทุกคนในทุกการสั่งซื้อ</div>
        </div>

       

    </div>
@endsection

@section('footer')
@endsection