<?php 

require './partials/header.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('M');

$currentYear = date('Y');

if(isset($_GET['tahun'])){
  $tahun = $_GET['tahun'];
} else {
  $tahun = $currentYear;
} 

$sqlBahan = "SELECT * FROM bahan";
$result = $conn->query($sqlBahan);
$dataBahan = array(); // initialize an empty array to store the rows
while($row = $result->fetch_assoc()) {
    $dataBahan[] = $row;
}

$sql = "SELECT bahan_transaksi.*, 
bahan.stok, bahan.satuan, bahan_masuk.stok_masuk, bahan.satuan,
SUM(bahan_masuk.stok_masuk) as jumlah_bahan
FROM bahan_transaksi
LEFT JOIN bahan_masuk ON bahan_transaksi.id = bahan_masuk.id_transaksi
LEFT JOIN bahan ON bahan_masuk.id_bahan = bahan.id
WHERE YEAR(bahan_transaksi.tanggal) = '$tahun' AND MONTH(bahan_transaksi.tanggal) = '$bulan'
GROUP BY bahan_transaksi.id
";

$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}


$conn->close();

?>http://localhost/resto-app/index.php

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

<div class="mb-3">
    <select class="rounded" name="bulanFilter" id="bulanFilter">
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maret</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
        <option value="6">Juni</option>
        <option value="7">Juli</option>
        <option value="8">Agustus</option>
        <option value="9">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>
    </select>
    <input class="rounded" type="number" id="tahunFilter" name="tahunFilter" min="2000" max="2099" step="1" value="2024">

    <button class="btn btn-danger" onclick="applyFilter()">Pilih Bulan</button>
</div>

<div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-danger">Bahan Terpakai</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Bahan</th>
                        <th>Stock Masuk</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Bahan</th>
                        <th>Stock Masuk</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($data as $key => $row): ?>
                      <tr>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['jumlah_bahan']; ?></td>
                        <td><?= $row['stok_masuk']; ?> <?= $row['satuan']; ?></td>
                        <td><a href="detailBahanTransaksi.php?id_transaksi=<?= $row['id']; ?>" class="btn btn-success mb-2 ">Detail</a></td>
                      </tr>
                          
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

  <div class="modal fade" id="modalBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">+ Bahan</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" autocomplete="off" id="formAdd">
          <ul id="itemList">
          <!-- Rendered list items will appear here -->
        </ul>
           <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
           </div>
           <div class="mb-3">
            <label for="id_bahan" class="form-label">Bahan</label>
            <select name="id_bahan" class="form-control" id="id_bahan" onchange="addItemToList()">
                <option value="">Pilih Bahan</option> <!-- Option baru -->
                <?php foreach($dataBahan as $bahan): ?>
                    <option data-id="<?= $bahan['nama_bahan']; ?>" value="<?= $bahan['id']; ?>"><?= $bahan['nama_bahan']; ?></option>
                <?php endforeach; ?>
            </select>
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

<script>
  var itemListData = [];

function addItemToList() {
    var select = document.getElementById("id_bahan");
    var selectedOption = select.options[select.selectedIndex];

        var id = selectedOption.value;
        var name = selectedOption.dataset.id;

        // Create list item object
        var item = {
            id: id,
            name: name,
            amount: 1
        }
        // Push item object to array
        itemListData.push(item);

        // Render list item
        renderListItem(item);

        // Reset the select to the default option
        select.selectedIndex = 0;
    
          
}

// Fungsi untuk membuka modal tambah penjualan
function openModal() {
  
    itemListData = [];
    // Panggil fungsi untuk mengosongkan item list
    clearItemList();
    // Buka modal
    $('#modalBahan').modal('show');

}

// Tambahkan event listener untuk menangani pembukaan modal
// $('#modalBahan').on('show.bs.modal', openModal);

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

    var amountSpan = document.createElement("input");
    amountSpan.type = "number";
    amountSpan.step = "0.01";
    amountSpan.value = item.amount;
    amountSpan.onchange = function() {
        item.amount = amountSpan.value;
    };
    listItem.appendChild(amountSpan);

    // Create buttons to adjust amount
    var increaseButton = document.createElement("button");
    increaseButton.textContent = "+";
    increaseButton.classList.add("btn","btn-sm","btn-success","btn-circle", "ml-1")
    increaseButton.id = "increaseButton"
    increaseButton.onclick = function() {
        item.amount++;
        amountSpan.value = item.amount;
    };
     // Tambahkan event listener untuk mencegah perilaku default dari event "click"
     increaseButton.addEventListener("click", function(event) {
        event.preventDefault();
    });

    listItem.appendChild(increaseButton);

    var decreaseButton = document.createElement("button");
    decreaseButton.classList.add("btn","btn-sm","btn-warning","btn-circle", "ml-1")
    decreaseButton.id = "decreaseButton"
    decreaseButton.textContent = "-";
    decreaseButton.onclick = function() {
        if (item.amount > 1) {
            item.amount--;
            amountSpan.value = item.amount;
        }
    };
    decreaseButton.addEventListener("click", function(event) {
        event.preventDefault();
    });
    listItem.appendChild(decreaseButton);

    // Create a button to remove the item
    var removeButton = document.createElement("button");
    removeButton.innerHTML = '<i class="fas fa-trash"></i>';
    removeButton.classList.add("btn","btn-sm","btn-danger","btn-circle", "ml-1")
    removeButton.onclick = function() {
        // Hapus item dari array itemListData
        itemListData = itemListData.filter(function(listItem) {
            return listItem.id !== item.id;
        });
        // Hapus elemen list item dari DOM
        listItem.remove();
    };
    removeButton.addEventListener("click", function(event) {
        event.preventDefault();
    });
    listItem.appendChild(removeButton);

    // Append the list item to the list
    document.getElementById("itemList").appendChild(listItem);
}

console.log(itemListData);

// Fungsi untuk mengosongkan item list
function clearItemList() {
    // Dapatkan referensi ke elemen ul item list
    var itemList = document.getElementById("itemList");
    // Kosongkan elemen ul item list
    itemList.innerHTML = "";

     // Mengosongkan input tanggal
    document.getElementById("tanggalAddForm").value = "";
    // Mengosongkan input shift
    document.getElementById("shiftAdd").selectedIndex = 0;
}




const formAdd = document.getElementById("formAdd");
formAdd.addEventListener("submit", unSubmit); 

function unSubmit(e) {
  e.preventDefault();
  const tanggal = document.getElementById("tanggal").value;

  const formData = new FormData(formAdd);



    formData.append('tanggal', tanggal);
    formData.append('item', JSON.stringify(itemListData));

  

  // console.log(tanggalAddForm, shiftAdd, total_hargaAdd);



fetch('controllers/stockController.php?action=addBahanMasuk', {
          method: 'POST', 
          body: formData
        })
        // .then(data=> data.json())
        // .then(data=> console.log(data))
        .then(data=> location.reload(true))
    
}

        console.log(formData);


                var urlParams = new URLSearchParams(window.location.search);
                var bulan = urlParams.get('bulan');
                var tahun =urlParams.get('tahun')

                if(bulan){
                    document.getElementById('bulanFilter').value = bulan
                    document.getElementById('tahunFilter').value = tahun

                }

                function applyFilter(){
                var tahun = document.getElementById('tahunFilter').value;
                var bulan = document.getElementById('bulanFilter').value;
                var url = window.location.pathname + '?tahun=' + tahun + '&bulan=' + bulan;
                history.pushState({}, '', url);
                location.reload();
                }
            </script>


<?php require 'partials/footer.php'; ?>