<?php

/**
 * Digunakan untuk register manual.
 */

require "../../koneksi.php";
require "Validator.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // post request
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];

    $epassword = password_hash($password, PASSWORD_BCRYPT);

    // validasi data
    $validator = new Validator();
    $validUsername = $validator->isValidUsername($username);
    $validEmail = $validator->isValidEmail($email);
    $validName = $validator->isValidName($full_name);
    $validPassword = $validator->isValidPassword($password);

    // cek validasi data
    if ($validUsername["status"] === "error") {
        $response = $validUsername;
    } else if ($validEmail["status"] === "error") {
        $response = $validEmail;
    } else if ($validName["status"] === "error") {
        $response = $validName;
    } else if ($validPassword["status"] === "error") {
        $response = $validPassword;
    } else {
        // eksekusi query
        $sql = "SELECT 
        (SELECT username FROM users WHERE username = '$username') AS username,
        (SELECT email FROM users WHERE email = '$email') AS email;";
        $result = $conn->query($sql);

        // cek email terdaftar atau tidak
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();

            // cek apakah data username dan email null atau tidak
            if ($data['username'] !== null) {
                $response = array("status" => "error", "message" => "Username tersebut sudah terdaftar");
            } else if ($data['email'] !== null) {
                $response = array("status" => "error", "message" => "Email tersebut sudah terdaftar");
            } else {
                // get data user
                $sql = "INSERT INTO users VALUES (null, '$username', '$email', '$full_name', '$epassword', 'END USER', 0, 'default.png', NOW())";
                $result = $conn->query($sql);

                // jika register berhasil
                if ($result === true) {
                    $response = array("status" => "success", "message" => "Register Success");
                } else {
                    $response = array("status" => "error", "message" => "Register Gagal");
                }
            }
        }

        // close koneksi
        $conn->close();
    }
} else {
    $response = array("status" => "error", "message" => "not post method");
}

// show response
echo json_encode($response);
