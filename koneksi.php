<?php
$konek = mysqli_connect("localhost", "root", "", "streaming_music");
if (!$konek) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>