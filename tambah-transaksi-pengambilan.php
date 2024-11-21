<?php
session_start();
include 'koneksi.php';
$dataCustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id DESC");
$id = isset($_GET['ambil']) ? $_GET['ambil'] : '';
$queryDetailTransaksi = mysqli_query($koneksi, "SELECT customer.nama_customer, customer.phone, customer.address, data_transaksi.kode_order, data_transaksi.tanggal_order, data_transaksi.status_order, data_transaksi.id_customer, paket.nama_paket, paket.harga, transaksi_detail.* FROM transaksi_detail LEFT JOIN paket ON paket.id = transaksi_detail.id_paket LEFT JOIN data_transaksi ON data_transaksi.id = transaksi_detail.id_order LEFT JOIN customer ON data_transaksi.id_customer = customer.id WHERE transaksi_detail.id_order='$id'");
$row = [];
while ($data = mysqli_fetch_assoc($queryDetailTransaksi)) {
    $row[] = $data;
}

$dataPaket = mysqli_query($koneksi, "SELECT * FROM paket ORDER BY id DESC");
$rowPaket = [];
while ($data = mysqli_fetch_assoc($dataPaket)) {
    $rowPaket[] = $data;
}

$queryTransaksiPengambilan = mysqli_query($koneksi, "SELECT * FROM transaksi_pengambilan WHERE id_order='$id'");
// jika button simpan ditekan
if (isset($_POST['simpan_transaksi'])) {
    $id_customer = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_pay = $_POST['pickup_pay'];
    $pickup_change = $_POST['pickup_change'];

    $pickup_date = date("Y-m-d");

    // insert ke table transaksi pengembalian 
    $insert = mysqli_query($koneksi, "INSERT INTO transaksi_pengambilan (id_customer, id_order, pickup_pay, pickup_change, pickup_date) VALUES ('$id_customer','$id_order','$pickup_pay','$pickup_change','$pickup_date')");

    // ubah status order jadi 1 / sudah diambil
    $updateDataTransaksi = mysqli_query($koneksi, "UPDATE data_transaksi SET status_order =1 WHERE id ='$id_order'");

    header("location:data-transaksi.php?pickup=berhasil");
}

// no invoice code
// 001, jika ada auto increment id + 1 = 002, selain itu 001
// MAX : terbesar MIN: terkecil
$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS kode_order FROM data_transaksi");
// jika di dalam table data transaksi ada datanya
$str_unique = "INV";
$date_now = date("dmY");
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['kode_order'] + 1;
    $code = $str_unique . "" . $date_now . "" . "000" . $incrementPlus;
} else {
    $code = $str_unique . "" . $date_now . "" . "0001";
}


