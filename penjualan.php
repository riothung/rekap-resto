<?php 

require './partials/header.php'; 

// $id_penjualan = isset($_REQUEST['id_penjualan']);

// $sql = "SELECT * FROM penjualan JOIN menu ON penjualan.id_menu = menu.id WHERE id_penjualan = '$id_penjualan'";
// $sql = "SELECT penjualan.*, menu.* FROM penjualan JOIN menu ON penjualan.id_menu = menu.id WHERE penjualan.id_penjualan = '$id_penjualan'";

$id_penjualan = isset($_REQUEST['id_penjualan']) ? $_REQUEST['id_penjualan'] : null;
$id_penjualan_escaped = mysqli_real_escape_string($conn, $id_penjualan);

$sql = "SELECT penjualan.*, COUNT(detail_penjualan.id_penjualan) as total_menu FROM penjualan JOIN detail_penjualan ON penjualan.id_penjualan = detail_penjualan.id_penjualan GROUP BY penjualan.id_penjualan";

$result = $conn->query($sql);

$data = array(); // initialize an empty array to store the rows

while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}

// $sql = "SELECT * FROM penjualan";
// $result = $conn->query($sql);
// $data = array(); // initialize an empty array to store the rows
// while ($row = $result->fetch_assoc()) {
//     $data[] = $row; // append each row to the data array
// }
// $conn->close();

// Buat query untuk mendapatkan data menu
$sql_menu = "SELECT * FROM menu";
$result_menu = $conn->query($sql_menu);
$menu_data = array(); // inisialisasi array kosong untuk menyimpan baris data menu
while ($menu_row = $result_menu->fetch_assoc()) {
    $menu_data[] = $menu_row; // tambahkan setiap baris menu ke dalam array data menu
}

// Periksa apakah ada data menu yang ditemukan
if ($result_menu->num_rows > 0) {
    // data menu ditemukan, lanjutkan dengan menampilkan opsi menu dalam elemen <select>
} else {
    // tidak ada data menu yang ditemukan
    echo "Tidak ada data menu yang tersedia.";
}

// Periksa apakah ada data menu yang ditemukan sebelum melanjutkan
// if (!empty($menu_data)) {
//     // loop untuk membuat opsi menu dalam elemen <select> di modal tambah penjualan
//     foreach ($menu_data as $menu_row) {
//         echo '<option value="' . $menu_row['id'] . '">' . $menu_row['menu'] . '</option>';
//     }
// } else {
//     // tidak ada data menu yang tersedia, tampilkan pesan kesalahan
//     echo '<option value="">Data menu tidak tersedia.</option>';
// }

// $sqlTotalHarga = "SELECT SUM(CASE WHEN ) AS total_harga FROM penjualan";

?>

<!-- <?php print_r($menu_data); ?> -->



<button type="button" class="btn btn-danger mb-4" data-toggle="modal" data-target="#modalBahan">
  + Penjualan
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
                <h4 class="m-0 font-weight-bold text-danger">Penjualan</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Total Menu</th>
                        <th>Shift</th>
                        <th>Banyaknya</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Tanggal</th>
                        <th>Total Menu</th>
                        <th>Shift</th>
                        <th>Banyaknya</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($data as $key => $row): ?>
                      <tr>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['total_menu']; ?></td>
                        <td><?= $row['shift']; ?></td>
                        <td><?= $row['jumlah_penjualan']; ?></td>
                        <td>Rp. <?= $row['total_harga']; ?></td>
                        <td><a href="detailPenjualan.php" class="btn btn-success mb-2 ">Detail</a>
                        <button type="button" class="btn btn-warning mb-2 btn-edit" data-toggle="modal" data-target="#modalEdit<?= $key; ?>" data-id="<?= $row['id_penjualan']; ?>">Edit</button>
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
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input value="<?=$row['tanggal'];?>" type="date" placeholder="Tanggal" autofocus name="tanggal" class="form-control" autocomplete="off">
                              </div>

                              <div>
                                <label for="nama_menu" class="form-label">Menu</label>
                                <select name="id_menu" class="form-control" id="id_menu_edit">
                                    <?php foreach($menu_data as $menu): ?>
                                        <option value="<?= $menu['id']; ?>"><?= $menu['nama_menu']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                              <label for="options" class="form-label">Shift</label>
                              <select class="form-control" id="options" name="shift">
                                  <option value="" disabled selected>Pilih Shift</option>
                                  <option value="pagi" <?= ($row['shift'] == 'pagi') ? 'selected' : ''; ?>>Pagi</option>
                                  <option value="siang" <?= ($row['shift'] == 'siang') ? 'selected' : ''; ?>>Siang</option>
                                  <option value="malam" <?= ($row['shift'] == 'malam') ? 'selected' : ''; ?>>Malam</option>
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

