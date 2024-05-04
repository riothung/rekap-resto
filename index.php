<?php require 'partials/header.php'; 

$sqlBahan = "SELECT * FROM bahan";
$resultBahan = $conn->query($sqlBahan);
$dataBahan = array();
while($row = $resultBahan->fetch_assoc()){
    // Simpan setiap baris ke dalam array $dataBahan
    $dataBahan[] = $row;
} 

$totalBahan = 0; // Inisialisasi total stok
foreach ($dataBahan as $bahan) {
    // Tambahkan nilai stok dari setiap baris ke total$totalBahan
    $totalBahan += $bahan['stok'];
}

$sqlMakanan = "SELECT * FROM menu";
$resultMakanan = $conn->query($sqlMakanan);
$dataMakanan = array();
while($row = $resultMakanan->fetch_assoc()){
    $dataMakanan[] = $row;
}

$sqlMinuman = "SELECT * FROM minuman";
$resultMinuman = $conn->query($sqlMinuman);
$dataMinuman = array();
while($row = $resultMinuman->fetch_assoc()){
    $dataMinuman[] = $row;
}

// $totalMakanan = 0; 
// foreach($dataMakanan as $makanan){
    //     $totalMakanan = $makanan['nama_menu'];
    // }
    
    $id = isset($_GET['id']) ? $_GET['id'] : $dataMakanan[0]['id'];
    $id = isset($_GET['id']) ? $_GET['id'] : $dataMinuman[0]['id'];
// $row['stok'] = $stok;

// $id = isset($_GET['id']) ? $_GET['id'] : $totalBahan[0]['id'];

?>

        <!-- <div class="col-lg-12">
          <div class="row">
          <?php if(isset($_SESSION['success-alert'])):?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            <?= $_SESSION['success-alert']; unset($_SESSION['success-alert'])?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif;?>
          <?php if(isset($_SESSION['failed-alert'])):?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            <?= $_SESSION['failed-alert']; unset($_SESSION['failed-alert'])?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif;?> -->

          <!-- card penjualan -->
<div class="row">
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Total Bahan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalBahan ?></div>
                  </div>
                  <!-- <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div> -->
              </div>
          </div>
      </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Makanan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($dataMakanan) ?></div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Total Minuman</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($dataMinuman) ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
          
          <!-- card penjualan end -->
          
          <!-- cart start -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Area Chart</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>


<?php require 'partials/footer.php'; ?>
   

