<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Mengambil ID pegawai yang akan dihapus
  $id = $_GET['id'];

  // Menghubungkan ke database
  $host = '127.0.0.1';
  $dbname = 'classicmodels';
  $username = 'root';
  $password = '';

  try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hapus data pegawai dari tabel
    $stmt = $dbh->prepare("DELETE FROM classicmodels.pegawai WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect kembali ke halaman tampilan data pegawai
    header("Location: view.php");
    exit();
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>
