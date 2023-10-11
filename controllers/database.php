<?php
class Database
{
    private static $host = "localhost"; 
    private static $username = "root"; 
    private static $password = ""; 
    private static $database = "arenafinder"; 

    private static $connection;

    // Fungsi untuk membuat koneksi ke database
    public static function connect()
    {
        if (!isset(self::$connection)) {
            try {
                self::$connection = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$database, self::$username, self::$password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Koneksi ke database gagal: " . $e->getMessage());
            }
        }
        return self::$connection;
    }

    // Fungsi untuk menutup koneksi ke database
    public static function disconnect()
    {
        self::$connection = null;
    }
}
?>