<!-- Modal Tambah Penjualan -->
<div class="modal fade" id="modalBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">+ Penjualan</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        <!-- Form Tambah Penjualan -->
        <!-- <form action="controllers/penjualanController.php?action=add" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4" id="formAdd"> -->
        <form enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4" id="formAdd">
          <!-- <div id="selectedMenu" class="d-flex flex-column">
            
          </div> -->

          <ul id="itemList">
    <!-- Rendered list items will appear here -->
</ul>
        <div>
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" placeholder="Tanggal" autofocus name="tanggal" class="form-control" autocomplete="off" require id="tanggalAddForm">
          </div>
          <div>
            <label for="id_menu" class="form-label">Menu</label>
            <select name="id_menu" class="form-control" id="id_menu" onchange="addItemToList()">
                <option value="">Pilih Menu</option> <!-- Option baru -->
                <?php foreach($menu_data as $menu): ?>
                    <option data-id="<?= $menu['nama_menu']; ?>" value="<?= $menu['id']; ?>"><?= $menu['nama_menu']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
          <div class="form-group">
            <label for="options" class="form-label">Shift</label>
            <select class="form-control" name="shift" required id="shiftAdd">
              <option value="" disabled selected>Pilih Shift</option>
              <option value="pagi">Pagi</option>
              <option value="siang">Siang</option>
              <option value="malam">Malam</option>
            </select>
          </div>
          <!-- <div>
            <label for="jumlah_penjualan" class="form-label">Banyaknya</label>
            <input type="number" placeholder="" autofocus name="jumlah_penjualan" class="form-control" autocomplete="off" required id="jumlah_penjualanAdd">
          </div> -->
          <div>
            <label for="total_harga" class="form-label">Total Harga</label>
            <input type="number"  autofocus name="total harga" class="form-control" autocomplete="off" required id="total_hargaAdd">
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
<!-- End Modal Tambah Penjualan -->

<!-- end modal penjualanStock -->


<?php require 'partials/footer.php'; ?>

<script>
var itemListData = [];

function addItemToList() {
    var select = document.getElementById("id_menu");
    var selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value !== "") {
        var id = selectedOption.value;
        var name = selectedOption.dataset.id;

        // Create list item object
        var item = {
            id: id,
            name: name,
            amount: 1
        };

        // Push item object to array
        itemListData.push(item);

        // Render list item
        renderListItem(item);

        // Reset the select to the default option
        select.selectedIndex = 0;
    }
}

function renderListItem(item) {
    // Create list item element
    var listItem = document.createElement("li");
    listItem.dataset.id = item.id;

    // Create a span for the item name
    var itemName = document.createElement("span");
    itemName.textContent = item.name + " (ID: " + item.id + ") - Amount: ";
    listItem.appendChild(itemName);

    // Create a span for the amount
    var amountSpan = document.createElement("span");
    amountSpan.textContent = item.amount;
    listItem.appendChild(amountSpan);

    // Create buttons to adjust amount
    var increaseButton = document.createElement("button");
    increaseButton.textContent = "+";
    increaseButton.onclick = function() {
        item.amount++;
        amountSpan.textContent = item.amount;
    };
    listItem.appendChild(increaseButton);

    var decreaseButton = document.createElement("button");
    decreaseButton.textContent = "-";
    decreaseButton.onclick = function() {
        if (item.amount > 1) {
            item.amount--;
            amountSpan.textContent = item.amount;
        }
    };
    listItem.appendChild(decreaseButton);

    // Append the list item to the list
    document.getElementById("itemList").appendChild(listItem);
}

console.log(itemListData);

const formAdd = document.getElementById("formAdd");
formAdd.addEventListener("submit", unSubmit); 

function unSubmit(e) {
  e.preventDefault();
  const tanggalAddForm = document.getElementById("tanggalAddForm").value;
  const shiftAdd = document.getElementById("shiftAdd").value;
  const total_hargaAdd = document.getElementById("total_hargaAdd").value;

  console.log(tanggalAddForm, shiftAdd, total_hargaAdd);

  var formData = {
    tanggal: tanggalAddForm,
    shift: shiftAdd,
    total_harga: total_hargaAdd,
    item: itemListData
}

fetch('controllers/penjualanController.php?action=add', {
          method: 'POST', 
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: JSON.stringify(formData)
        })
        // .then(data=> data.json())
        // .then(data=> console.log(data))
        .then(data=> location.reload(true))
    
    

        console.log(formData);
}



   


</script>
