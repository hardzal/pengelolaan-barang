<script src="assets/js/highcharts/highcharts.js"></script>
<script src="assets/js/highcharts/exporting.js"></script>
<?php
require_once './models/barang_model.php';

$barang = new Barang($db);
$data_barang = $barang->tampil();

$nama_barang = array();
$stok_barang = array();

while ($row = $data_barang->fetch_assoc()) {
    $nama_barang[] = $row['nama_barang'];
    $stok_barang[] = intval($row['stok_barang']);
}

?>
<div class="row">
    <div class="col-md-12">
        <h1>Dashboard <small>Admin</small></h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Dashboard</a>
            </li>
            <!-- <li class="breadcrumb-item active">Index</li> -->
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Page Content -->

        <div id="data-barang" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    </div>
</div>

<script type='text/javascript'>
    Highcharts.chart('data-barang', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Data Nama dan Jumlah Stok Barang'
        },
        subtitle: {
            text: 'Database'
        },
        xAxis: {
            categories: <?= json_encode($nama_barang); ?>,
            tickmarkPlacement: 'on',
            title: {
                enabled: false
            }
        },
        yAxis: {
            title: {
                text: 'Jumlah satuan'
            },
            labels: {
                formatter: function() {
                    return this.value;
                }
            }
        },
        tooltip: {
            split: false,
            valueSuffix: ''
        },
        plotOptions: {
            area: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        series: [{
            name: 'Jumlah stok',
            data: <?= json_encode($stok_barang); ?>
        }]
    });
</script>