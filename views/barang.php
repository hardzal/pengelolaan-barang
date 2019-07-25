<?php
require "models/barang_model.php";
$barang = new Barang($db);
?>
<div class="row">
    <div class="col-md-12">
        <h1>Data Barang</h1>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-dashboard"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="index.php">Barang</a>
            </li>
            <li class="breadcrumb-item active">Data Barang</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <a class='btn btn-info mb-3' id="tambahBarang" data-toggle="modal" data-target="#modalBarang" style='color:white;cursor:pointer;'><i class='fas fa-plus'></i> Tambah Data</a>
        <a href='./report/export_excel_barang.php' class='btn btn-primary mb-3' id="exportExcel" style='color:white;'><i class='fas fa-print'></i> Export Excel</a>
        <a href='#' class='btn btn-success mb-3' id="exportPdf" data-toggle="modal" data-target="#modalExport" style='color:white;' target="_blank"><i class='fas fa-print'></i> Export PDF</a>
        <!-- Page Content -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id="tabelBarang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama barang</th>
                        <th>Harga barang</th>
                        <th>Stok barang</th>
                        <th>Created At</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $tampil = $barang->tampil();
                    while ($data = $tampil->fetch_object()) :
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td width='150'><?= $data->nama_barang; ?></td>
                            <td>Rp <?= number_format($data->harga_barang, 0, ',', '.') ?></td>
                            <td><?= $data->stok_barang; ?></td>
                            <td><?= $data->created_at; ?></td>
                            <td><img src='assets/img/barang/<?= $data->gambar_barang; ?>' alt='<?= $data->nama_barang; ?>' width='80' /></td>
                            <td>
                                <a href="#" class='editBarang btn btn-info btn-sm' data-toggle='modal' data-target='#modalBarang' data-id='<?= $data->id_barang; ?>'><i class='fas fa-edit'></i> Edit</a>
                                <a href="?page=barang_hapus&id=<?= $data->id_barang; ?>" class='btn btn-danger btn-sm' id="hapusBarang" onclick='return confirm("Apakah kamu yakin ingin menghapus?");'><i class='fas fa-trash'></i> Hapus</a>
                                <a href="./report/export_pdf_barang.php?id=<?= $data->id_barang; ?>" class='exportBarang btn btn-secondary btn-sm' target="_blank"><i class='fas fa-print'></i> Cetak</a>
                            </td>
                        </tr>
                        <?php
                        $no = $no + 1;
                    endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="modalBarang" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Tambah Data</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="formBarang" method="POST" action="" enctype="multipart/form-data">
                        <input type='hidden' name='id_barang' id='id_barang' />
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_barang" class="control-label">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="harga_barang" class="control-label">Harga Barang</label>
                                <input type="number" id="harga_barang" name="harga_barang" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="stok_barang">Stok Barang</label>
                                <input type="number" class="form-control" id="stok_barang" name="stok_barang" min=0 required />
                            </div>

                            <div class="form-group">
                                <label for="gambar_barang">Gambar Barang</label>
                                <div class="gambar_barang">
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="gambar_barang" />
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                            <?php
                            if (isset($_POST['submit'])) :
                                $nama_barang = $db->connect->real_escape_string($_POST['nama_barang']);
                                $harga_barang = $db->connect->real_escape_string($_POST['harga_barang']);
                                $stok_barang = $db->connect->real_escape_string($_POST['stok_barang']);

                                $ekstension = explode(".", $_FILES['gambar_barang']['name']);

                                $gambar_barang = "barang-" . round(microtime(true)) . "." . end($ekstension);
                                $source = $_FILES['gambar_barang']['tmp_name'];
                                $upload = move_uploaded_file($source, "assets/img/barang/" . $gambar_barang);
                                $created_at = date('Y-m-d', time());

                                $data = [
                                    "nama_barang" => $nama_barang,
                                    "harga_barang" => $harga_barang,
                                    "stok_barang" => $stok_barang,
                                    "gambar_barang" => $gambar_barang,
                                    "created_at" => $created_at
                                ];

                                if ($upload) {
                                    if ($barang->tambah($data)) {
                                        echo "<script>alert('Berhasil menambahkan!');
                                            document.location.href='index.php?page=barang';
                                            </script>";
                                    } else {
                                        echo "<script>alert('Tidak Berhasil menambahkan!');</script>";
                                    }
                                    // header("Location: ?page=barang");
                                } else {
                                    echo "<script>alert('Upload gambar gagal!');</script>";
                                }

                            endif;
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modalExport" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Export Data per Periode</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="formExport" method="POST" action="./report/export_pdf_barang.php" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="start_at">
                                    Start date
                                </label>
                                <input type="date" class="form-control" name="start_at" id="start_at" />
                            </div>
                            <div class="form-group">
                                <label for="end_at">
                                    End date
                                </label>
                                <input type="date" class="form-control" name="end_at" id="end_at" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="./report/export_pdf_barang.php" target="_blank" class="btn btn-primary" name="submit">Cetak seluruhnya</a>
                            <button type="submit" class="btn btn-success" name="submit">Cetak</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>