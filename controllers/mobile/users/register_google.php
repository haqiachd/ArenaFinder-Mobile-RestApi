<?php
/**
 * Digunakan untuk register dengan google.
 */

 require "../../koneksi.php";

header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
        // post request
        $username = $_POST['username'];
        $email = $_POST['email'];
        $full_name = $_POST['full_name'];
        $password = $_POST['password'];

        $epassword = password_hash($password, PASSWORD_BCRYPT);

        // get data user
        $sql = "INSERT INTO users VALUES (null, '$username', '$email', '$full_name', '$epassword', 'END USER', 1, 'default.png')";
        $result = $conn->query($sql);

        // jika data berhasil ditambahkan
        if($result === true){
            // mendapatkan data
            $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = $conn->query($sql);

            // jika data berhasil didapatkan
            if($result->num_rows == 1){
                $response = array("status"=>"success", "message"=>"Register Success", "data"=>$result->fetch_assoc());
            }else{
                $response = array("status"=>"error", "message"=>"Register berhasil tetapi data akun gagal didapatkan");
            }
        }else{
            $response = array("status"=>"error", "message"=>"Register Gagal");
        }

        // close koneksi
        $conn->close();

    }else{
        $response = array("status"=>"error", "message"=>"not post method");
    }

    // show response
    echo json_encode($response);
?>