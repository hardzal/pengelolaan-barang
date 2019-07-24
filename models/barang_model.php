<?php

class Barang
{
    private $mysqli;

    public function __construct($connect)
    {
        $this->mysqli = $connect;
    }

    public function tampil()
    {
        $db = $this->mysqli->connect;
        $query = "SELECT * FROM barang";

        $query = $db->query($query) or die($db->error);

        return $query;
    }

    public function tambah($data)
    {
        $db = $this->mysqli->connect;
        $query = "INSERT INTO barang(nama_barang, harga_barang, stok_barang, gambar_barang) VALUES(?, ?, ?, ?)";

        $stmt = $db->prepare($query);

        $stmt->bind_param("siis", $data['nama_barang'], $data['harga_barang'], $data['stok_barang'], $data['gambar_barang']);

        $stmt->execute();

        $stmt->close();

        if ($stmt) {
            return true;
        }

        return false;
    }

    public function edit($id)
    {
        $query = "SELECT * FROM barang WHERE id_barang = ?";
        $db = $this->mysqli->connect;
        $stmt = $db->prepare($query);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        $data = $result->fetch_assoc();

        return json_encode($data);
    }

    public function update($data)
    {
        $query = "UPDATE barang SET nama_barang = ?, harga_barang = ?, stok_barang = ?, gambar_barang = ? WHERE id_barang = ?";

        $db = $this->mysqli->connect;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("siisi", $data['nama_barang'], $data['harga_barang'], $data['stok_barang'], $data['gambar_barang'], $data['id_barang']);

            $stmt->execute();
        }
        $stmt->close();

        if ($db->affected_rows) {
            return true;
        }
        return false;
    }

    public function hapus($id)
    {
        $db = $this->mysqli->connect;

        $query = "SELECT * FROM barang WHERE id_barang = $id";
        $sql = $db->prepare($query);
        $sql->execute();
        $data = $sql->get_result();

        $sql->close();

        $result = $data->fetch_assoc();

        unlink("assets/img/barang/" . $result['gambar_barang']);

        $query = "DELETE FROM barang WHERE id_barang = ?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt->close();
        if ($db->affected_rows) {
            return true;
        }
        return false;
    }
}
