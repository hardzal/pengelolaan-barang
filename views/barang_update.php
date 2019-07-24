<?php
if (isset($_POST['id_barang'])) {
    require_once 'models/barang_model.php';

    $barang = new Barang($db);

    $id_barang = $db->connect->real_escape_string($_POST['id_barang']);
    $nama_barang = $db->connect->real_escape_string($_POST['nama_barang']);
    $harga_barang = $db->connect->real_escape_string($_POST['harga_barang']);
    $stok_barang = $db->connect->real_escape_string($_POST['stok_barang']);

    $data = json_decode($barang->edit($id_barang), true);

    if ($_FILES['gambar_barang']['name'] != '') {

        unlink("assets/img/barang/" . $data['gambar_barang']);

        $ekstension = explode(".", $_FILES['gambar_barang']['name']);

        $gambar_barang = "barang-" . round(microtime(true)) . "." . end($ekstension);
        $source = $_FILES['gambar_barang']['tmp_name'];
        $upload = move_uploaded_file($source, "assets/img/barang/" . $gambar_barang);
    } else {
        $gambar_barang = $data['gambar_barang'];
    }

    $data = [
        "id_barang" => $id_barang,
        "nama_barang" => $nama_barang,
        "harga_barang" => $harga_barang,
        "stok_barang" => $stok_barang,
        "gambar_barang" => $gambar_barang
    ];

    $result = $barang->update($data);

    if ($result) {
        header('Location: index.php?page=barang');
    } else {
        echo "<script>alert('Error!');</script>";
    }
}
