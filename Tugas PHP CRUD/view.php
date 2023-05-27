<!DOCTYPE html>
<html>
<head>
  <title>Data Pegawai</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .add-btn {
      display: inline-block;
      padding: 6px 12px;
      text-decoration: none;
      color: #fff;
      background-color: #337ab7;
      border: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .add-btn:hover {
      background-color: #23527c;
    }

    .edit-btn, .delete-btn {
      display: inline-block;
      padding: 6px 12px;
      text-decoration: none;
      color: #fff;
      background-color: #337ab7;
      border: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .edit-btn:hover, .delete-btn:hover {
      background-color: #23527c;
    }

    .delete-btn {
      background-color: #d9534f;
    }

    .delete-btn:hover {
      background-color: #b52e28;
    }
  </style>
</head>
<body>
  <h2>Data Pegawai</h2>

  <?php
  // Menghubungkan ke database
  $host = '127.0.0.1';
  $dbname = 'classicmodels';
  $username = 'root';
  $password = '';

  try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengambil data pegawai dari tabel
    $stmt = $dbh->prepare("SELECT * FROM classicmodels.pegawai");
    $stmt->execute();
    $pegawai = $stmt->fetchAll();

    if (count($pegawai) > 0) {
      echo '
      <table>
        <tr>
          <th>Nama</th>
          <th>Umur</th>
          <th>Alamat</th>
          <th>Aksi</th>
        </tr>';

      foreach ($pegawai as $data) {
        echo '
        <tr>
          <td>' . $data['nama'] . '</td>
          <td>' . $data['umur'] . '</td>
          <td>' . $data['alamat'] . '</td>
          <td>
            <a class="edit-btn" href="form.php?id=' . $data['id'] . '">Edit</a>
            <a class="delete-btn" href="hapus.php?id=' . $data['id'] . '">Hapus</a>
          </td>
        </tr>';
      }

      echo '</table>';
    } else {
      echo 'Tidak ada data pegawai.';
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>

</body>
</html>
