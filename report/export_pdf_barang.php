<?php
require __DIR__ . '/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

require_once '../config/koneksi.php';
require_once '../models/database.php';
require_once '../models/barang_model.php';

$connection = new Database($dbHost, $username, $password, $dbName);
$barang = new Barang($connection);

$content = '
    <style>
        .tabel, .tabel tr {
            max-width: 100%;
        }
        .tabel {
            border-collapse: collapse;
        }
        .tabel th {
            padding: 8px 5px;
            background-color: #f60;
            color: #fff;
        }
    </style>
';

$content .= '
        <page>
            <div style="padding: 4mm; border: 1px solid;" align="center">
                <span>Inventaris Barang</span>
            </div>

            <div style="padding: 20px 0 10px 0; font-size: 15px;">
                Laporan Data Barang
            </div>
            
            <div>
            <table border="1px" class="tabel">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Stok Barang</th>
                    <th>Gambar Barang</th>
                </tr>
        ';

$no = 1;
if (isset($_GET['id'])) {
    $id_barang = $connection->connect->real_escape_string(trim($_GET['id']));
    $data =  json_decode($barang->edit($id_barang), true);

    $content .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . $data['nama_barang'] . '</td>
        <td align="center">Rp ' . number_format($data['harga_barang'], 0, ',', '.') . '</td>
        <td>' . $data['stok_barang'] . '</td>
        <td align="center"><img width="75" src="../assets/img/barang/' . $data['gambar_barang'] . '" title="' . $data['nama_barang'] . '"/></td>
    </tr>';
} else if (isset($_POST['submit'])) {
    $start_at = $connection->connect->real_escape_string(trim($_POST['start_at']));
    $end_at = $connection->connect->real_escape_string(trim($_POST['end_at']));

    $result = $barang->tampil_kapan($start_at, $end_at);

    while ($data = $result->fetch_object()) {
        $content .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $data->nama_barang . '</td>
            <td align="center">Rp ' . number_format($data->harga_barang, 0, ',', '.') . '</td>
            <td>' . $data->stok_barang . '</td>
            <td align="center"><img width="75" src="../assets/img/barang/' . $data->gambar_barang . '" title="' . $data->nama_barang . '"/></td>
        </tr>
    ';
    }
} else {
    $result =  $barang->tampil();

    while ($data = $result->fetch_object()) {
        $content .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $data->nama_barang . '</td>
            <td align="center">Rp ' . number_format($data->harga_barang, 0, ',', '.') . '</td>
            <td>' . $data->stok_barang . '</td>
            <td align="center"><img width="75" src="../assets/img/barang/' . $data->gambar_barang . '" title="' . $data->nama_barang . '"/></td>
        </tr>
    ';
    }
}

$content .= '
            </table>
            </div>
        </page>
    ';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
$html2pdf->output();
