<?php 

require '../db.php';
$conn = OpenCon();  

    if(isset($_GET['id'])) {
    $id_menu = $_GET['id'];
    $join = "SELECT * FROM detail_menu JOIN bahan ON bahan.id = detail_menu.id_bahan WHERE detail_menu.id_menu = '$id_menu' AND bahan.stok < 1";
                    
    $joinT = $conn->query($join);
    $joinTable = $joinT->fetch_assoc();
    if ($joinT->num_rows > 0) {
        echo json_encode(array(
    "success" => FALSE,
    "nama_bahan" => $joinTable['nama_bahan']
));
    }else{
        echo json_encode(array(
    "success" => TRUE
));
    }
}


?>