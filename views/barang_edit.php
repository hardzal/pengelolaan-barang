<?php
require_once '../models/barang_model.php';
require_once '../config/koneksi.php';
require_once '../models/database.php';
$db = new Database($dbHost, $username, $password, $dbName);

if (isset($_POST['id_barang']) && !empty($_POST['id_barang'])) {
    $barang = new Barang($db);
    $id_barang = trim($_POST['id_barang']);
    echo $barang->edit($id_barang);
} else {
    echo json_encode(
        array('message' => 'error!')
    );
}
