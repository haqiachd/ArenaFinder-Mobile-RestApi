<?php
// konfigurasi database
$server = "localhost";
$username = "root";
$password = "";
$database = "arenafinder";

// membuat koneksi ke databae
$conn = new mysqli($server, $username, $password, $database);

// cek koneksi berhasil atau tidak
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>
