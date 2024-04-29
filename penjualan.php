<?php 

require './partials/header.php'; 

$sql = "SELECT * FROM penjualan";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}
$conn->close();

?>

<button type="button" class="btn btn-danger mb-4" data-toggle="modal" data-target="#modalBahan">
  + Penjualan
</button>
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-danger">Penjualan</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Menu</th>
                        <th>Banyaknya</th>
                        <th>Shift</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Tanggal</th>
                        <th>Menu</th>
                        <th>Banyaknya</th>
                        <th>Shift</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($data as $key => $row): ?>
                      <tr>
                        <td><?= $row['nama_bahan']; ?></td>
                        <td>Rp. <?= $row['harga']; ?></td>
                        <td><?= $row['stok']; ?></td>
                        <td><?= $row['shift']; ?></td>
                        <td>Rp. <?= $row['total_harga']; ?></td>
                        <td><button type="button" class="btn btn-warning mb-2" data-toggle="modal" data-target="#modalEdit<?= $key; ?>">Edit</button>
                        <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modalHapus<?= $key; ?>">Hapus</button></td>
                      </tr>
                          
                      <!-- Modal Edit -->
                      <div class="modal fade" id="modalEdit<?= $key; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editMenuLabel">Edit Penjualan</h1>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                            <form action="controllers/stockController.php?action=edit&id=<?=$row['id'];?>" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                            <div>
                                <label for="harga" class="form-label">Tanggal</label>
                                <input value="<?=$row['harga'];?>" type="date" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
                              </div>
                              <div>
                                <label for="harga" class="form-label">Menu</label>
                                <input value="<?=$row['harga'];?>" type="text" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
                            </div>
                            <div>
                                <label for="harga" class="form-label">Banyaknya</label>
                                <input value="<?=$row['harga'];?>" type="number" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
                            </div>
                                <div class="form-group">
                                    <label for="options" class="form-label">Shift</label>
                                    <select class="form-control" id="options" name="options">
                                        <option value="pagi">Pagi</option>
                                        <option value="siang">Siang</option>
                                        <option value="malam">Malam</option>
                                    </select>
                                </div>
                              <div>
                                <label for="harga" class="form-label">Total Harga</label>
                                <input value="<?=$row['harga'];?>" type="text" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
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

<div class="modal fade" id="modalBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">+ Penjualan</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        <!-- Add your content here -->
        <form action="controllers/stockController.php?action=edit&id=<?=$row['id'];?>" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4">             
        <div>
            <label for="harga" class="form-label">Tanggal</label>
            <input value="<?=$row['harga'];?>" type="date" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
        </div>
        <div>
            <label for="harga" class="form-label">Menu</label>
            <input value="<?=$row['harga'];?>" type="text" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
        </div>
        <div>
            <label for="harga" class="form-label">Banyaknya</label>
            <input value="<?=$row['harga'];?>" type="number" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="options" class="form-label">Shift</label>
            <select class="form-control" id="options" name="options">
                <option value="pagi">Pagi</option>
                <option value="siang">Siang</option>
                <option value="malam">Malam</option>
            </select>
        </div>
        <div>
            <label for="harga" class="form-label">Total Harga</label>
            <input value="<?=$row['harga'];?>" type="text" placeholder="Harga" autofocus name="harga" class="form-control" autocomplete="off">
            </div>
            <div class="modal-footer">
            <button type="submit" name="submit" class="btn btn-warning">Submit</button>
        </div>
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