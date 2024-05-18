<?php 

require './partials/header.php';

$id_kategori = isset($_REQUEST['id_kategori']) ? $_REQUEST['id_kategori'] : null;
$id_kategori_escaped = mysqli_real_escape_string($conn, $id_kategori);

$sql = "SELECT * FROM kategori_bahan";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}

if ($result->num_rows > 0) {
    // data menu ditemukan, lanjutkan dengan menampilkan opsi menu dalam elemen <select>
} else {
    // tidak ada data menu yang ditemukan
    echo "Data Tidak Ada !";
}

$conn->close();

?>

<!-- DataTales Example -->
<button type="button" class="btn btn-danger mb-4" data-toggle="modal" data-target="#modalBahan">
  + Bahan
</button>
<button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#modalKategori">
  + Kategori
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
                        <th>Kategori</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Kategori</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($data as $key => $row): ?>
                      <tr>
                        <td><?= $row['kategori'] ?></td>
                        <td><a href="stock.php?id_kategori=<?= $row['id']; ?>" class="btn btn-success mb-2 ">Detail</a>
                        <button type="button" class="btn btn-warning mb-2" data-toggle="modal" data-target="#modalEdit<?= $key; ?>">Edit</button>
                        <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modalHapus<?= $key; ?>">Hapus</button></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                          
                      <!-- Modal Edit -->
                      <div class="modal fade" id="modalEdit<?= $key; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editMenuLabel">Edit Bahan</h1>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                            <form action="controllers/stockController.php?action=edit&id=<?=$row['id'];?>" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4" autocomplete="off">
                              <div>
                                <label for="kategori" class="form-label">Kategori</label>
                                <input value="<?=$row['kategori']; ?>" type="text" placeholder="kategori" autofocus name="kategori" class="form-control">
                              </div>
                              <div class="modal-footer">
                              <button type="submit" name="submitEdit" class="btn btn-warning">Submit</button>
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
                            <a class="btn btn-danger" href="controllers/stockController.php?action=deleteKategori&id=<?=$row['id'];?>">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          
        <!-- End of Main Content -->

        <!-- Modal Tambah Stock-->

<div class="modal fade" id="modalBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">+ Bahan</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        <!-- Add your content here -->
        <form action="controllers/stockController.php?action=add" method="POST" enctype="multipart/form-data" autocomplete="off">
           <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                 </div>
            <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" class="form-control" id="id_kategori">
                <option value="" disabled selected>Pilih Kategori</option> <!-- Option baru -->
                <?php foreach($data as $kategori): ?>
                    <option data-id="<?= $kategori['kategori']; ?>" value="<?= $kategori['id']; ?>"><?= $kategori['kategori']; ?></option>
                <?php endforeach; ?>
            </select>
            </div>
             <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <div class="form-group">
                    <input class="form-control" list="satuan" name="satuan" id="jenis_kerja" placeholder="Pilih Pekerjaan" required>
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

<!-- Modal Tambah Kategori -->

<div class="modal fade" id="modalKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">+ Kategori</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        <!-- Add your content here -->
        <form action="controllers/stockController.php?action=add" method="POST" enctype="multipart/form-data" autocomplete="off">
           <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="kategori" name="kategori" required>
                 </div>
            <button type="submit" name="submitKategori" class="btn btn-warning">Submit</button>
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