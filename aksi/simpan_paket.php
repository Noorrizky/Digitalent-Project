<?php
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "digitalent";  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nama_pemesanan = $_POST['nama_pemesanan'];
$nomor_hp = $_POST['nomor_hp'];
$tanggal_pesan = $_POST['tanggal_pesan'];
$pelayanan_paket = implode(',', $_POST['pelayanan_paket']);
$jumlah_peserta = $_POST['jumlah_peserta'];
$jumlah_hari = $_POST['jumlah_hari']; // Added field
$total_harga_paket = $_POST['total_harga_paket'];
$total_jumlah_tagihan = $_POST['total_jumlah_tagihan'];

$sql = "INSERT INTO daftar_paket (nama_pemesanan, nomor_hp, tanggal_pesan, pelayanan_paket, jumlah_peserta, jumlah_hari, total_harga_paket, total_jumlah_tagihan)
        VALUES ('$nama_pemesanan', '$nomor_hp', '$tanggal_pesan', '$pelayanan_paket', '$jumlah_peserta', '$jumlah_hari', '$total_harga_paket', '$total_jumlah_tagihan')";

if ($conn->query($sql) === TRUE) {
    echo "Data successfully saved";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>