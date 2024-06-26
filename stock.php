<?php 

require './partials/header.php';

$id_kategori = isset($_REQUEST['id_kategori']) ? $_REQUEST['id_kategori'] : null;
$id_kategori_escaped = mysqli_real_escape_string($conn, $id_kategori);

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$id_escaped = mysqli_real_escape_string($conn, $id);

$sql = "SELECT * FROM kategori_bahan JOIN bahan ON kategori_bahan.id = bahan.id_kategori WHERE bahan.id_kategori = '$id_kategori_escaped'";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
  $data[] = $row; // append each row to the data array
}

$sql = "SELECT * FROM kategori_bahan";
$resultKategori = $conn->query($sql);
$dataKategori = array(); // initialize an empty array to store the rows
while ($row = $resultKategori->fetch_assoc()) {
  $dataKategori[] = $row; // append each row to the data array
}

// if ($result->num_rows > 0) {
//   // data menu ditemukan, lanjutkan dengan menampilkan opsi menu dalam elemen <select>
// } else {
//   // tidak ada data menu yang ditemukan
//   echo "Data Tidak Ada !";
// }

$conn->close();

?>

<!-- DataTales Example -->
<button type="button" class="btn btn-danger mb-4" data-toggle="modal" data-target="#modalBahan">
  + Bahan
</button>

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

            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-danger">Sisa Bahan</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <!-- <th>Tanggal</th> -->
                        <th>Nama Bahan</th>
                        <th>Harga</th>
                        <th>Sisa Stok</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <!-- <th>Tanggal</th> -->
                        <th>Nama Bahan</th>
                        <th>Harga</th>
                        <th>Sisa Stok</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($data as $key => $row): ?>
                      <tr>
                        <!-- <td><?= $row['tanggal'] ?></td> -->
                        <td><?= $row['nama_bahan']; ?></td>
                        <td>Rp. <?= number_format($row['harga'], 0, ',', '.'); ?> </td>
                        <td><?= $row['stok']; ?> <?= $row['satuan']; ?></td>  
                        <td><button type="button" class="btn btn-warning mb-2" data-toggle="modal" data-target="#modalEdit<?= $key; ?>">Edit</button>
                        <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modalHapus<?= $key; ?>">Hapus</button></td>
                      </tr>
                          
                      <!-- Modal Edit -->
                      <div class="modal fade" id="modalEdit<?= $key; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editMenuLabel">Edit Bahan</h1>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                            <form action="controllers/stockController.php?action=edit&id=<?= $row['id'] ?>" method="POST" enctype="multipart/form-data">
                              <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input value="<?=$row['tanggal']; ?>" type="date" placeholder="Tanggal" autofocus name="tanggal" class="form-control">
                              </div>
                              <div class="mb-3">
                                    <label for="id_kategori" class="form-label">Kategori</label>
                                    <select name="id_kategori" class="form-control" id="id_kategori" required>
                                        <option value="" disabled>Pilih Kategori</option>
                                        <?php foreach($dataKategori as $kategori): ?>
                                            <option value="<?= $kategori['id']; ?>" <?= $kategori['id'] == $id_kategori_escaped ? 'selected' : ''; ?>><?= $kategori['kategori']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                              </div>
                              <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <div class="form-group">
                    <select id="satuan" name="satuan" class="form-control" required>
                        <option value="kg" <?= $row['satuan'] == 'kg' ? 'selected' : ''; ?>>Kilogram</option>
                        <option value="gram" <?= $row['satuan'] == 'gram' ? 'selected' : ''; ?>>Gram</option>
                        <option value="ekor" <?= $row['satuan'] == 'ekor' ? 'selected' : ''; ?>>Ekor</option>
                        <option value="bks" <?= $row['satuan'] == 'bks' ? 'selected' : ''; ?>>Bungkus</option>
                        <option value="butir" <?= $row['satuan'] == 'butir' ? 'selected' : ''; ?>>Butir</option>
                        <option value="ikat" <?= $row['satuan'] == 'ikat' ? 'selected' : ''; ?>>Ikat</option>
                        <option value="pcs" <?= $row['satuan'] == 'pcs' ? 'selected' : ''; ?>>Pieces</option>
                        <option value="btl" <?= $row['satuan'] == 'btl' ? 'selected' : ''; ?>>Botol</option>
                        <option value="ball" <?= $row['satuan'] == 'ball' ? 'selected' : ''; ?>>Ball</option>
                        <option value="liter" <?= $row['satuan'] == 'liter' ? 'selected' : ''; ?>>Liter</option>
                        <option value="sachet" <?= $row['satuan'] == 'sachet' ? 'selected' : ''; ?>>Sachet</option>
                        <option value="klg" <?= $row['satuan'] == 'klg' ? 'selected' : ''; ?>>Kaleng</option>
                        <option value="buah" <?= $row['satuan'] == 'buah' ? 'selected' : ''; ?> >Buah</option>
                        <option value="galon" <?= $row['satuan'] == 'galon' ? 'selected' : ''; ?>>Galon</option>
                        <option value="pak" <?= $row['satuan'] == 'pak' ? 'selected' : ''; ?>>Pak</option>
                        <option value="roll" <?= $row['satuan'] == 'roll' ? 'selected' : ''; ?>>Roll</option>
                        <option value="box" <?= $row['satuan'] == 'box' ? 'selected' : ''; ?>>Box</option>
                        <option value="tabung" <?= $row['satuan'] == 'tabung' ? 'selected' : ''; ?>>Tabung</option>
                    </select>
                </div>
           </div>
                              <div class="mb-3">
                                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                <input value="<?=$row['nama_bahan'];?>" type="text" placeholder="Nama Bahan" autofocus name="nama_bahan" class="form-control" autocomplete="off">
                              </div>
                              <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input value="<?=$row['harga'];?>" type="text" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
                              </div>
                              <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input value="<?=$row['stok'];?>" type="number" placeholder="Stok" autofocus name="stok" class="form-control">
                              </div>
                              <div class="modal-footer">
                              <button type="submit" name="submit" class="btn btn-warning">Submit</button>
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
                            <a class="btn btn-danger" href="controllers/stockController.php?action=delete&id=<?=$row['id'];?>">Hapus</a>
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

        <!-- Modal Tambah Stock-->

