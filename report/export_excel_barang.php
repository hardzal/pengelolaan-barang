<?php
require_once '../config/koneksi.php';
require_once '../models/database.php';
require_once '../models/barang_model.php';

$connection = new Database($dbHost, $username, $password, $dbName);
$barang = new Barang($connection);

$fileName = "excel_barang-" . date('d-m-Y') . ").xls";

header("Content-Disposition: attachment; filename=" . $fileName);
header("Content-Type: application/vnd.ms-excel");
?>
<h4 align='center'>Data Barang per <?= date('H:i:s d-m-Y'); ?></h4>
<table border="1px">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Stok Barang</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $total_harga = 0;
        $tampil = $barang->tampil();
        while ($data = $tampil->fetch_object()) :
            $total_harga += $data->harga_barang;
            ?>
            <tr>
                <td align='center'><?= $no++; ?></td>
                <td align='center'><?= $data->nama_barang; ?></td>
                <td align='center'><?= "Rp " . number_format($data->harga_barang, 0, ',', '.'); ?></td>
                <td align='center'><?= $data->stok_barang; ?></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan='3' align='center'>Total Barang</td>
            <td align='center'><?= $tampil->num_rows; ?></td>
        </tr>
        <tr>
            <td colspan='3' align='center'>Total Harga</td>
            <td>Rp <?= number_format($total_harga, 0, ',', '.'); ?></td>
        </tr>
    </tbody>
</table>