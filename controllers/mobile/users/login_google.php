<?php

/**
 * Digunakan untuk login dengan google.
 */

require "../../koneksi.php";
require "Validator.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // post request
    $email = $_POST['email'];

    // cek validasi data
    $validator = new Validator();
    $validEmail = $validator->isValidEmail($email);

    if ($validEmail['status'] === "error") {
        $response = $validEmail;
    } else {
        // get data user
        $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = $conn->query($sql);

        // jika email exist
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc(); // get user data
            $response = array('status' => 'success', 'message' => 'Login berhasil', 'data' => $user);
        } else {
            $response = array('status' => 'error', 'message' => 'Email tersebut belum terdaftar.');
        }

        // close koneksi
        $conn->close();
    }
} else {
    $response = array("status" => "error", "message" => "not post method");
}

// show response
echo json_encode($response);
