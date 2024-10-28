<?php
// Mulai output buffering
require_once('../function.php');
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];

    ob_start();

    require_once('../db-config.php');

    $sql2 = "SELECT a.*, b.tanggal, b.nama as judul FROM ttd_jasa a 
            LEFT JOIN judul b on b.kode_transaksi = a.kode_transaksi 
            WHERE a.kode_transaksi = :kode";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(':kode', $kode);
    $stmt2->execute();
    $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $total = $stmt2->rowCount();
    $no = 1;
    if (!$results) {
        echo "<center> [ '.$kode.' ] tidak ditemukan ! </center>";
    } else {
        $title = $results[0]['kode_transaksi'];
        $judul = $results[0]['judul']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title> <!-- Judul sesuai dengan judul hasil query -->
    <style>
        .table {
            font-size:11px;
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid black;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 7px;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-bordered tbody + tbody {
            border-top-width: 2px;
        }

    </style>
</head>
<body>

<div style="text-align: center; margin-bottom:15px;">
    <center><b><?= $judul; ?></b></center>
</div>

<table width="100%" class="table table-bordered table-hover" style="font-size: 10px;">
    <thead align="center">
    <tr align="center">
        <th width="5%"> No </th>
        <th> Nama </th>
        <th> Jabatan </th>
        <th> Jumlah (Rp.) </th>
        <th> PPh (Rp.) </th>
        <th> Diterima (Rp.) </th>
        <th colspan="2"> Tanda Tangan</th>
    </tr>
    </thead>
    <tbody>
    <?php
                // Inisialisasi variabel total
                $total_nominal = 0.0;
                $total_pph = 0.0;
                $total_diterima = 0.0;
                ?>
    <?php
    $no = 1; $totals=0;
    foreach ($results as $row) {
        // Tambahkan nilai ke total
        $total_nominal += (float)$row['nominal'];
        $total_pph += (float)$row['pph'];
        $total_diterima += (float)$row['diterima'];   

        $sisi = ($no % 2 == 1) ? 'kiri' : 'kanan';
        ?>
        <tr>
            <td valign="middle" align="center"> <?= $no; ?> </td>
            <td> <?= $row['nama']; ?> </td>
            <td> <?= $row['jabatan']; ?> </td>
            <td valign="middle" align="right"> <?= number_format($row['nominal'], '2', ',', '.'); ?> </td>
            <td align="right"> <?=number_format($row['pph'],'2',',','.');?> </td>
            <td align="right"> <?=number_format($row['diterima'],'2',',','.');?> </td>
            <?php if ($sisi == 'kiri') {
                $next = $no + 1;
                echo '<td rowspan="2" valign="top"> <small> ' . $no . '</small> <img src="' . $row['ttd'] . '" style="width:50px; height:50px;"> </td>
                        <td rowspan="2"> ';
                if ($next <= $total) {
                    echo ' <small> ' . $next . '</small> <img style="float:right" src="' . $results[$no]['ttd'] . '" style="width:50px; height:50px;"> ';
                } else {
                    echo '</tr> <tr> <td> - </td> <td> - </td> <td> - </td> <td> - </td> <td> - </td> <td> - </td> </tr>';
                }
                echo '</td> ';

                            
            }

            ?>
        </tr>
       
        <?php
        $no++;
        
    }
    ?>
    
                  <tr>
                    <td colspan="3"> Total </td>
                    <td align="right"><strong><?= number_format($total_nominal, 2, ',', '.'); ?></strong></td>
                    <td align="right"><strong><?= number_format($total_pph, 2, ',', '.'); ?></strong></td>
                    <td align="right"><strong><?= number_format($total_diterima, 2, ',', '.'); ?></strong></td>
                  </tr> 
                  
    </tbody>
</table>
<br>
<br>
<table width="100%" style="font-size:11px;">
    <tr> <td> Terbilang : </td> </tr>
     <tr> <td >  <b> <?= terbilang($total_nominal); ?> </b></td> </tr>
</table>
</body>
</html>
<?php
    // Selesai menangkap output HTML
    $content = ob_get_clean();

    // Pastikan library mPDF sudah diinstal sebelum menggunakan kode ini
    require_once '/vendor/autoload.php'; // Sesuaikan path dengan letak instalasi mPDF

    // Buat objek mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Tambahkan HTML yang telah Anda tangkap ke objek mPDF
    $mpdf->WriteHTML($content);

    // Outputkan PDF ke browser atau simpan ke file
    $mpdf->Output(); // 'D' untuk langsung mengunduh file PDF
}
} else {
    header('Location: ./index.php');
}
?>
