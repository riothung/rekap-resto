<?php 

require './partials/header.php'; 

$sql = "SELECT menu.*, GROUP_CONCAT(CONCAT(bahan.id, ' - ', bahan.nama_bahan, ' - ', detail_menu.kebutuhan) SEPARATOR ', ') as bahan FROM menu LEFT JOIN detail_menu ON menu.id = detail_menu.id_menu
LEFT JOIN bahan ON bahan.id = detail_menu.id_bahan WHERE tipe = 0 GROUP BY menu.id, menu.nama_menu";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}
echo json_encode($data);
$sqlBahan = "SELECT * FROM bahan";
$resultBahan = $conn->query($sqlBahan);
$dataBahan = array(); // initialize an empty array to store the rows
while ($row = $resultBahan->fetch_assoc()) {
    $dataBahan[] = $row; // append each row to the data array
}
$conn->close();

// echo json_encode($dataBahan);

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
                
                <div class="col">
                    <div class="card mt-3 border-danger">
                    <img src="./<?=$row['gambar']?>" class="card-img-top" alt="...">
                    <div class="card-body">
                    <h5 class="card-title text-danger"><?=$row['nama_menu']?></h5>
                    <p class="card-text text-gray-800"> <b>Harga :</b> Rp. <?=number_format($row['harga'], 0, ',', '.')?></p>
                

                        <button type="button" class="btn btn-warning btn-sm mb-2" data-toggle="modal" data-target="#editMenu<?=$key?>">
                            <i class="fas fa-fw fa-pencil-alt"></i><span> Edit</span>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#hapusMenu<?=$key?>">
                            <i class="fas fa-fw fa-trash-alt"></i><span>Hapus</span>
                          </button>  

                          <!-- Button trigger modal SELENGKAPNYA -->
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalSelengkapnya<?=$key?>">
                            Selengkapnya
                          </button>

                          <div class="modal fade" id="editMenu<?=$key?>" tabindex="-1" aria-labelledby="editMenuLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="editMenuLabel">Edit Menu</h1>
                                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                <div enctype="multipart/form-data" id="bahanEdit">
                                <!-- <ul id="itemListEdit" data-item="<?= $row['bahan']?>"> -->
                                      <?php
                                $bahan_array = explode(',', $row['bahan']); 
                                echo "<ul>";
                                foreach ($bahan_array as $bahan) {
                                    $bahan = trim($bahan);

                                  // Extract ID, nama_bahan, and quantity
                                  preg_match('/(\d+)\s*-\s*(.*?)\s*-\s*(\d+)/', $bahan, $matches);
                                  
                                  // Check if we have all necessary parts
                                  if (count($matches) == 4) {
                                      $id = $matches[1];
                                      $nama_bahan = $matches[2];
                                      $quantity = $matches[3];

                                      // Output the formatted string
                                      echo '<li>'.$nama_bahan.' (ID: '.$id.') - Amount: '.$quantity.'
                                      <button class="btn btn-sm btn-success btn-circle ml-1" id="increaseButton">+</button>
                                      <button class="btn btn-sm btn-warning btn-circle ml-1 decreaseButton" id="decreaseButton">-</button>
                                      <button id="removeButton" class="btn btn-sm btn-danger btn-circle ml-1"><i class="fas fa-trash">
                                      </i></button></li>';
                                  }
                                }

                                echo "</ul>";
                                ?>
                                  <!-- </ul> -->
                                  <div>
                                    <label for="nama_menu" class="form-label">Nama Menu</label>
                                    <input value="<?=$row['nama_menu']?>" type="text" placeholder="Nama Menu" autofocus name="nama_menu" class="form-control" >
                                  </div>
                                  <div>
                                    <label for="harga" class="form-label">Harga</label>
                                    <input value="<?=$row['harga']?>" type="text" placeholder="Harga" autofocus name="harga" class="form-control" >
                                  </div>
                                  <div>
                                    <label for="gambar" class="form-label">Gambar</label>
                                    <input value="<?=$row['gambar']?>" type="file" placeholder="Gambar" autofocus name="gambar" class="form-control">
                                  </div>
                                    <div>
                                      <label for="id_bahan" class="form-label">Bahan</label>
                                      <select name="id_bahan" class="form-control" id="id_bahanEdit" onchange="EditItemToList()">
                                          <option value="">Pilih Bahan</option> <!-- Option baru -->
                                          <?php foreach($dataBahan as $bahan): ?>
                                              <option data-id="<?= $bahan['nama_bahan']; ?>" value="<?= $bahan['id']; ?>"><?= $bahan['nama_bahan']; ?></option>
                                          <?php endforeach; ?>
                                      </select>
                                  </div>
                                  <div class="modal-footer">
                                  <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                  </div>
                                </div>
                                </div>
                              </div>
                            </div>
                          </div>
    
                          <div class="modal fade" id="hapusMenu<?=$key?>" tabindex="-1" aria-labelledby="hapusMenuLabel" aria-hidden="true">
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
                                  <a class="btn btn-danger" href="controllers/makananController.php?action=delete&id=<?=$row['id']?>">Hapus</a>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Modal SELENGKAPNYA -->
                        <div class="modal fade" id="exampleModalSelengkapnya<?=$key?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Bahan-bahan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <?php
                                $bahan_array = explode(',', $row['bahan']); 
                                echo "<ul>";
                                foreach ($bahan_array as $bahan) {
                                    $trimmed_bahan = preg_replace('/^\d+ - /', '', trim($bahan));
                                    echo "<li>$trimmed_bahan</li>";
                                }

                                echo "</ul>";
                                ?>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                    </div>
                </div>
            </div>

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
        <form action="controllers/makananController.php?action=add" method="POST" enctype="multipart/form-data" autocomplete="off" id="bahanAdd" required>
          <ul id="itemList">
    <!-- Rendered list items will appear here -->
        </ul>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Makanan</label>
                <input type="text" class="form-control" id="nama_menuAdd" name="nama_menu" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="hargaAdd" name="harga" min="0" step="0.01" required>

            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Menu</label> 
                <input type="file" class="form-control" id="gambarAdd" name="gambar" required>
            </div>

            <div>
              <label for="id_bahan" class="form-label">Bahan</label>
              <select name="id_bahan" class="form-control" id="id_bahanAdd" onchange="addItemToList()">
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
<!-- end modal Menu -->

