<?php 

require './partials/header.php'; 

$sql = "SELECT menu.*, GROUP_CONCAT(bahan.nama_bahan SEPARATOR ', ') as bahan FROM menu LEFT JOIN detail_menu ON menu.id = detail_menu.id_menu
LEFT JOIN bahan ON bahan.id = detail_menu.id_bahan WHERE tipe = 0 GROUP BY menu.id, menu.nama_menu";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}

// echo json_encode($data);

$sqlBahan = "SELECT * FROM bahan";
$resultBahan = $conn->query($sqlBahan);
$dataBahan = array(); // initialize an empty array to store the rows
while ($row = $resultBahan->fetch_assoc()) {
    $dataBahan[] = $row; // append each row to the data array
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
                
                <div class="col">
                    <div class="card mt-3 border-danger">
                    <img src="./<?=$row['gambar']?>" style="height: 250px;" class="card-img-top" alt="Gambar Rusak">
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
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalSelengkapnya<?=$key?>" id="<?= $row['id']?>">
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
                                <form action="controllers/makananController.php?action=edit&id=<?=$row['id']?>" method="POST" enctype="multipart/form-data" class="w-100 d-flex flex-column gap-3 bg-white rounded p-4 autocomplete="off">
                                  
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
                                  <div class="modal-footer">
                                  <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                  </div>
                                </form>
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
                        <div class="modal fade selengkapnya" id="exampleModalSelengkapnya<?=$key?>" token="<?= $row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Bahan-bahan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body" id="getBahan<?=$row['id']?>" data-id="<?= $row['id']?>">

                              </div>
                               <ul id="itemListEdit<?=$row['id']?>">
                            <!-- Rendered list items will appear here -->
                                </ul>
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

const getBahan = document.getElementsByClassName('selengkapnya');


  // const dataItem = document.querySelector('[data-item]');
  // console.log(dataItem.getAttribute('data-item'));
function addItemToList() {
    var select = document.getElementById("id_bahanAdd");
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

// Fungsi untuk membuka modal tambah penjualan
function openModal() {
  
    itemListData = [];
    // Panggil fungsi untuk mengosongkan item list
    clearItemList();
    // Buka modal
    $('#modalBahan').modal('show');
}

const bahanList = []
// Fungsi untuk membuka modal tambah penjualan
function bahanModal(event) {
    const bahanId = event.target.getAttribute('token'); // Get the id from the data-id attribute of the related target
    // const listItem = []
    return fetch('controllers/getBahan.php?id=' + bahanId)
    .then(response => response.json())
    .then(data => {
        const bahanElement = document.getElementById('itemListEdit' + bahanId); // Use the bahanId to get the correct element
        bahanList.push(data)
        bahanElement.innerHTML = ''; // Clear previous data
        data.forEach(item => {
            renderListItemEdit(item, bahanId);
          });
          return data

          
        })
        
    .catch(error => console.error('Error:', error));
}


// Tambahkan event listener untuk menangani pembukaan modal
$('#modalBahan').on('show.bs.modal', openModal);
$('.selengkapnya').each(function() {
  const submit = document.createElement('button')
    submit.innerHTML = 'Submit'
    submit.classList.add('btn')
    submit.classList.add('btn-warning')
    $(this)[0].children[0].children[0].children[3].append(submit)

  $(this).on('show.bs.modal', (e) => {
    bahanModal(e).then(items => {
      submit.onclick = () => {
        console.log(items)
        fetch('controllers/makananController.php?action=editBahan', {
          method: 'POST', 
          body: JSON.stringify({item: items})
        })
        // .then(data=> data.json())
        // .then(data=> console.log(JSON.stringify(data)))
        .then(data=> location.reload(true))
      }
    });
  });
  
});

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

function renderListItemEdit(item, bahanId) {
  // console.log("hoiiii")
    // Create list item element
    var listItem = document.createElement("li");
    listItem.dataset.id = item.id;

    // Create a span for the item name
    var itemName = document.createElement("span");
    itemName.textContent = item.nama_bahan + " (ID: " + item.id + ") - Amount: ";
    listItem.appendChild(itemName);

    // Create a span for the amount
   var amountSpan = document.createElement("input");
    amountSpan.type = "number";
    amountSpan.step = "0.01";
    amountSpan.value = item.kebutuhan;
    amountSpan.onchange = function() {
        item.kebutuhan = amountSpan.value;
    };
    listItem.appendChild(amountSpan);

    // Create buttons to adjust amount
    var increaseButton = document.createElement("button");
    increaseButton.textContent = "+";
    increaseButton.classList.add("btn","btn-sm","btn-success","btn-circle", "ml-1")
    increaseButton.id = "increaseButton"
    increaseButton.onclick = function() {
        item.kebutuhan++;
        amountSpan.value = item.kebutuhan;
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
        if (item.kebutuhan > 1) {
            item.kebutuhan--;
            amountSpan.value = item.kebutuhan;
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
    const itemListEdit = document.getElementById("itemListEdit" + bahanId);
    // console.log(document.getElementById("itemListEdit"))
    // console.log(item.id, "HALOOO")
    if (itemListEdit) { // Check if itemListEdit exists
        itemListEdit.appendChild(listItem);
    } else {
        console.error("Element with ID 'itemListEdit' not found in the document.");
    }
}


// Fungsi untuk mengosongkan item list
function clearItemList() {
    // Dapatkan referensi ke elemen ul item list
    var itemList = document.getElementById("itemList");
    // Kosongkan elemen ul item list
    itemList.innerHTML = "";

     // Mengosongkan input tanggal
    document.getElementById("nama_menuAdd").value = "";
    // Mengosongkan input harga
    document.getElementById("hargaAdd").value = "";
}




const formAdd = document.getElementById("bahanAdd");
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
    
    

}


fetch('controllers/getBahan.php?id=40')

.then(data=> data.json())
.then(data=> console.log(data))


   


</script>


