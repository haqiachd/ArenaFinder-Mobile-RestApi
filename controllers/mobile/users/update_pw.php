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
        $password = $_POST['password'];
        $epassword = password_hash($password, PASSWORD_BCRYPT);

        // get data user
        $sql = "UPDATE users SET password = '$epassword' WHERE email = '$email'";
        $result = $conn->query($sql);

        if($result === true){
            $response = array("status"=>"success", "message"=>"Password berhasil diupdate");
        }else{
            $response = array("status"=>"error", "message"=>"Password gagal diupdate");
        }

        // close koneksi
        $conn->close();

        echo json_encode($response);
    }else{
        echo 'error';
    }
?>