<!-- /.container-fluid -->
<?php require 'partials/footer.php'; ?>

<script>
var itemListData = [];

const itemListEdit = document.getElementById("itemListEdit");
// const editData = itemListEdit.getAttribute("data-item");

// console.log(editData);
const increase = document.getElementById("increaseButton");
const decrease = document.getElementsByClassName("decreaseButton");
const remove = document.getElementById("removeButton");

console.log(decrease);
// decrease.onclick = function() {
//         if (item.amount > 1) {
//             item.amount--;
//             amountSpan.textContent = item.amount;
//         }
//     };

for (let index = 0; index < decrease.length; index++) {
  decrease[index].addEventListener("click", function(event) {
    console.log("decrease clicked");
      event.preventDefault();
  });
  
}
function addItemToList() {
    var select = document.getElementById("id_bahanAdd");
    // var selectEdit = document.getElementById("id_bahanEdit");
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
function EditItemToList() {
    var select = document.getElementById("id_bahanEdit");
    // var selectEdit = document.getElementById("id_bahanEdit");
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
        renderListItemEdit(item);

        // Reset the select to the default option
        select.selectedIndex = 0;
    }
}

// Fungsi untuk membuka modal tambah penjualan
function openModal() {
  
    itemListData = [];
    // Panggil fungsi untuk mengosongkan item list
    clearItemList();
    // Buka modal
    $('#modalMenu').modal('show');

}

// Tambahkan event listener untuk menangani pembukaan modal
$('#modalMenu').on('show.bs.modal', openModal);

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
    increaseButton.classList.add("btn","btn-sm","btn-success","btn-circle", "ml-1")
    increaseButton.id = "increaseButton"
    increaseButton.onclick = function() {
        item.amount++;
        amountSpan.textContent = item.amount;
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
            amountSpan.textContent = item.amount;
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

function renderListItemEdit(item) {
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
    increaseButton.classList.add("btn","btn-sm","btn-success","btn-circle", "ml-1")
    increaseButton.id = "increaseButton"
    increaseButton.onclick = function() {
        item.amount++;
        amountSpan.textContent = item.amount;
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
            amountSpan.textContent = item.amount;
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
    document.getElementById("itemListEdit").appendChild(listItem);
}

console.log(itemListData);

// Fungsi untuk mengosongkan item list
function clearItemList() {
    // Dapatkan referensi ke elemen ul item list
    var itemList = document.getElementById("itemList");
    // Kosongkan elemen ul item list
    itemList.innerHTML = "";

     // Mengosongkan input tanggal
    document.getElementById("id_bahanAdd").value = "";
    // Mengosongkan input harga
    // document.getElementById("id_bahanEdit").value = "";
}




const formAdd = document.getElementById("bahanAdd");
// const formEdit = document.getElementById("bahanEdit");
formAdd.addEventListener("submit", unSubmit); 

function unSubmit(e) {
  e.preventDefault();
  const menuAdd = document.getElementById("nama_menuAdd").value;
  const hargaAdd = document.getElementById("hargaAdd").value;
  const fileInput = document.getElementById('gambarAdd');

  const file = fileInput.files[0];
    const formData = new FormData(formAdd);

    formData.append('gambar', file);


    formData.append('nama_menu', menuAdd);
    formData.append('harga', hargaAdd);
    formData.append('item', JSON.stringify(itemListData));

    // formData.append('tipe', '1');

fetch('controllers/makananController.php?action=add', {
          method: 'POST', 
          body: formData
        })
        // .then(data=> data.json())
        // .then(data=> console.log(JSON.stringify(data)))
        .then(data=> location.reload(true))
    
    

        console.log(formData);
}



   


</script>


