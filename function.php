<?php

function terbilang($angka) {
    // Fungsi untuk bagian bilangan bulat
    function terbilang_bulat($angka) {
        $angka = abs($angka);
        $baca = [" ", " Satu ", " Dua ", " Tiga ", " Empat ", " Lima ", " Enam ", " Tujuh ", " Delapan ", " Sembilan ", " Sepuluh ", " Sebelas "];
        $terbilang = "";

        if ($angka < 12) {
            $terbilang = " " . $baca[(int)$angka];
        } elseif ($angka < 20) {
            $terbilang = terbilang_bulat($angka - 10) . " Belas ";
        } elseif ($angka < 100) {
            $terbilang = terbilang_bulat((int)($angka / 10)) . " Puluh " . terbilang_bulat($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = " Seratus" . terbilang_bulat($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = terbilang_bulat((int)($angka / 100)) . " Ratus " . terbilang_bulat($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = " Seribu" . terbilang_bulat($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = terbilang_bulat((int)($angka / 1000)) . " Ribu " . terbilang_bulat($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = terbilang_bulat((int)($angka / 1000000)) . " Juta " . terbilang_bulat($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = terbilang_bulat((int)($angka / 1000000000)) . " Milyar " . terbilang_bulat($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $terbilang = terbilang_bulat((int)($angka / 1000000000000)) . " Triliun " . terbilang_bulat($angka % 1000000000000);
        }

        return trim($terbilang);
    }

    // Pisahkan bagian desimal jika ada
    $parts = explode('.', strval($angka));
    $bilangan_bulat = $parts[0];
    $bilangan_desimal = isset($parts[1]) ? $parts[1] : '';

    // Bagian bilangan bulat
    $hasil = terbilang_bulat($bilangan_bulat);

    // Bagian bilangan desimal
    if ($bilangan_desimal !== '') {
        $hasil .= ' Koma';
        for ($i = 0; $i < strlen($bilangan_desimal); $i++) {
            $digit = (int)($bilangan_desimal[$i]);
            $hasil .= ' ' . terbilang_bulat($digit);
        }
    }

    return $hasil;
}

?>
