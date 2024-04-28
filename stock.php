<?php 

require './partials/header.php';

$sql = "SELECT * FROM bahan";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}
$conn->close();

?>

<!-- DataTales Example -->
<button type="button" class="btn btn-danger mb-4" data-toggle="modal" data-target="#modalBahan">
  + Bahan
</button>
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-danger">Sisa Bahan</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nama Bahan</th>
                        <th>Harga</th>
                        <th>Sisa Stok</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama Bahan</th>
                        <th>Harga</th>
                        <th>Sisa Stok</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($data as $key => $row): ?>
                      <tr>
                        <td><?= $row['nama_bahan'] ?></td>
                        <td><?= $row['harga'] ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
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
                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" min="0" step="0.01" required>

            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Sisa Stok</label>
                <input type="number" class="form-control" id="stok" name="stok">
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