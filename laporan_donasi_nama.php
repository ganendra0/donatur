<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="output.css" rel="stylesheet">
  <title>Laporan Donasi Berdasarkan Nama</title>
  <style>
    .table-container {
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f4f4f4;
    }
  </style>
</head>
<body class="bg-gray-100 p-6">
  <div class="container mx-auto">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Laporan Donasi Berdasarkan Nama</h2>
      <form action="" method="GET" class="mb-6">
        <div class="mb-4">
          <label for="bulan" class="block text-gray-700 font-bold mb-2">Bulan:</label>
          <select id="bulan" name="bulan" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" onchange="this.form.submit()">
            <?php
            // Mendapatkan bulan dan tahun saat ini
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Jika bulan dan tahun dipilih, gunakan yang dipilih, jika tidak gunakan bulan dan tahun saat ini
            $selectedMonth = isset($_GET['bulan']) ? $_GET['bulan'] : $currentMonth;
            $selectedYear = isset($_GET['tahun']) ? $_GET['tahun'] : $currentYear;

            // Menampilkan opsi bulan
            for ($m = 1; $m <= 12; $m++) {
              $month = str_pad($m, 2, "0", STR_PAD_LEFT);
              $selected = ($month == $selectedMonth) ? "selected" : "";
              echo "<option value='$month' $selected>" . date('F', mktime(0, 0, 0, $m, 10)) . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-4">
          <label for="tahun" class="block text-gray-700 font-bold mb-2">Tahun:</label>
          <select id="tahun" name="tahun" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" onchange="this.form.submit()">
            <?php
            // Menampilkan opsi tahun (dari 5 tahun yang lalu hingga 5 tahun ke depan)
            for ($y = $currentYear - 5; $y <= $currentYear + 5; $y++) {
              $selected = ($y == $selectedYear) ? "selected" : "";
              echo "<option value='$y' $selected>$y</option>";
            }
            ?>
          </select>
        </div>
      </form>

      <?php
      include 'koneksi.php'; // Menghubungkan ke database

      $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : $currentMonth;
      $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : $currentYear;

      // Query untuk mengambil data donatur dan donasi berdasarkan bulan dan tahun
      $query = "SELECT donatur.nama, donatur.alamat, jumlahdonasi.tanggal, jumlahdonasi.nominal
                FROM donatur
                LEFT JOIN jumlahdonasi ON donatur.id = jumlahdonasi.iduser 
                AND MONTH(jumlahdonasi.tanggal) = '$bulan' 
                AND YEAR(jumlahdonasi.tanggal) = '$tahun'
                ORDER BY donatur.nama";

      $result = $conn->query($query);
      ?>
      <div class="table-container mt-6">
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold">No</th>
              <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold">Nama</th>
              <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold">Alamat</th>
              <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold">Nominal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $nominal = is_null($row['nominal']) ? '-' : number_format($row['nominal'], 2, ',', '.');
                    echo "<tr>
                            <td class='border px-4 py-2'>" . $no++ . "</td>
                            <td class='border px-4 py-2'>" . htmlspecialchars($row['nama']) . "</td>
                            <td class='border px-4 py-2'>" . htmlspecialchars($row['alamat']) . "</td>
                            <td class='border px-4 py-2'>" . $nominal . "</td>
                          </tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='4' class='border px-4 py-2 text-center'>Tidak ada data</td>
                      </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      
    </div>
    <div class="mt-6 text-center">
        <a href="index.php" class="text-blue-500 hover:text-blue-700">Kembali</a>
      </div>
  </div>
</body>
</html>
