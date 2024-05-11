<?php 

require '../db.php';
$conn = OpenCon();  

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

    $sql = "SELECT detail_menu.*, bahan.nama_bahan FROM menu LEFT JOIN detail_menu ON menu.id = detail_menu.id_menu
    LEFT JOIN bahan ON bahan.id = detail_menu.id_bahan WHERE menu.id = '$id'";
    $result = $conn->query($sql);
 // initialize an empty array to store the rows

    $rows = array();
    
    // Fetch all rows and store them in the array
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    
    // Output the array as JSON
    echo json_encode($rows);
    
}

?>