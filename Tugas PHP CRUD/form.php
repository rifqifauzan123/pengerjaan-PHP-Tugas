<!DOCTYPE html>
<html>
<head>
  <title>Form Data Pegawai</title>
</head>
<body>
  <h2>Form Data Pegawai</h2>

  <?php
  // Menghubungkan ke database
  $host = '127.0.0.1';
  $dbname = 'classicmodels';
  $username = 'root';
  $password = '';

  try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengambil data pegawai jika ID ada
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $pegawai = null;
    if ($id) {
      $stmt = $dbh->prepare("SELECT * FROM classicmodels.pegawai WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      $pegawai = $stmt->fetch();
    }
    ?>

    <!-- Form input/edit data pegawai -->
    <form action="<?php echo $id ? 'update.php' : 'save.php'; ?>" method="POST">
      <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo $pegawai['id']; ?>">
      <?php endif; ?>

      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" value="<?php echo $pegawai ? $pegawai['nama'] : ''; ?>" required><br><br>

      <label for="umur">Umur:</label>
      <input type="number" id="umur" name="umur" value="<?php echo $pegawai ? $pegawai['umur'] : ''; ?>" required><br><br>

      <label for="alamat">Alamat:</label>
      <textarea id="alamat" name="alamat" required><?php echo $pegawai ? $pegawai['alamat'] : ''; ?></textarea><br><br>

      <input type="submit" value="<?php echo $id ? 'Update' : 'Simpan'; ?>">
    </form>

    <?php
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>

</body>
</html>