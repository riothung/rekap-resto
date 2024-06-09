<?php 

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

$id_kategori = isset($_REQUEST['id_kategori']) ? $_REQUEST['id_kategori'] : null;
// $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

require '../db.php';
$conn = OpenCon();

// echo json_encode($_POST);

switch ($action) {
    case 'add':
        if(isset($_POST['submit'])){
            $tanggal = $_POST['tanggal'];
            $nama_bahan = $_POST['nama_bahan'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $satuan = $_POST['satuan'];
            $id_kategori = $_POST['id_kategori'];

            $sql = "INSERT INTO bahan (tanggal, nama_bahan, harga, stok, satuan, id_kategori) VALUES ('$tanggal', '$nama_bahan', '$harga', '$stok', '$satuan', '$id_kategori')";
            
                try {
                    $result = $conn->query($sql);
                    $_SESSION['success-alert'] = 'Berhasil menambah data';
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }catch(PDOException $e){
                    $_SESSION['failed-alert'] = 'Gagal menambah data';
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            
            }
        if(isset($_POST['submitKategori'])){
            $kategori = $_POST['kategori'];

            $sqlKategori = "INSERT INTO kategori_bahan (kategori) VALUES ('$kategori')";

            try{
                $resultKategori = $conn->query($sqlKategori);
                $_SESSION['success-alert'] = 'Berhasil menambah data';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }catch(PDOException $e){
                $_SESSION['failed-alert'] = 'Gagal menambah data';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
            $conn->close();
            break;

        case 'addBahanMasuk':
        if(isset($_POST)){

            $json_data = file_get_contents('php://input');

            // Decode JSON data into PHP array
            $item = json_decode($_POST['item'], true);
        
            // echo json_encode($formData);
            echo json_encode($_POST['tanggal']);
            // Assign variables
            $tanggal = $_POST['tanggal'];
            // $nama_bahan = $formData['nama'];

            // Prepare an array to store the result
            $result = array();
            $sql = "INSERT INTO bahan_transaksi (tanggal) VALUES ('$tanggal')";
            if($result = $conn->query($sql)){  
            $last_insert_id = $conn->insert_id;
            foreach ($item as $item_data) {
                    
                    $id_bahan = $item_data["id"];
                    $amount = $item_data["amount"];

                    // Assuming $id_penjualan and $id_menu are sanitized properly to prevent SQL injection
                    $sqlBahanMasuk = "INSERT INTO bahan_masuk (id_bahan, id_transaksi, stok_masuk) VALUES ('$id_bahan','$last_insert_id', '$amount')";

                    $update = "UPDATE bahan SET stok = stok + $amount WHERE id = '$id_bahan'";

                    if ($conn->query($sqlBahanMasuk)) {
                        // If successful, add success message to result array
                        $result = $conn->query($update);
                        echo json_encode("sukses papa");
                        // header("Location: " . $_SERVER['HTTP_REFERER']);
                        // exit();
                    } else {
                        echo json_encode("gagal papa");
                        // header("Location: " . $_SERVER['HTTP_REFERER']);
                        // exit();
                        
                    }
             
                }
            }
        }
            break;

        case 'edit':
            if(isset($_POST['submit'])){

            $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;                
            $tanggal = $_POST['tanggal'];
            // $kategori = $_POST['kategori'];
            $nama_bahan = $_POST['nama_bahan'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $satuan = $_POST['satuan'];

            $sql = "UPDATE bahan SET tanggal = '$tanggal', nama_bahan = '$nama_bahan', harga = '$harga', stok = '$stok', satuan = '$satuan' WHERE id = '$id'";

            // echo json_encode($_REQUEST);

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
        if(isset($_POST['submitEdit'])){
            $id = $_REQUEST['id'];
            $kategori = $_POST['kategori'];

            $sql = "UPDATE kategori_bahan SET kategori = '$kategori' WHERE id = '$id'";

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

                $id = $_REQUEST['id'];
                $tanggal = $_POST['tanggal'];
                // $kategori = $_POST['kategori'];
                $nama_bahan = $_POST['nama_bahan'];
                $harga = $_POST['harga'];
                $stok = $_POST['stok'];
                
                $sql = "DELETE FROM bahan WHERE id = '$id'";
                
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

            case 'deleteKategori':

                $id_kategori = isset($_REQUEST['id_kategori']) ? $_REQUEST['id_kategori'] : null;
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
                
                $queryBahan = "SELECT * FROM bahan WHERE id_kategori = '$id_kategori'";
                // $result = $conn->query($queryBahan);
                // $data = array();
                // while ($row = $result->fetch_assoc()) {
                //     $data[] = $row;
                // }
                
                $sql = "DELETE FROM bahan WHERE id_kategori = '$id_kategori'";
                $sqlKategori = "DELETE FROM kategori_bahan WHERE id = '$id_kategori'";

                // echo json_encode($_REQUEST);

                try{
                    $result = $conn->query($sql);
                    $resultKategori = $conn->query($sqlKategori);
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