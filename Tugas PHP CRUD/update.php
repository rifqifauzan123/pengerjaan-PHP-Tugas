<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil nilai input dari form
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $umur = $_POST['umur'];
  $alamat = $_POST['alamat'];

  // Menghubungkan ke database
  $host = '127.0.0.1';
  $dbname = 'classicmodels';
  $username = 'root';
  $password = '';

  try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update data pegawai di dalam tabel
    $stmt = $dbh->prepare("UPDATE pegawai SET nama = :nama, umur = :umur, alamat = :alamat WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':umur', $umur);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->execute();

    header("Location: view.php");
    exit();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  
}
?>
