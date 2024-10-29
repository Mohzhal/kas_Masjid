<?php 
// Function to format currency as Rupiah
function rupiah($angka){
    // Check if $angka is null or not a valid number, default to 0 if it is
    $angka = $angka ?? 0;

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
