<?php
/**
 * Digunakan untuk register manual.
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
        $sql = "INSERT INTO users VALUES (null, '$username', '$email', '$full_name', '$epassword', 'END USER', 0, 'default.png')";
        $result = $conn->query($sql);

        // jika register berhasil
        if($result === true){
            $response = array("status"=>"success", "message"=>"Register Success");
        }else{
            $response = array("status"=>"error", "message"=>"Register Gagal");
        }

        // close koneksi
        $conn->close();

        echo json_encode($response);
    }else{
        $response = array("status"=>"error", "message"=>"not post method");
    }

    // show response
    echo json_encode($response);
?>