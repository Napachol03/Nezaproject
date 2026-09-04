<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ใบเสนอราคา {{ $quotation->quotation_no }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 20mm 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Angsana New', 'TH Sarabun New', Tahoma, sans-serif;
            font-size: 16px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* ===== แถบเครื่องมือด้านบน (สไตล์ PDF viewer toolbar) ===== */
        .toolbar-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 48px;
            background: #1a1a1a;
            color: #e8e8e8;
            display: flex;
            align-items: center;
            padding: 0 16px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
        }

        .toolbar-bar .toolbar-divider {
            width: 1px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            margin: 0 12px;
        }

        .toolbar-bar button,
        .toolbar-bar a {
            background: transparent;
            border: none;
            color: #e8e8e8;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .toolbar-bar button:hover,
        .toolbar-bar a:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .toolbar-bar .toolbar-title {
            margin-left: auto;
            font-size: 13.5px;
            color: #aaa;
        }

        /* เว้นพื้นที่ด้านบนไม่ให้เนื้อหาโดนแถบ toolbar บัง (เฉพาะตอนดูในเบราว์เซอร์) */
        .sheet-offset {
            padding-top: 68px;
        }

        .sheet {
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            position: relative;
            min-height: 1050px;
            /* ใกล้เคียงความสูง A4 บนหน้าจอ เพื่อให้พรีวิวเห็นตำแหน่งจริง */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header .logo-box {
            width: 90px;
            text-align: center;
            font-size: 10px;
            padding: 4px;
        }

        .header .logo-box .logo-img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .header .company-info {
            flex: 1;
            padding-left: 15px;
            font-size: 15px;
            line-height: 1.5;
        }

        .company-info h2 {
            margin: 0 0 4px 0;
            font-size: 20px;
        }

        .doc-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0 15px 0;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .meta-table .label {
            width: 70px;
            font-weight: bold;
        }

        .meta-table .doc-no-col {
            text-align: right;
            width: 220px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 15px;
        }

        table.items th,
        table.items td {
            border: 1px solid #000;
            padding: 6px 8px;
        }

        table.items thead th {
            text-align: center;
            background: #f0f0f0;
        }

        table.items td.no {
            text-align: center;
            width: 5%;
        }

        table.items td.qty {
            text-align: center;
            width: 8%;
        }

        table.items td.unit {
            text-align: center;
            width: 8%;
        }

        table.items td.price,
        table.items td.amount {
            text-align: right;
            width: 13%;
        }

        table.items td.desc {
            font-size: 13px;
            color: #333;
        }

        .totals {
            width: 100%;
            margin-top: 5px;
        }

        .totals table {
            margin-left: auto;
            width: 320px;
            border-collapse: collapse;
            font-size: 16px;
        }

        .totals td {
            padding: 4px 8px;
        }

        .totals td.amount {
            text-align: right;
        }

        .totals tr.grand-total td {
            border-top: 2px solid #000;
            font-weight: bold;
            font-size: 17px;
        }

        .bottom-section {
            position: absolute;
            left: 10px;
            right: 10px;
            bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .conditions {
            margin-top: 0;
            font-size: 15px;
            line-height: 1.6;
            max-width: 55%;
        }

        .signature {
            margin-top: 0;
            text-align: right;
        }

        .signature .sign-line {
            display: inline-block;
            width: 260px;
            border-top: 1px solid #000;
            padding-top: 6px;
            text-align: center;
        }

        @media print {
            .toolbar-bar {
                display: none;
            }

            .sheet-offset {
                padding-top: 0;
            }

            .sheet {
                min-height: 0;
                height: 257mm;
                /* A4 297mm หัก margin บน-ล่าง 20mm+20mm */
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="toolbar-bar">
        <a href="{{ url()->previous() }}">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="toolbar-divider"></div>

        <button type="button" onclick="window.print()" title="พิมพ์ใบเสนอราคา">
            <i class="fas fa-print"></i>
            <span>พิมพ์ใบเสนอราคา</span>
        </button>

        <span class="toolbar-title">ใบเสนอราคาเลขที่ {{ $quotation->quotation_no }}</span>
    </div>

    <div class="sheet-offset">
        <div class="sheet">

            <div class="header">
                <div class="logo-box"><img src="{{ asset('storage/uploads/image/logo.png') }}" class="logo-img"
                        alt="โลโก้บริษัท"></div>
                <div class="company-info">
                    <h2>บริษัท แมททีเรียล คอลเลคชั่น จำกัด</h2>
                    Materials Collection Co., Ltd.<br>
                    9 ซอยพระยามนธาตุฯ แยก 35-10 แขวงคลองบางบอน เขตบางบอน กรุงเทพฯ 10150<br>
                    Tel. 08 1696 8262, 08 6317 9475 (Line) &nbsp;&nbsp; Tax ID : 0 1055 47029 12 1
                </div>
            </div>

            <div class="doc-title">ใบเสนอราคา</div>

            <table class="meta-table">
                <tr>
                    <td class="label">เรียน</td>
                    <td>{{ $quotation->customer->customer_name ?? '-' }}</td>
                    <td class="doc-no-col" rowspan="3">
                        เลขที่ &nbsp; {{ $quotation->quotation_no }}<br>
                        วันที่ &nbsp;
                        {{ $quotation->quotation_date ? \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">เรื่อง</td>
                    <td>{{ $quotation->subject }}</td>
                </tr>
            </table>

            <table class="items">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>จำนวน</th>
                        <th>หน่วย</th>
                        <th>รายการสินค้า</th>
                        <th>ราคา/หน่วย</th>
                        <th>จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->details as $detail)
                        <tr>
                            <td class="no">{{ $loop->iteration }}</td>
                            <td class="qty">{{ number_format($detail->quantity, 0) }}</td>
                            <td class="unit">{{ $detail->unit }}</td>
                            <td>
                                {{ $detail->product->product_name ?? '-' }}
                                @if ($detail->description)
                                    <br><span class="desc">- {{ $detail->description }}</span>
                                @endif
                            </td>
                            <td class="price">{{ number_format($detail->unit_price, 2) }}</td>
                            <td class="amount">{{ number_format($detail->amount, 2) }}</td>
                        </tr>
                    @endforeach

                    @for ($i = 0; $i < max(0, 1 - count($quotation->details)); $i++)
                        <tr>
                            <td class="no">&nbsp;</td>
                            <td class="qty"></td>
                            <td class="unit"></td>
                            <td></td>
                            <td class="price"></td>
                            <td class="amount"></td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="totals">
                <table>
                    <tr>
                        <td>รวมเงินค่าสินค้า</td>
                        <td class="amount">{{ number_format($quotation->subtotal_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>ภาษีมูลค่าเพิ่ม {{ rtrim(rtrim(number_format($quotation->vat_rate, 2), '0'), '.') }}%</td>
                        <td class="amount">{{ number_format($quotation->vat_amount, 2) }}</td>
                    </tr>
                    <tr class="grand-total">
                        <td>รวมเงินทั้งสิ้น</td>
                        <td class="amount">{{ number_format($quotation->total_amount, 2) }}</td>
                    </tr>
                </table>
            </div>

            <div class="bottom-section">
                <div class="conditions">
                    กำหนดยืนราคา {{ $quotation->price_validity_days }} วัน<br>
                    เงื่อนไขการชำระเงิน : {{ $quotation->payment_terms }}<br>
                    ขอขอบพระคุณท่านที่ให้เกียรติพิจารณาสินค้าของบริษัท
                </div>

                <div class="signature">
                    <div class="sign-line">
                        ({{ $quotation->admin->name ?? '.......................................' }})<br>
                        ผู้จัดการ
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('back-btn').addEventListener('click', function(e) {
            // ถ้ามีหน้าก่อนหน้าใน history ของแท็บนี้ ให้ย้อนกลับไปหน้านั้นจริงๆ
            // (เช่น มาจากหน้า list หรือหน้าแก้ไข ก็จะกลับไปหน้านั้น ไม่ใช่ hardcode ไปหน้าแก้ไขเสมอ)
            if (window.history.length > 1) {
                e.preventDefault();
                window.history.back();
            }
            // ถ้าไม่มีประวัติหน้าก่อน (เช่น เปิดลิงก์นี้มาโดยตรง หรือเปิดแท็บใหม่)
            // จะปล่อยให้ href เดิมพาไปหน้าแก้ไขใบเสนอราคาแทน
        });
    </script>

</body>

</html>
