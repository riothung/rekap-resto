<?php 

require './partials/header.php'; 

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}
$conn->close();

?>
 
<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalMenu">
  + Makanan
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

<div class="container mt-5">
        <div class="row row-cols-sm-2 row-cols-md-4 g-4 ">
            <?php foreach($data as $key => $row): ?>
                
              <!-- <div class="menu-card" onclick="toggleDescription(menu)"></div>
              <p class="card-text" class="description-full" id="menu">Deskripsi lengkap dari menu yang cukup panjang. Deskripsi ini akan muncul ketika tombol "Selengkapnya" ditekan.</p>
              <button class="btn-more">Selengkapnya</button> -->
                <?= '<div class="col">
                    <div class="card mt-3 border-danger">
                    <img src="./'.$row['gambar'].'" class="card-img-top" alt="...">
                    <div class="card-body">
                    <h5 class="card-title text-danger">'.$row['nama_menu'].'</h5>
                    <p class="card-text text-gray-800"> <b>Harga :</b> Rp. '.$row['harga'].'</p>
                

                        <button type="button" class="btn btn-warning btn-sm mb-2" data-toggle="modal" data-target="#editMenu'.$key.'">
                            <i class="fas fa-fw fa-pencil-alt"></i><span> Edit</span>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#hapusMenu'.$key.'">
                            <i class="fas fa-fw fa-trash-alt"></i><span>Hapus</span>
                          </button>  


                          <div class="modal fade" id="editMenu'.$key.'" tabindex="-1" aria-labelledby="editMenuLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="editMenuLabel">Edit Menu</h1>
                                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                <form action="controllers/makananController.php?action=edit&id='.$row['id'].'" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4 autocomplete="off">
                                  
                                  <div>
                                    <label for="nama_menu" class="form-label">Nama Menu</label>
                                    <input value="'.$row['nama_menu'].'" type="text" placeholder="Nama Menu" autofocus name="nama_menu" class="form-control" >
                                  </div>
                                  <div>
                                    <label for="harga" class="form-label">Harga</label>
                                    <input value="'.$row['harga'].'" type="text" placeholder="Harga" autofocus name="harga" class="form-control" >
                                  </div>
                                  <div>
                                    <label for="gambar" class="form-label">Nama Menu</label>
                                    <input value="'.$row['gambar'].'" type="file" placeholder="Gambar" autofocus name="gambar" class="form-control">
                                  </div>
                                  <div class="modal-footer">
                                  <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                  </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
    
                          <div class="modal fade" id="hapusMenu'.$key.'" tabindex="-1" aria-labelledby="hapusMenuLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                  <p>Anda yakin ingin menghapus ?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <a class="btn btn-danger" href="controllers/makananController.php?action=delete&id='.$row['id'].'">Hapus</a>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>'; ?>

            <?php endforeach; ?>
            
            <!-- Add more columns as needed -->
        </div>
    </div>

        <!-- Modal Tambah Menu-->
    
<div class="modal fade" id="modalMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Makanan</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        <!-- Add your content here -->
        <form action="controllers/makananController.php?action=add" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Makanan</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" min="0" step="0.01" required>

            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Menu</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
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
<!-- end modal Menu -->

  <script>
    function toggleDescription(menu) {
    var description = document.getElementById(menu);
    var shortDescription = description.previousElementSibling;
    var btnMore = shortDescription.nextElementSibling;

    if (description.style.display === "none") { 
        description.style.display = "block";
        btnMore.textContent = "Sembunyikan";
    } else {
        description.style.display = "none";
        btnMore.textContent = "Selengkapnya";
    }
}

    </script>


<!-- /.container-fluid -->
<?php require 'partials/footer.php'; ?>

