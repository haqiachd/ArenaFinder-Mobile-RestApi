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
        $username = $_POST['email'];
        $password = $_POST['password'];

        // get data user
        $sql = "SELECT * FROM users WHERE email = '$username' OR username = '$username' LIMIT 1";
        $result = $conn->query($sql);

        // jika username exist
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc(); // get user data
            // jika password match
            if (password_verify($password, $user['password'])) {
            // if ($password == $user['password']) {
                $response = array('status' => 'success', 'message' => 'Login berhasil', 'data' => $user);
            } else {
                // Kata sandi salah
                $response = array('status' => 'error', 'message' => 'Kata sandi salah');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Pengguna tidak ditemukan');
        }

        // close koneksi
        $conn->close();

        echo json_encode($response);
    }else{
        echo 'error';
    }
?>