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
      background-color: Green;
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
    .search{
      display: inline-block;
      float: right;
    }
    
    .pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination a {
  display: inline-block;
  padding: 8px 12px;
  text-decoration: none;
  background-color: #f2f2f2;
  color: #333;
  border: 1px solid #ccc;
  margin: 0 4px;
}

.pagination a:hover {
  background-color: #ddd;
  border-color: #999;
}

.pagination .active {
  background-color: #007bff;
  color: #fff;
  border-color: #007bff;
}

.pagination .arrow {
  display: inline-block;
  padding: 8px;
  font-size: 14px;
  font-weight: bold;
}

  </style>
</head>
<body>
  <h2>DATA PEGAWAI</h2>
  
  <form class="search" action="" method="GET">
    <label for="search">Cari:</label>
    <input type="text" name="search" id="search">
    <button type="submit">Cari</button>
  </form>

  <a class="add-btn" href="form.php">Tambah Pegawai</a>
  
<?php
// Menghubungkan ke database
$host = '127.0.0.1';
  $dbname = 'classicmodels';
  $username = 'root';
  $password = '';

try {
  $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Konfigurasi paginasi
  $limit = 10; // Jumlah data per halaman

  // Mengambil halaman yang aktif dari parameter URL
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($page - 1) * $limit;

  // Memproses pencarian data jika form dikirimkan
  if(isset($_GET['search'])) {
    $search = $_GET['search'];

    // Menghitung total data pegawai berdasarkan pencarian
    $stmtCount = $dbh->prepare("SELECT COUNT(*) AS total FROM pegawai WHERE nama LIKE :search");
    $stmtCount->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmtCount->execute();
    $total = $stmtCount->fetchColumn();

    // Mengambil data pegawai berdasarkan pencarian dengan paginasi
    $stmt = $dbh->prepare("SELECT * FROM pegawai WHERE nama LIKE :search LIMIT :start, :limit");
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $pegawai = $stmt->fetchAll();
  } else {
    // Menghitung total data pegawai
    $stmtCount = $dbh->prepare("SELECT COUNT(*) AS total FROM pegawai");
    $stmtCount->execute();
    $total = $stmtCount->fetchColumn();

    // Mengambil semua data pegawai dengan paginasi
    $stmt = $dbh->prepare("SELECT * FROM pegawai LIMIT :start, :limit");
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $pegawai = $stmt->fetchAll();
  }

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
    echo '<br>';
    echo " Total data : " . $total;

    // Menampilkan link halaman paginasi
    $totalPages = ceil($total / $limit); // Jumlah halaman
    echo '<div class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
      echo '<a href="?page=' . $i . '">' . $i . '</a>';
    }
    echo " Page " .$page;  echo " of "  .$totalPages;
  
    echo '</div>';
  } else {
    echo 'Tidak ada data pegawai.';
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
</body>
</html>