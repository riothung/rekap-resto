<?php require 'partials/header.php'; 

$id_penjualan = isset($_REQUEST['id_penjualan']) ? $_REQUEST['id_penjualan'] : null;
$id_penjualan_escaped = mysqli_real_escape_string($conn, $id_penjualan);

$id_menu = isset($_REQUEST['id_menu']) ? $_REQUEST['id_menu'] : null;
$id_menu_escaped = mysqli_real_escape_string($conn, $id_menu);

$sql_menu = "SELECT detail_penjualan.*, menu.nama_menu, penjualan.total_harga 
             FROM detail_penjualan 
             JOIN menu ON detail_penjualan.id_menu = menu.id 
             JOIN penjualan ON detail_penjualan.id_penjualan = penjualan.id_penjualan
             WHERE detail_penjualan.id_penjualan = '$id_penjualan'";

$result_menu = $conn->query($sql_menu);
$data = array(); // inisialisasi array kosong untuk menyimpan baris data menu
while ($row = $result_menu->fetch_assoc()) {
    $data[] = $row; // tambahkan setiap baris menu ke dalam array data menu
}

// Periksa apakah ada data menu yang ditemukan
if ($result_menu->num_rows > 0) {
    // data menu ditemukan, lanjutkan dengan menampilkan opsi menu dalam elemen <select>
} else {
    // tidak ada data menu yang ditemukan
    echo "";
}
$sql_menu_total = "SELECT detail_penjualan.*, menu.nama_menu, menu.harga, penjualan.total_harga AS total_penjualan 
             FROM detail_penjualan 
             JOIN menu ON detail_penjualan.id_menu = menu.id 
             JOIN penjualan ON detail_penjualan.id_penjualan = penjualan.id_penjualan
             WHERE detail_penjualan.id_penjualan = '$id_penjualan'";

$result_menu_total = $conn->query($sql_menu_total); // Menggunakan $sql_menu_total
$total_data = array(); // Inisialisasi array kosong untuk menyimpan baris data menu
while ($row = $result_menu_total->fetch_assoc()) {
    // Menambahkan kolom total harga untuk setiap item
    $row['total_harga_item'] = $row['harga'] * $row['amount']; // Menggunakan 'total_penjualan' dari query
    $total_data[] = $row; // tambahkan setiap baris menu ke dalam array data menu
}



?>

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
          <?php endif;?>

<a href="penjualan.php"><i class="fas fa-arrow-left fa-2x text-danger"></i></a>
<div class="bg-gradient-danger d-flex justify-content-center align m-4" style="height: 50px;">
    <h4 class="text-white justify-content-center p-2">Detail Penjualan</h4>
</div>

<div class="card shadow mb-4">
              <div class="card-header py-3">
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nama Menu</th>
                        <th>Banyaknya</th>
                        <th>Total Harga</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Total Menu</th>
                        <th>Banyaknya</th>
                        <th>Total Harga</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($total_data as $key => $row): ?>
                      <tr>
                        <td><?= $row['nama_menu']; ?></td>
                        <td><?= $row['amount']; ?> Porsi</td>
                        <td>Rp. <?= number_format($row['total_harga_item'], 0, ',', '.'); ?></td>
                      </tr>
                      <!-- Modal Edit -->
                      <div class="modal fade" id="modalEdit<?= $key; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editMenuLabel">Edit Penjualan</h1>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                            <form action="controllers/detailPenjualanController.php?action=edit&id_penjualan=<?=$row['id_penjualan'];?>" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                              <div>
                                <label for="nama_menu" class="form-label">Menu</label>
                                <select name="id_menu" class="form-control" id="id_menu_edit">
                                    <?php foreach($menu_data as $menu): ?>
                                        <option value="<?= $menu['id']; ?>"><?= $menu['nama_menu']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="jumlah_penjualan" class="form-label">Banyaknya</label>
                                <input value="<?=$row['jumlah_penjualan'];?>" type="number" placeholder="Banyaknya" autofocus name="jumlah_penjualan" class="form-control" autocomplete="off">
                            </div>
                              <div>
                                <label for="total_harga" class="form-label">Total Harga</label>
                                <input value="<?=$row['total_harga'];?>" type="number" placeholder="Total Harga" autofocus name="total_harga" class="form-control" autocomplete="off">
                              </div>
                              <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="submit" class="btn btn-warning btn-confirm-edit">Submit</button>
                              </div>
                            </form>
                            </div>
                          </div>
                        </div>
                      </div>
    
                      <!-- Modal Hapus -->
                      <div class="modal fade" id="modalHapus<?= $key ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                          </div>
                          <div class="modal-body">
                            <p>Anda yakin ingin menghapus ?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a class="btn btn-danger" href="controllers/detailPenjualanController.php?action=delete&id_penjualan=<?=$row['id_penjualan'];?>">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>
    
                  <?php endforeach; ?>
                  </tbody>
                          
                  </table>
                </div>
              </div>
            </div>
          
        <!-- End of Main Content -->

<?php require 'partials/footer.php'; ?>