<?php require 'partials/header.php'; 

?>
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
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Total Menu</th>
                        <th>Banyaknya</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($data as $key => $row): ?>
                      <tr>
                        <td><?= $row['total_menu']; ?></td>
                        <td><?= $row['jumlah_penjualan']; ?></td>
                        <td>Rp. <?= $row['total_harga']; ?></td>
                        <td><button type="button" class="btn btn-warning mb-2 btn-edit" data-toggle="modal" data-target="#modalEdit<?= $key; ?>" data-id="<?= $row['id_penjualan']; ?>">Edit</button>
                        <button type="button" class="btn btn-danger mb-2 btn-delete" data-toggle="modal" data-target="#modalHapus<?= $key; ?>" data-id="<?= $row['id_penjualan']; ?>">Hapus</button>
                      </tr>
                  </tbody>
                          
                      <!-- Modal Edit -->
                      <div class="modal fade" id="modalEdit<?= $key; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editMenuLabel">Edit Penjualan</h1>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                            <form action="controllers/penjualanController.php?action=edit&id_penjualan=<?=$row['id_penjualan'];?>" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4">
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
                            <a class="btn btn-danger" href="controllers/penjualanController.php?action=delete&id_penjualan=<?=$row['id_penjualan'];?>">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php endforeach; ?>
                  </table>
                </div>
              </div>
            </div>
          
        <!-- End of Main Content -->

        <!-- Modal Tambah Stock-->


<?php require 'partials/footer.php'; ?>