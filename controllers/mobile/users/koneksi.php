<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$database = "arenafinder";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Set karakter encoding ke UTF-8 (opsional)
mysqli_set_charset($conn, "utf8");

// Selanjutnya, Anda dapat menggunakan variabel $conn untuk menjalankan query ke database.
?>