<!-- Modal Tambah Stock-->
<div class="modal fade" id="modalBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">+ Bahan</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        <form action="controllers/stockController.php?action=add" method="POST" enctype="multipart/form-data" autocomplete="off">
           <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
           </div>
           <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select name="id_kategori" class="form-control" id="id_kategori" required>
                    <option value="" disabled>Pilih Kategori</option>
                    <?php foreach($dataKategori as $kategori): ?>
                        <option value="<?= $kategori['id']; ?>" <?= $kategori['id'] == $id_kategori_escaped ? 'selected' : ''; ?>><?= $kategori['kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
           </div>
           <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <div class="form-group">
                    <input class="form-control" list="satuan" name="satuan" placeholder="Pilih Satuan" required>
                    <datalist id="satuan">
                        <option value="kg">Kilogram</option>
                        <option value="gram">Gram</option>
                        <option value="ekor">Ekor</option>
                        <option value="bks">Bungkus</option>
                        <option value="butir">Butir</option>
                        <option value="ikat">Ikat</option>
                        <option value="pcs">Pieces</option>
                        <option value="btl">Botol</option>
                        <option value="ball">Ball</option>
                        <option value="liter">Liter</option>
                        <option value="sachet">Sachet</option>
                        <option value="klg">Kaleng</option>
                        <option value="buah">Buah</option>
                        <option value="galon">Galon</option>
                        <option value="pak">Pak</option>
                        <option value="roll">Roll</option>
                        <option value="box">Box</option>
                        <option value="tabung">Tabung</option>
                    </datalist>
                </div>
           </div>
           <div class="mb-3">
                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" required>
           </div>
           <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" min="0" step="0.01" required>
           </div>
           <div class="mb-3">
                <label for="stok" class="form-label">Sisa Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
           </div>
           <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- end modal Stock -->

<?php require 'partials/footer.php'; ?>