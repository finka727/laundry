<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
//mengambil data detail penjual dan penjualan
$queryDetail = mysqli_query($koneksi, "SELECT data_transaksi.id, paket.nama_paket, paket.harga, transaksi_detail.* FROM transaksi_detail LEFT JOIN data_transaksi ON data_transaksi.id = transaksi_detail.id_order LEFT JOIN paket ON paket.id = transaksi_detail.id_paket WHERE transaksi_detail.id_order='$id'");
$row = [];
while ($rowDetail = mysqli_fetch_assoc($queryDetail)) {
    $row[] = $rowDetail;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi : </title>
    <style>
        body {
            margin: 20px;
        }

        .struk {
            width: 80mm;
            max-width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
        }

        .struk-header,
        .struk-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struk-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .struk-body {
            margin-bottom: 10px;
        }

        .struk-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struk-body table th,
        .struk-body table td {
            padding: 5px;
            text-align: left;
        }

        .struk-body table th {
            border-bottom: 1px solid #000;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-evenly;
            padding: 5px 0;
            font-weight: bold;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .struk {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struk-header h1,
            .struk-footer {
                font-size: 14px;
            }

            .struk-body table th,
            .struk-body table td {
                padding: 2px;
            }

            .total,
            .payment,
            .change {
                padding: 2px 0;
            }
        }
    </style>
</head>

<body>

    <div class="struk">
        <div class="struk-header">
            <h1>f3 CAMIN OFFICIAL</h1>
            <p>Kayu Putih, Pulogadung Jakarta timur</p>
            <p>081113245673</p>
        </div>
        <div class="struk-body">
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row as $key => $rowDetail): ?>
                        <tr>
                            <td><?php echo $rowDetail['nama_paket'] ?></td>
                            <td><?php echo $rowDetail['qty'] ?></td>
                            <td><?php echo "Rp. " . number_format($rowDetail['harga']) ?></td>
                            <td><?php echo "Rp. " . number_format($rowDetail['subtotal']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <!-- <div class="total">
                <span>Total : </span>
                <span><?php echo "Rp." . number_format($row[0]['total_harga']) ?></span>
            </div>
            <div class="payment">
                <span>Bayar :</span>
                <span><?php echo "Rp." . number_format($row[0]['nominal_bayar']) ?></span>
            </div>
            <div class="change">
                <span>Kembali :</span>
                <span><?php echo "Rp." . number_format($row[0]['kembalian']) ?></span>
            </div> -->
        </div>
        <div class="struk-footer">
            <p>Terima Kasih Atas Kunjungan anda</p>
            <p>Selamat Berbelanja Kembali!</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>