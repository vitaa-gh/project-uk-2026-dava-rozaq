
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Parkir</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eee;
            margin: 0;
            padding: 20px;
        }

        .struk {
            width: 300px;
            margin: auto;
            padding: 20px;
            background: white;
            color: black;
        }

        h2, p {
            text-align: center;
            margin: 5px 0;
        }

        hr {
            border: none;
            border-top: 1px dashed black;
            margin: 12px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 13px;
        }

        .total {
            font-weight: bold;
            font-size: 16px;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            cursor: pointer;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .struk {
                width: 100%;
                margin: 0;
            }

            button {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="struk">

    <h2>STRUK PARKIR</h2>
    <p>Aplikasi Parkir</p>

    <hr>

    <div class="item">
        <span>No. Transaksi</span>
        <span>{{ $transaksi->id_transaksi }}</span>
    </div>

    <div class="item">
        <span>Plat Nomor</span>
        <span>{{ $transaksi->kendaraan->plat_nomor }}</span>
    </div>

    <div class="item">
        <span>Jenis Kendaraan</span>
        <span>{{ ucfirst($transaksi->tarif->jenis_kendaraan) }}</span>
    </div>

    <div class="item">
        <span>Area Parkir</span>
        <span>{{ $transaksi->areaParkir->nama_area }}</span>
    </div>

    <hr>

    <div class="item">
        <span>Waktu Masuk</span>
        <span>{{ \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('d/m/Y H:i') }}</span>
    </div>

    <div class="item">
        <span>Waktu Keluar</span>
        <span>{{ \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('d/m/Y H:i') }}</span>
    </div>

    <div class="item">
        <span>Durasi</span>
        <span>{{ $transaksi->durasi_jam }} Jam</span>
    </div>

    <div class="item">
        <span>Tarif/Jam</span>
        <span>Rp {{ number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }}</span>
    </div>

    <hr>

    <div class="item total">
        <span>TOTAL BAYAR</span>
        <span>Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</span>
    </div>

    <hr>

    <p>Terima kasih telah menggunakan</p>
    <p>layanan parkir kami.</p>
    <p>Hati-hati di jalan!</p>

</div>

<button onclick="window.print()">CETAK STRUK</button>

</body>
</html>
