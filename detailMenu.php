<?php 

require './partials/header.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('M');

$currentYear = date('Y');

$sql = "SELECT penjualan.tanggal, menu.nama_menu, SUM(detail_penjualan.amount) AS terjual FROM penjualan
LEFT JOIN detail_penjualan ON detail_penjualan.id_penjualan = penjualan.id_penjualan
LEFT JOIN detail_menu ON detail_penjualan.id_menu = detail_menu.id_menu
LEFT JOIN menu ON detail_menu.id_menu = menu.id
LEFT JOIN bahan ON detail_menu.id_bahan = bahan.id
WHERE YEAR(penjualan.tanggal) = '$currentYear' AND MONTH(penjualan.tanggal) = '$bulan'
GROUP BY menu.id";

$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}

$conn->close();

?>

<!-- Alert -->
<?php if(isset($_SESSION['success-alert'])):?> 
        <div class="alert alert-success alert-dismissible fade show mt-2 w-50" role="alert">
        <i class="fa fa-check-circle me-1"></i>
        <?= $_SESSION['success-alert']; unset($_SESSION['success-alert'])?>
        <button type="button" class="btn btn-seconday" data-dismiss="alert" aria-label="Close" style="border-radius: 6px;">X</button>
        </div>
        <?php endif;?>
        <?php if(isset($_SESSION['failed-alert'])):?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-octagon me-1"></i>
        <?= $_SESSION['failed-alert']; unset($_SESSION['failed-alert'])?>
        <button type="button" class="btn btn-seconday" data-dismiss="alert" aria-label="Close" style="border-radius: 6px;">X</button>
        </div>
        <?php endif;?>
<!-- End Alert -->

<div class="mb-3">
    <select class="rounded" name="bulanFilter" id="bulanFilter">
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maret</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
        <option value="6">Juni</option>
        <option value="7">Juli</option>
        <option value="8">Agustus</option>
        <option value="9">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>
    </select>
    <button class="btn btn-danger" onclick="applyFilter()">Pilih Bulan</button>
</div>

<div class="card shadow mb-4">
            <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-danger">Menu Terjual</h4>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>Nama Menu</th>
                    <th>terjual</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Nama Menu</th>
                    <th>terjual</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach($data as $key => $row): ?>
                    <tr>
                    <td><?= $row['nama_menu']; ?></td>
                    <td><?= $row['terjual']; ?> Porsi</td>
                    </tr>
                        
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>
            </div>
        </div>

            <script>
                var urlParams = new URLSearchParams(window.location.search);
                var bulan = urlParams.get('bulan');

                if(bulan){
                    document.getElementById('bulanFilter').value = bulan
                }

                function applyFilter(){
                    bulan = document.getElementById('bulanFilter').value
                    history.pushState({}, '', window.location.pathname + '?bulan=' + bulan)
                    location.reload()
                }
            </script>


<?php require 'partials/footer.php'; ?>