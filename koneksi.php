<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "music_streaming";

$konek = new mysqli($host, $username, $password, $database);

if ($konek->connect_error) {
    die("Connection failed: " . $konek->connect_error);
}
?>
