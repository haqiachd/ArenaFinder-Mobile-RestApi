<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "arenafinder";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil data dari formulir login
$username = $_POST['username'];
$password = $_POST['password'];

// Lakukan query ke database untuk memeriksa data login
$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

// Periksa apakah data cocok atau tidak
if ($result->num_rows > 0) {
    // Data cocok, berikan akses
    header("Location: beranda.html"); // Ganti dengan halaman yang sesuai
} else {
    // Data tidak cocok, tampilkan pesan kesalahan
    echo "Username atau password salah.";
}

// Tutup koneksi ke database
$conn->close();
?>
