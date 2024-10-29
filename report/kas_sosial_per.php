<?php
include "../inc/koneksi.php";
// FUNGSI RUPIAH
include "../inc/rupiah.php";

$dt1 = $_POST["tgl_1"] ?? '';
$dt2 = $_POST["tgl_2"] ?? '';

// Check if dates are provided
if (empty($dt1) || empty($dt2)) {
    die("Please provide both start and end dates.");
}

$sql = $koneksi->query("SELECT SUM(masuk) as tot_masuk FROM kas_sosial WHERE jenis='Masuk' AND tgl_ks BETWEEN '$dt1' AND '$dt2'");
while ($data = $sql->fetch_assoc()) {
    $masuk = $data['tot_masuk'];
}

$sql = $koneksi->query("SELECT SUM(keluar) as tot_keluar FROM kas_sosial WHERE jenis='Keluar' AND tgl_ks BETWEEN '$dt1' AND '$dt2'");
while ($data = $sql->fetch_assoc()) {
    $keluar = $data['tot_keluar'];
}

$saldo = $masuk - $keluar;
?>
<center>
    <div class="header">
        <img src="../dist/img/masjid.png" alt="Mosque Icon"> <!-- Replace with the actual path to the mosque icon -->
        <div class="header-content">
            <h1>PENGURUS MASJID Nurul Iman</h1>
            <p>Kp. Sumur Selang Ds.Cimahi Kec.Klari Kab.Karawang, Jawa Barat Kode Pos: 41371</p>
        </div>
    </div>
    <div class="divider"></div>
<h2>Laporan Rekapitulasi Kas sosial</h2>
<h3>Masjid Nurul Iman Sumur Selang</h3>
<p>Periode : <?php $a=$dt1; echo date("d-M-Y", strtotime($a))?> s/d <?php $b=$dt2; echo date("d-M-Y", strtotime($b))?>
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

        if(isset($_POST["btnCetak"])){
           
            $sql_tampil = "select * from kas_sosial where tgl_ks BETWEEN '$dt1' AND '$dt2' order by tgl_ks asc";
            }
            $query_tampil = mysqli_query($koneksi, $sql_tampil);
            $no=1;
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
        <td colspan="3">Saldo Kas sosial</td>
        <td colspan="2"><?php echo rupiah($saldo); ?></td>
    </tr>
  </table>
</center>

<script>
    window.print();
</script>
</body>
</html>