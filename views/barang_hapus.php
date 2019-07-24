<?php
if (isset($_GET['id'])) {
    require_once 'models/barang_model.php';

    $id_barang = $db->connect->real_escape_string($_GET['id']);

    $barang = new Barang($db);
    $result = $barang->hapus($id_barang);
    if ($result) {
        header('Location: index.php?page=barang');
    } else {
        echo "<script>alert('Error!');</script>";
    }
}
