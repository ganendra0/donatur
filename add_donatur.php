<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="output.css" rel="stylesheet">
  <title>Tambah Donatur</title>
</head>
<body class="bg-gray-100 p-6">
  <div class="container mx-auto">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
      <h2 class="text-2xl font-bold mb-6 text-center">Tambah Donatur</h2>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          include 'koneksi.php'; // Menghubungkan ke database

          // Ambil data dari form
          $nama = $_POST['nama'];
          $alamat = $_POST['alamat'];
          $nominal = $_POST['nominal'];

          // Validasi input
          if (!empty($nama) && !empty($alamat) && !empty($nominal)) {
              // Query untuk memasukkan data ke tabel donatur menggunakan prepared statement
              $sql = "INSERT INTO donatur (nama, alamat, nominal) VALUES (?, ?, ?)";
              if ($stmt = $conn->prepare($sql)) {
                  // Bind parameter ke statement
                  $stmt->bind_param("ssd", $nama, $alamat, $nominal);

                  // Eksekusi statement
                  if ($stmt->execute()) {
                      echo "<script>
                          alert('Donatur berhasil ditambahkan');
                          window.location.href = 'add_donatur.php';
                          </script>";
                  } else {
                      echo "<script>
                          alert('Donatur gagal ditambahkan');
                          window.location.href = 'add_donatur.php';
                          </script>";
                  }

                  // Tutup statement
                  $stmt->close();
              } else {
                  echo "<script>
                      alert('Terjadi kesalahan dalam mempersiapkan statement.');
                      window.location.href = 'add_donatur.php';
                      </script>";
              }
          } else {
              echo "<script>
                  alert('Semua field harus diisi.');
                  window.location.href = 'add_donatur.php';
                  </script>";
          }

          // Tutup koneksi
          $conn->close();
      }
      ?>
      <form action="" method="POST">
        <!-- Nama Input -->
        <div class="mb-4">
          <label for="nama" class="block text-gray-700 font-bold mb-2">Nama:</label>
          <input type="text" id="nama" name="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <!-- Alamat Input -->
        <div class="mb-4">
          <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat:</label>
          <input type="text" id="alamat" name="alamat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <!-- Nominal Input -->
        <div class="mb-4">
          <label for="nominal" class="block text-gray-700 font-bold mb-2">Nominal: <span style="font-style: italic">(masukkan hanya angka)</span></label>
          <input type="number" id="nominal" name="nominal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <!-- Submit Button -->
        <div class="flex items-center justify-center">
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
        </div>
      </form>
      </div>
    <div class="mt-4 text-center">
        <a href="index.php" class="text-blue-500 hover:text-blue-700">Kembali</a>
      </div>
  </div>
</body>
</html>
