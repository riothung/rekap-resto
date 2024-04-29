<?php 

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

require '../db.php';
$conn = OpenCon();

// echo json_encode($_POST);

switch ($action) {
    case 'add':
        if(isset($_POST['submit'])){



            $tanggal = $_POST['tanggal'];
            $id_menu = $_POST['id_menu'];
            $shift = $_POST['shift'];
            $jumlah_penjualan = $_POST['jumlah_penjualan'];

            $sql = "INSERT INTO penjualan (tanggal, id_menu, shift, jumlah_penjualan) VALUES ('$tanggal', '$id_menu', '$shift', '$jumlah_penjualan')";

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

            $id_penjualan = $_REQUEST['id_penjualan'];                
            $tanggal = $_POST['tanggal'];
            $id_menu = $_POST['id_menu'];
            $shift = $_POST['shift'];
            $jumlah_penjualan = $_POST['jumlah_penjualan'];

            $sql = "UPDATE penjualan SET tanggal   = '$tanggal', id_menu = '$id_menu', shift = '$shift', jumlah_penjualan = '$jumlah_penjualan' WHERE id_penjualan = '$id_penjualan'";

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

                $id_penjualan = $_REQUEST['id_penjualan'];
                $tanggal = $_POST['tanggal'];
                $id_menu = $_POST['id_menu'];
                $shift = $_POST['shift'];
                $jumlah_penjualan = $_POST['jumlah_penjualan'];
                
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