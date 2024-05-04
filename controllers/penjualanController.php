<?php 

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

require '../db.php';
$conn = OpenCon();

// echo json_encode($_POST);

switch ($action) {
    case 'add':

        // echo json_encode($_POST);
            $json_data = file_get_contents('php://input');

        // Decode JSON data into PHP array
        $formData = json_decode($json_data, true);
        
            // Assign variables
            $tanggal = $formData['tanggal'];
            $shift = $formData['shift'];
            $total_harga = $formData['total_harga'];
            

            $item = $formData['item'];

            // Prepare an array to store the result
            $result = array();
            $sqlPenjualan = "INSERT INTO penjualan (tanggal, shift, jumlah_penjualan, total_harga) VALUES ('$tanggal', '$shift', 1, '$total_harga')";

            
            
            if ($conn->query($sqlPenjualan) === TRUE) {
                $last_insert_id = $conn->insert_id;
                foreach ($item as $item_data) {
                $id_menu = $item_data["id"];
                $amount = $item_data["amount"];

                // Assuming $id_penjualan and $id_menu are sanitized properly to prevent SQL injection
                $sql = "INSERT INTO detail_penjualan (id_penjualan, id_menu, amount) VALUES ('$last_insert_id', '$id_menu', '$amount')";

                // Execute the query
                if ($conn->query($sql)) {
                    // If successful, add success message to result array
                    $result[] = array(
                        "success" => $last_insert_id,
                        "message" => "Record inserted successfully for item with id $id_menu"
                    );
                } else {
                    // If failed, add error message to result array
                    $result[] = array(
                        "success" => false,
                        "message" => "Error inserting record for item with id $id_menu: " . mysqli_error($conn)
                    );
                }
            }    
                // If successful, add success message to result array

                } else {
                    // If failed, add error message to result array
                    $result[] = array(
                        "success" => false,
                        "message" => "Error inserting record for item with id $id_menu: " . mysqli_error($conn)
                    );
                }

            // Loop through each item in the array and insert it into the database
            

            // Encode result array as JSON and echo it
            echo json_encode($result);
        
        // break;



            // $sql = "INSERT INTO detail_penjualan (id_penjualan, id_menu) VALUES ('$id_penjualan', '$id_menu')";
            
            // $sql = "INSERT INTO penjualan (tanggal, id_menu, shift, jumlah_penjualan, total_harga) VALUES ('$tanggal', '$id_menu', '$shift', '$jumlah_penjualan', '$total_harga')";
            // try {
            //     $result = $conn->query($sql);
            //     $_SESSION['success-alert'] = 'Berhasil menambah data';
            //     header("Location: " . $_SERVER['HTTP_REFERER']);
            //     exit();
            // }catch(PDOException $e){
            //     $_SESSION['failed-alert'] = 'Gagal menambah data';
            //     header("Location: " . $_SERVER['HTTP_REFERER']);
            //     exit();
            // }
        
            $conn->close();
            break;

        case 'edit':
            if(isset($_POST['submit'])){
            
            $id_penjualan = isset($_POST['id_penjualan']) ? $_POST['id_penjualan'] : null;
            $id_penjualan = $_REQUEST['id_penjualan'];             
            $tanggal = $_POST['tanggal'];
            $id_menu = $_POST['id_menu'];
            $shift = $_POST['shift'];
            $jumlah_penjualan = $_POST['jumlah_penjualan'];
            $total_harga = $_POST['total_harga'];

            // echo json_encode($_POST);

            $sql = "UPDATE penjualan SET tanggal = '$tanggal', id_menu = '$id_menu', shift = '$shift', jumlah_penjualan = '$jumlah_penjualan', total_harga = '$total_harga' WHERE id_penjualan = '$id_penjualan'";

            try{
                $result = $conn->query($sql);
                $_SESSION['success-alert'] = 'Berhasil merubah data';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }catch(PDOException $e){
                $_SESSION['failed-alert'] = 'Gagal merubah data';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
            $conn->close();
            break;

            case 'delete':
                $id_penjualan = isset($_GET['id_penjualan']) ? $_GET['id_penjualan'] : null;
                $id_penjualan = $_REQUEST['id_penjualan'];
                $tanggal = $_POST['tanggal'];
                $id_menu = $_POST['id_menu'];
                $shift = $_POST['shift'];
                $jumlah_penjualan = $_POST['jumlah_penjualan'];
                $total_harga = $_POST['total_harga'];
                
                $sql = "DELETE FROM penjualan WHERE id_penjualan = '$id_penjualan'";

                try{
                    $result = $conn->query($sql);
                    $_SESSION['success-alert'] = 'Berhasil menghapus data';
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }catch(PDOException $e){
                    $_SESSION['failed-alert'] = 'Gagal menghapus data';
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
            }
            $conn -> close();
            break;
    }



        








?>