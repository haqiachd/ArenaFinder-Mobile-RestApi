<?php
/**
 * Digunakan untuk mengecek apakah alamat email terdaftar atau tidak didalam database.
 */

require "../../koneksi.php";

header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // get request
        $email = $_GET['email'];

        // eksekusi query
        $sql = "SELECT email FROM users WHERE email = '$email' LIMIT 1";

        // cek email terdaftar atau tidak
        if($conn->query($sql)->num_rows == 1){
            $response = array("status"=>"success", "message"=>"Email tersebut terdaftar");
        }else{
            $response = array("status"=>"error", "message"=>"Email tersebut tidak terdaftar");
        }

        // close koneksi
        $conn->close();
    }else{
        $response = array("status"=>"error", "message"=>"not get method");
    }

    // show response
    echo json_encode($response);
?>