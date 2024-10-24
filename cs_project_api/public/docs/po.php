<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
            height: auto;
        }

        .header .title {
            text-align: right;
            font-weight: bold;
            margin-left: auto;
        }

        .header .title h2 {
            margin: 0;
        }

        .header .pink-box {
            background-color: pink;
            padding: 5px;
            font-weight: bold;
            text-align: right;
            width: 250px;
        }

        .content {
            margin-top: 10px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content td {
            padding: 5px;
        }

        .content td {
            vertical-align: top;
        }

        .content .bold {
            font-weight: bold;
        }

        .content .center {
            text-align: center;
        }

        /* Styling Tabel */
        table.no-border td,
        table.no-border th {
            border: none;
        }

        /* Styling Garis */
        hr {
            border: none;
            border-top: 1px solid black;
        }

        .black-line {
            border-bottom: 2px solid black;
            margin: 20px 0;
        }

        /* Pink Background */
        .pink-line {
            background-color: pink;
            height: 10px;
            width: 100%;
            margin: 10px 0;
        }

        .pink-background {
            background-color: pink;
            padding: 5px;
        }

        /* Styling untuk Total Budget dan Monthly */
        .total-section {
            margin-top: 20px;
            text-align: left;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .total-row .label {
            width: 50%;
            text-align: left;
        }

        .total-row .value {
            width: 50%;
            text-align: center;
            font-weight: bold;
        }

        .note {
            font-size: 10px;
            margin-top: 20px;
        }

        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
        }

        .signatures div {
            text-align: center;
            width: 30%;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.png" alt="Logo">
            <div class="title">
                <h2>PENAWARAN HARGA</h2>
                <div class="pink-box">Scentde - launching support & social media 1</div>
            </div>
        </div>

        <div class="content">
            <table class="no-border">
                <tr>
                    <td><span class="bold">Company</span></td>
                    <td>: PT. Scentde Parfum Indonesia</td>
                </tr>
                <tr>
                    <td><span class="bold">Person In Charge</span></td>
                    <td>: Willsen Colin</td>
                </tr>
                <tr>
                    <td><span class="bold">Address</span></td>
                    <td>: Jl. Petita No 5a RT6/RW11 Kemang Cilandak Barat - Jakarta Selatan Jakarta 12430</td>
                </tr>
                <tr>
                    <td><span class="bold">Project/Produk</span></td>
                    <td>: Scentde Parfum</td>
                </tr>
                <tr>
                    <td><span class="bold">Job</span></td>
                    <td>: Scentde - launching support & social media 1</td>
                </tr>
                <tr>
                    <td><span class="bold">No Pesanan</span></td>
                    <td>: EX/084/III/2024/CS</td>
                </tr>
            </table>

            <hr> <!-- Garis hitam panjang sebagai pembatas -->

            <!-- Bagian ini tanpa garis tabel -->
            <table class="no-border">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hal</th>
                        <th>Total</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="center">1</td>
                        <td>Strategic Campaign 4 months</td>
                        <td class="center">package</td>
                        <td>Not included, strategic support by brand</td>
                    </tr>
                    <tr>
                        <td class="center">2</td>
                        <td>ATL Launching Support</td>
                        <td class="center">-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="center">a</td>
                        <td>Master Key Visual</td>
                        <td>Rp. 12,653,081</td>
                        <td>Master design product, master design talent</td>
                    </tr>
                    <tr>
                        <td class="center">b</td>
                        <td>Derivative KV</td>
                        <td>Rp. 8,571,429</td>
                        <td>Design applied from master design, resized for colored art</td>
                    </tr>
                    <tr>
                        <td class="center">c</td>
                        <td>Video Digital (Emotional)</td>
                        <td>Rp. 12,750,000</td>
                        <td>1 idea video digital launching, cut down</td>
                    </tr>
                    <tr>
                        <td class="center">d</td>
                        <td>PR Package</td>
                        <td>Rp. 6,826,531</td>
                        <td>PR package for KOL</td>
                    </tr>
                </tbody>
            </table>

            <hr> <!-- Garis hitam panjang sebagai pembatas -->

            <div class="total-section">
                <div class="total-row">
                    <div class="label">Total Budget:</div>
                    <div class="value">Rp. 115,393,678</div>
                </div>
                <div class="total-row pink-background">
                    <div class="label">Monthly:</div>
                    <div class="value">Rp. 38,464,626</div>
                </div>
            </div>

            <div class="note">
                Terbilang: Seratus lima belas juta tiga ratus sembilan puluh tiga ribu enam ratus tujuh puluh delapan rupiah<br>
                Belum Termasuk PPN 11%<br>
                <br>
                Pekerjaan akan dilakukan oleh CS setelah ada pembayaran DP minimal 50% dari Brand.<br>
                Bila disetujui, mohon approval dari quotation ini di email, dan dikirimkan kembali ke CS.<br>
                PO/PP segera dikeluarkan langsung setelah quotation diapprove.
            </div>

            <div class="signatures">
                <div>
                    <p>Lafiana</p>
                    <p>Account Executive</p>
                </div>
                <div>
                    <p>Obbi Putra Gautama</p>
                    <p>Account Manager</p>
                </div>
                <div>
                    <p>Agus Isriyanto</p>
                    <p>Finance Manager</p>
                </div>
            </div>

            <hr> <!-- Garis hitam panjang terakhir -->

            <div class="signatures">
                <p>Tanggal: [tanggal]</p>
                <p>Disetujui oleh:</p>
                <p>KLIEN</p>
            </div>
        </div>
    </div>
</body>
</html>
