<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="output.css" rel="stylesheet">
  <title>Laporan Donasi Bulanan</title>
</head>
<body class="bg-gray-100 p-6">
  <div class="container mx-auto">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Laporan Donasi Bulanan</h2>
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold">No</th>
            <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold">Bulan</th>
            <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold">Jumlah Donasi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'koneksi.php'; // Menghubungkan ke database

          // Query untuk mengambil data donasi bulanan
          $sql = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(nominal) AS jumlah_donasi 
                  FROM jumlahdonasi 
                  GROUP BY DATE_FORMAT(tanggal, '%Y-%m') 
                  ORDER BY DATE_FORMAT(tanggal, '%Y-%m') DESC";

          $result = $conn->query($sql);
          $no = 1;

          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td class='border px-4 py-2'>" . $no++ . "</td>
                          <td class='border px-4 py-2'>" . $row['bulan'] . "</td>
                          <td class='border px-4 py-2'>" . number_format($row['jumlah_donasi'], 2, ',', '.') . "</td>
                        </tr>";
              }
          } else {
              echo "<tr>
                      <td colspan='3' class='border px-4 py-2 text-center'>Tidak ada data</td>
                    </tr>";
          }

          $conn->close();
          ?>
        </tbody>
      </table>
     
    </div> 
    <div class="mt-6 text-center">
        <a href="index.php" class="text-blue-500 hover:text-blue-700">Kembali</a>
      </div>
  </div>
</body>
</html>
