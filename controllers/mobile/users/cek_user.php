<?php
header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // koneksi ke database
        $conn = new mysqli("localhost", "root", "", "arenafinder");

        // jika koneksi gagal
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // post request
        $email = $_GET['email'];

        $sql = "SELECT email FROM users WHERE email = '$email' LIMIT 1";

        if($conn->query($sql)->num_rows == 1){
            $response = array("status"=>"success", "message"=>"Email tersebut terdaftar");
        }else{
            $response = array("status"=>"error", "message"=>"Email tersebut tidak terdaftar");
        }

        // close koneksi
        $conn->close();

        echo json_encode($response);
    }else{
        $response = array("status"=>"error", "message"=>"not get method");
        echo json_encode($response);
    }
?>