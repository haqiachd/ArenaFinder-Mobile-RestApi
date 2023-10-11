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

// Ambil data dari formulir registrasi
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Anda bisa menambahkan input lainnya sesuai kebutuhan

// Lakukan query untuk menyimpan data pengguna baru ke dalam database
$sql = "INSERT INTO user VALUES (null, '$username', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
    echo "Registrasi berhasil. Silakan login <a href='login.php'>di sini</a>.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi ke database
$conn->close();
?>
