<?php
/**
 * Digunakan untuk mengecek apakah userid (username dan email) terdaftar atau tidak didalam database.
 */

require "../../koneksi.php";

header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // get request
        $username = $_GET['username'];
        $email = $_GET['email'];

        // eksekusi query
        $sql = "SELECT 
        (SELECT username FROM users WHERE username = '$username') AS username,
        (SELECT email FROM users WHERE email = '$email') AS email;";

    $result = $conn->query($sql);

        // cek email terdaftar atau tidak
        if($result->num_rows == 1){
            $data = $result->fetch_assoc();

            $response = array();
            
            // Periksa apakah data username dan email null atau tidak
            if ($data['username'] !== null) {
                $response = array("status" => "success", "message" => "Username tersebut sudah terdaftar");
            } else if ($data['email'] !== null) {
                $response = array("status" => "success", "message" => "Email tersebut sudah terdaftar");
            } else {
                $response = array("status"=>"error", "message"=>"Userid tersebut tidak terdaftar");
            }
            
        }

        // close koneksi
        $conn->close();
    }else{
        $response = array("status"=>"error", "message"=>"not get method");
    }

    // show response
    echo json_encode($response);
?>