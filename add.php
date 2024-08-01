<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="container mx-auto">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Tambah Laporan</h2>
      <form action="" method="POST">
        <!-- Nama Dropdown -->
        <div class="mb-4">
          <label for="nama" class="block text-gray-700 font-bold mb-2">Nama:</label>
          <select id="nama" name="nama" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option value="">Pilih Nama</option>
            <?php
            include 'koneksi.php'; // Menghubungkan ke database

            $sql = "SELECT nama FROM donatur"; // Query untuk mengambil data
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                }
            } else {
                echo "<option value=''>Tidak ada data</option>";
            }
            ?>
          </select>
        </div>
        <!-- Tanggal Input -->
        <div class="mb-4">
          <label for="tanggal" class="block text-gray-700 font-bold mb-2">Tanggal:</label>
          <input type="date" id="tanggal" name="tanggal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <!-- Submit Button -->
        <div class="flex items-center justify-center">
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <div class="mt-6 text-center">
        <a href="index.php" class="text-blue-500 hover:text-blue-700">Kembali</a>
      </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tanggal']) && isset($_POST['nama'])) {
  include 'koneksi.php'; // Menghubungkan ke database

  $nama = $_POST['nama'];
  $query = "SELECT * FROM donatur WHERE nama = '$nama'";
  $hasil = $conn->query($query);
  $row = $hasil->fetch_assoc();

  if ($row) {
    $iduser = $row['id'];
    $tanggal = $_POST['tanggal'];
    $nominal = $row['nominal'];

    $insert = "INSERT INTO jumlahdonasi (iduser, tanggal, nominal) VALUES ('$iduser', '$tanggal', '$nominal')";
    if ($conn->query($insert) === TRUE) {
      echo "<script>
            alert('Pembayaran berhasil');
            window.location.href = 'add.php';
            </script>";
    } else {
      echo "<script>
            alert('Terjadi kesalahan. Data gagal ditambahkan.');
            window.location.href = 'add.php';
            </script>";
    }
  }
  $conn->close();
}
?>
