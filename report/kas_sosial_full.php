<?php
include "../inc/koneksi.php";

//FUNGSI RUPIAH
include "../inc/rupiah.php";
?>

<?php
  $sql = $koneksi->query("SELECT SUM(masuk) as tot_masuk  from kas_sosial where jenis='Masuk'");
  while ($data= $sql->fetch_assoc()) {
    $masuk=$data['tot_masuk'];
  }

  $sql = $koneksi->query("SELECT SUM(keluar) as tot_keluar  from kas_sosial where jenis='Keluar'");
  while ($data= $sql->fetch_assoc()) {
    $keluar=$data['tot_keluar'];
  }

  $saldo= $masuk-$keluar;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Laporan Kas Masjid</title>
   <!DOCTYPE html>
<html lang="en">
<head>
   <title>Laporan Kas Masjid</title>
   <style>
       .header {
           display: flex;
           align-items: center;
           justify-content: center;
           text-align: left;
           margin-bottom: 20px;
       }
       .header img {
           width: 80px; /* Adjust the logo size if needed */
           margin-right: 15px; /* Space between image and text */
       }
       .header-content {
           text-align: center;
       }
       .header h1, .header p {
           margin: 0;
           padding: 0;
       }
       .divider {
           border-bottom: 3px solid black;
           width: 100%;
           margin-top: 10px;
       }
   </style>
</head>
<body>
<center>
    <div class="header">
        <img src="../dist/img/masjid.png" alt="Mosque Icon"> <!-- Replace with the actual path to the mosque icon -->
        <div class="header-content">
            <h1>PENGURUS MASJID Nurul Iman</h1>
            <p>Kp. Sumur Selang Ds.Cimahi Kec.Klari Kab.Karawang, Jawa Barat Kode Pos: 41371</p>
        </div>
    </div>
    <div class="divider"></div>

<h2>Laporan Rekapitulasi Kas Sosial</h2>
<p>________________________________________________________________________</p>

  <table border="1" cellspacing="0">
    <thead>
      <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Uraian</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
      </tr>
    </thead>
    <tbody>
        <?php

            $no=1;
            $sql_tampil = "select * from kas_sosial order by tgl_ks asc";
            $query_tampil = mysqli_query($koneksi, $sql_tampil);
            while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
        ?>
         <tr>
            <td><?php echo $no; ?></td>
            <td><?php  $tgl = $data['tgl_ks']; echo date("d/M/Y", strtotime($tgl))?></td> 
            <td><?php echo $data['uraian_ks']; ?></td>
            <td align="right"><?php echo rupiah($data['masuk']); ?></td>  
            <td align="right"><?php echo rupiah($data['keluar']); ?></td>   
        </tr>
        <?php
            $no++;
            }
        ?>
    </tbody>
    <tr>
        <td colspan="3">Total Pemasukan</td>
        <td colspan="2"><?php echo rupiah($masuk); ?></td>
    </tr>
    <tr>
        <td colspan="4">Total Pengeluaran</td>
        <td><?php echo rupiah($keluar); ?></td>
    </tr>
    <tr>
        <td colspan="3">Saldo Kas Sosial</td>
        <td colspan="2"><?php echo rupiah($saldo); ?></td>
    </tr>
  </table>
</center>

<script>
    window.print();
</script>
</body>
</html>