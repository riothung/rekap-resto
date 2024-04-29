<?php 

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

require '../db.php';
$conn = OpenCon();

// echo json_encode($_POST);

switch ($action) {
    case 'add':
        if(isset($_POST['submit'])){
            $nama_bahan = $_POST['nama_bahan'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $sql = "INSERT INTO bahan (nama_bahan, harga, stok) VALUES ('$nama_bahan', '$harga', '$stok')";

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
            $conn->close();
            break;

        case 'edit':
            if(isset($_POST['submit'])){
            $nama_bahan = $_POST['nama_bahan'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $sql = "UPDATE bahan SET nama_bahan = '$nama_bahan', harga = '$harga', stok = '$stok' WHERE id = '$id'";

            // echo json_encode($_POST);

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
    }



        








?>