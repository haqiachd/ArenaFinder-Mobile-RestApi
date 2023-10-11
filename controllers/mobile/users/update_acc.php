<?php
header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // koneksi ke database
        $conn = new mysqli("localhost", "root", "", "arenafinder");

        // jika koneksi gagal
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // post request
        $email = $_POST['email'];
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];

        // get data user
        $sql = "UPDATE users SET username = '$username', full_name = '$full_name' WHERE email = '$email'";
        $result = $conn->query($sql);

        if($result === true){
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);

            if($result->num_rows == 1){
                $response = array("status"=>"success", "message"=>"Edit akun berhasil diupdate", "data"=>$result->fetch_assoc());
            }else{
                $response = array("status"=>"error", "message"=>"Edit akun berhasil tetapi data gagal didapatkan");
            }
    
        }else{
            $response = array("status"=>"error", "message"=>"Edit akun gagal diupdate");
        }

        // close koneksi
        $conn->close();

        echo json_encode($response);
    }else{
        echo 'error';
    }
?>