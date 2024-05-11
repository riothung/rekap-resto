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

$sqlMakanan = "SELECT * FROM menu WHERE tipe = 0";
$resultMakanan = $conn->query($sqlMakanan);
$dataMakanan = array();
while($row = $resultMakanan->fetch_assoc()){
    $dataMakanan[] = $row;
}

$sqlMinuman = "SELECT * FROM menu WHERE tipe = 1";
$resultMinuman = $conn->query($sqlMinuman);
$dataMinuman = array();
while($row = $resultMinuman->fetch_assoc()){
    $dataMinuman[] = $row;
}

// Lakukan query SQL untuk mengambil jumlah total dari kolom total_harga
$sql_total_penjualan = "SELECT SUM(total_harga) AS total_penjualan FROM penjualan";
$result_total_penjualan = $conn->query($sql_total_penjualan);
// Periksa apakah query berhasil dieksekusi
if ($result_total_penjualan) {
    // Ambil total penjualan dari hasil query
    $row_total_penjualan = $result_total_penjualan->fetch_assoc();
    $total_penjualan = $row_total_penjualan['total_penjualan'];
    $total_penjualan_formatted = number_format($total_penjualan, 0, ',', '.'); 
} else {
    // Jika query gagal, tampilkan pesan kesalahan
    echo "Error: " . $sql_total_penjualan . "<br>" . $conn->error;
}


// Ambil data penjualan dan total harga dari database
$sql_penjualan_total = "SELECT MONTH(tanggal) as bulan, SUM(total_harga) as total_penjualan FROM penjualan GROUP BY bulan";
$result_penjualan_total = $conn->query($sql_penjualan_total);

// Inisialisasi array untuk menyimpan data penjualan dan total harga
$penjualan_total_data = array();

// Periksa apakah query berhasil dieksekusi
if ($result_penjualan_total) {
    // Ambil setiap baris data penjualan dan total harga dan simpan dalam array
    while ($row_penjualan_total = $result_penjualan_total->fetch_assoc()) {
        // Tambahkan data penjualan dan total harga ke dalam array
        $penjualan_total_data[] = array(
            'bulan' => $row_penjualan_total['bulan'],
            'total_penjualan' => $row_penjualan_total['total_penjualan']
        );
    }
} else {
    // Jika query gagal, tampilkan pesan kesalahan
    echo "Error: " . $sql_penjualan_total . "<br>" . $conn->error;
}
// Array yang berisi nama-nama bulan
$bulan = array(
    1 => "Jan", 
    2 => "Feb", 
    3 => "Mar", 
    4 => "Apr", 
    5 => "Mei", 
    6 => "Juni", 
    7 => "Juli", 
    8 => "Agust", 
    9 => "Sept", 
    10 => "Okt", 
    11 => "Nov", 
    12 => "Des"
);

// Mengubah angka bulan menjadi nama bulan menggunakan fungsi date()
$labels = array();
foreach ($penjualan_total_data as $data) {
    $bulanAngka = $data['bulan'];
    $namaBulan = $bulan[$bulanAngka];
    $labels[] = $namaBulan;
}

// Mengonversi array labels menjadi format JSON untuk digunakan dalam chart
$labelsJSON = json_encode($labels);


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
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Total Penghasilan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= $total_penjualan_formatted ?></div>
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
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Total Bahan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalBahan ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
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
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Makanan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($dataMakanan) ?></div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-utensils fa-2x text-gray-300"></i>
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
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($dataMinuman) > 0 ? count($dataMinuman) : 0 ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-mug-hot fa-2x text-gray-300"></i>
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
                <h6 class="m-0 font-weight-bold text-danger">Grafik Penjualan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>


<?php require 'partials/footer.php'; ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script>
function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
    dec = typeof dec_point === 'undefined' ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Data penjualan dan total harga dari PHP diubah menjadi variabel JavaScript
var penjualanTotalData = <?php echo json_encode($penjualan_total_data); ?>;

// Area Chart Example
var ctx = document.getElementById('myAreaChart');
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels:<?php echo $labelsJSON; ?>,
    datasets: [
      {
        label: '',
        lineTension: 0.3,
        backgroundColor: 'rgba(78, 115, 223, 0.05)',
        borderColor: '#e74a3b',
        pointRadius: 3,
        pointBackgroundColor: '#e74a3b',
        pointBorderColor: '#e74a3b',
        pointHoverRadius: 3,
        pointHoverBackgroundColor: '#e74a3b',
        pointHoverBorderColor: '#e74a3b',
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: <?php echo json_encode(array_column($penjualan_total_data, 'total_penjualan')); ?>,
      },
    ],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0,
      },
    },
    scales: {
      xAxes: [
        {
          time: {
            unit: 'date',
          },
          gridLines: {
            display: false,
            drawBorder: false,
          },
          ticks: {
            maxTicksLimit: 7,
          },
        },
      ],
      yAxes: [
        {
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              return 'Rp.' + number_format(value);
            },
          },
          gridLines: {
            color: 'rgb(234, 236, 244)',
            zeroLineColor: 'rgb(234, 236, 244)',
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2],
          },
        },
      ],
    },
    legend: {
      display: false,
    },
    tooltips: {
      backgroundColor: 'rgb(255,255,255)',
      bodyFontColor: '#858796',
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function (tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + 'Rp.' + number_format(tooltipItem.yLabel);
        },
      },
    },
  },
});
</script>