?>
<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <?php include 'inc/head.php' ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include 'inc/sidebar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'inc/nav.php' ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['ambil'])): ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Pengambilan Laundry <?php echo $row[0]['nama_customer'] ?></h5>
                                                </div>
                                                <div class="col-sm-6" align="right">
                                                    <a href="data-transaksi.php" class="btn btn-secondary">Kembali</a>
                                                    <a href="print.php?id=<?php echo $id ?>" class="btn btn-success">Print</a>
                                                    <a href="" class="btn btn-warning">Ambil Cucian</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Transaksi</h5>
                                        </div>
                                        <?php include 'helper.php' ?>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Kode Order</th>
                                                    <td><?php echo $row[0]['kode_order'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Order</th>
                                                    <td><?php echo $row[0]['tanggal_order'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo changeStatus($row[0]['status_order']) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Customer</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?php echo $row[0]['nama_customer'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No.Telp</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['address'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Paket</th>
                                                            <th>Qty</th>
                                                            <th>Harga</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        $total = 0;
                                                        foreach ($row as $key => $value): ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $value['nama_paket'] ?></td>
                                                                <td><?php echo $value['qty'] ?></td>
                                                                <td><?php echo $value['harga'] ?></td>
                                                                <td><?php echo $value['subtotal'] ?></td>
                                                            </tr>
                                                            <?php
                                                            $total += $value['subtotal'];
                                                            ?>
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center">
                                                                <strong>Total Keseluruhan</strong>
                                                            </td>
                                                            <td>
                                                                <strong><?php echo "Rp" . number_format($total) ?></strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-center">
                                                                <strong>Dibayar</strong>
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    <?php if (mysqli_num_rows($queryTransaksiPengambilan)): ?>
                                                                        <?php $rowTransaksiPengambilan = mysqli_fetch_assoc($queryTransaksiPengambilan); ?>
                                                                        <input type="text" name="pickup_pay" placeholder="Dibayar" class="form-control" value="<?php echo number_format($rowTransaksiPengambilan['pickup_pay']) ?>" readonly>
                                                                    <?php else: ?>
                                                                        <input type="number" name="pickup_pay" placeholder="Dibayar" class="form-control" value="<?php echo isset($_POST['pickup_pay']) ? $_POST['pickup_pay'] : '' ?>">
                                                                    <?php endif ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-center">
                                                                <strong>Kembalian</strong>
                                                            </td>
                                                            <?php
                                                            if (isset($_POST['proses_kembalian'])) {
                                                                $total = $_POST['total'];
                                                                $dibayar = $_POST['pickup_pay'];

                                                                $kembalian = 0;
                                                                $kembalian = $dibayar - $total;
                                                            }
                                                            ?>
                                                            <td>
                                                                <input type="hidden" name="total" value="<?php echo $total ?>">
                                                                <input type="hidden" name="id_customer" value="<?php echo $row[0]['id_customer'] ?>">
                                                                <input type="hidden" name="id_order" value="<?php echo $row[0]['id_order'] ?>">
                                                                <strong>
                                                                    <?php if (mysqli_num_rows($queryTransaksiPengambilan) > 0): ?>
                                                                        <input type="text" name="" placeholder="Kembalian" class="form-control" value="<?php echo number_format($rowTransaksiPengambilan['pickup_change']) ?>" readonly>
                                                                    <?php else: ?>
                                                                        <input type="text" name="pickup_change" placeholder="Kembalian" class="form-control" value="<?php echo isset($kembalian) ? $kembalian : 0 ?>" readonly>
                                                                    <?php endif ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <?php if ($row[0]['status_order'] == 0): ?>
                                                            <tr>
                                                                <td colspan="5">
                                                                    <button class="btn btn-primary" name="proses_kembalian">Proses Kembalian</button>
                                                                    <button class="btn btn-success" name="simpan_transaksi">Simpan Transaksi</button>
                                                                </td>
                                                            </tr>
                                                        <?php endif ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">Data berhasil dihapus</div>
                                                <?php endif ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Nama Customer</label>
                                                        <select name="id_customer" id="" class="form-control">
                                                            <option value="">pilih customer</option>
                                                            <?php while ($resultCustomer = mysqli_fetch_assoc($dataCustomer)) : ?>
                                                                <option value="<?= $resultCustomer['id'] ?>">
                                                                    <?= $resultCustomer['nama_customer'] ?>
                                                                </option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Kode Order</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="kode_order"
                                                            value="#<?php echo $code ?>"
                                                            readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Tanggal Order</label>
                                                        <input type="date"
                                                            class="form-control"
                                                            name="tanggal_order"
                                                            placeholder=""
                                                            value="<?php echo isset($_GET['edit']) ? $rowDataTransaksi['tanggal_order'] : '' ?>"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">Detail Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">Data berhasil dihapus</div>
                                                <?php endif ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Paket</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select class="form-control" name="id_paket[]" id="">
                                                            <option value="">--pilih paket--</option>
                                                            <?php foreach ($rowPaket as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Qty</label>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="number" name="qty[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Paket</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select class="form-control" name="id_paket[]" id="">
                                                            <option value="">--pilih paket--</option>
                                                            <?php foreach ($rowPaket as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Qty</label>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="number" name="qty[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php endif ?>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by
                                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                            </div>
                            <div>
                                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                                <a
                                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                                    target="_blank"
                                    class="footer-link me-4">Documentation</a>

                                <a
                                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                                    target="_blank"
                                    class="footer-link me-4">Support</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/assets/vendor/js/bootstrap.js"></script>
    <script src="assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>