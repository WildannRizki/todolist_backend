<?php
// database.php

$servername = "localhost:3307"; // ganti sesuai dengan server database Anda
$username = "root";        // ganti sesuai dengan username database Anda
$password = "";            // ganti sesuai dengan password database Anda
$dbname = "todolist_db";      // ganti sesuai dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>