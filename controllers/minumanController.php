<?php 

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

require '../db.php';
$conn = OpenCon();

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


switch ($action) {
    case 'add':
        if(isset($_POST['submit'])){
            $minuman = $_POST['minuman'];
            $harga = $_POST['harga'];

            /* tambah foto */
            $gambar = $_FILES['gambar'];
            echo json_encode($gambar);
            $target_dir = "../assets/img/";
            // $target_file = $target_dir . $gambar;
            $random_string = uniqid();
            $target_file = $target_dir . $random_string . '.' . pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $gambarFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $size_gambar = isset($_FILES['gambar']['size']);
            // $random_name = generateRandomString(10);
            // $new_gambar = $random_name . "." . $gambarFileType;
            
            // $target_dir = "../assets/img/";
            if (!move_uploaded_file($gambar["tmp_name"], $target_file)) {
                // handle the error
                die('Error moving file.');
            }
            
            $basename = basename($target_file);
            $imagePath = 'assets/img/' . $basename;
            
            $sql = "INSERT INTO minuman (minuman, harga, gambar) VALUES ('$minuman', '$harga', '$imagePath')";
            // echo json_encode($_FILES);
            // echo $target_dir. "<br>";
            // echo $new_gambar. "<br>";
            // echo $target_file. "<br>";
            // echo $gambarFileType. "<br>";
            // echo $gambar. "<br>";

            try {
                if($gambar == null){
                    if($size_gambar > 5000000){
                        echo '<div class="alert alert-warning mt-2 text-center" role="alert">
                            Ukuran gambar terlalu besar dari 5mb
                        </div>';
                    }else{
                        if($gambarFileType != "jpg" && $gambarFileType != "png" && $gambarFileType != "jpeg" && $gambarFileType != "gif"){
                            echo '<div class="alert alert-warning mt-2 text-center" role="alert">
                            file tidak disupport!!
                        </div>';
                    }else{
                        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_dir . $new_gambar);
                    }
                }
            }
                $result = $conn->query($sql);
                $_SESSION['success-alert'] = 'Berhasil menambah minuman';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }catch(PDOException $e){
            $_SESSION['failed-alert'] = 'Gagal menambah minuman';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
            }
        }
            $conn->close();
            break;

        case 'edit':
            if(isset($_POST['submit'])){

            $id = $_REQUEST['id'];

            $minuman = $_POST['minuman'];
            $harga = $_POST['harga'];
            $gambar = $_FILES['gambar'];

            /* edit foto */
            
            $result = $conn->query("SELECT minuman.gambar FROM minuman WHERE id='$id'");
            $data = $result->fetch_assoc();

            $target_dir = "../assets/img/";
            $random_string = uniqid();
            $target_file = $target_dir . $random_string . '.' . pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);

            if ($gambar['error'] > 0) {
                $sql = "UPDATE minuman SET minuman = '$minuman', harga = '$harga' WHERE id = '$id'";
            }else{

            if(empty($data['gambar'])){
                if (!move_uploaded_file($gambar["tmp_name"], $target_file)) {
                // handle the error
                die('Error moving file.');
                }
                $basename = basename($target_file);
                $imagePath = 'assets/img/' . $basename;
                $sql = "UPDATE minuman SET minuman = '$minuman', harga = '$harga', gambar = '$imagePath' WHERE id = '$id'";

            }else{
                $filename = '../' . $data['gambar'];
                if (file_exists($filename)) {
                unlink($filename);
                }
                if (!move_uploaded_file($gambar["tmp_name"], $target_file)) {
                // handle the error
                die('Error moving file.');
                }
                $basename = basename($target_file);
                $imagePath = 'assets/img/' . $basename;
                $sql = "UPDATE minuman SET minuman = '$minuman', harga = '$harga', gambar = '$imagePath' WHERE id = '$id'";
            }
        }

            


            // echo json_encode($_POST);

            try{
                if($gambar == null){
                    if($size_gambar > 5000000){
                        echo '<div class="alert alert-warning mt-2 text-center" role="alert">
                            Ukuran gambar terlalu besar dari 5mb
                        </div>';
                    }else{
                        if($gambarFileType != "jpg" && $gambarFileType != "png" && $gambarFileType != "jpeg" && $gambarFileType != "gif"){
                            echo '<div class="alert alert-warning mt-2 text-center" role="alert">
                            file tidak disupport!!
                        </div>';
                        }else{
                        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_dir . $new_gambar);
                    }
                }
            }
                $result = $conn->query($sql);
                $_SESSION['success-alert'] = 'Berhasil merubah minuman';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();

            }catch(PDOException $e){
            $_SESSION['failed-alert'] = 'Gagal merubah minuman';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
            }
        }
            $conn->close();
            break;



            case 'delete':

                $id = $_REQUEST['id'];
                $sql1 = "SELECT gambar FROM minuman WHERE id = $id";
                $result1 = $conn->query($sql1);
                $row = $result1->fetch_assoc();
                $filename = '../' . $row['gambar'];

                // Delete the file from the server
                if (file_exists($filename)) {
                    unlink($filename);
                }

                $sql = "DELETE FROM minuman WHERE id='$id'";

                try{

                $result = $conn->query($sql);
                $_SESSION['success-alert'] = 'Berhasil menghapus minuman';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();

                }catch(PDOException $e){
                $_SESSION['failed-alert'] = 'Gagal menghapus minuman';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();

            }
            $conn -> close();
            break;
        }



        








?>