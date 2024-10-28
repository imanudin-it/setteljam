<?php 
 session_start();
 if(!$_SESSION['user']){
    header('Location: ./login.php');
    exit();
 }
// Load the database configuration file 
include_once 'db-config.php'; 
 
// Include PhpSpreadsheet library autoloader 
require_once 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 
 
if(isset($_POST['importSubmit'])){ 

    $kode_transaksi = str_replace(' ','-', $_POST['kode_transaksi']); 
    $tanggal = $_POST['tanggal'];
    $judul = $_POST['judul'];
    // Persiapkan statement SQL dengan placeholder (:placeholders)
            $sql = "INSERT INTO judul (kode_transaksi, tanggal, nama) VALUES (:kode_transaksi, :tanggal, :judul)";

            // Persiapkan prepared statement
            $stmt = $pdo->prepare($sql);

            // Bind parameter ke placeholder
            $stmt->bindParam(':kode_transaksi', $kode_transaksi);
            $stmt->bindParam(':tanggal', $tanggal);
            $stmt->bindParam(':judul', $judul);
            
            // Eksekusi prepared statement
            try {
                if ($stmt->execute()) {
                $pesan1 = "&up=berhasil";
                } else {
                    header("Location: ./upload?up=gagal");
                }
            } catch (PDOException $e) {
                // Tangkap kesalahan dan arahkan ke URL dengan parameter up=gagal
                header("Location: ./upload?up=gagal");
                exit;
            } 

    // Allowed mime types 
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
     
    // Validate whether selected file is a Excel file 
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){ 
         
        // If the file is uploaded 
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            try{ 
            $reader = new Xlsx(); 
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
            $worksheet = $spreadsheet->getActiveSheet();  
            $worksheet_arr = $worksheet->toArray(); 
 
            // Remove header row 
            unset($worksheet_arr[0]); 
 
            foreach($worksheet_arr as $row){ 
                $nik = $row[0]; 
                $nama = $row[1]; 
                $jabatan = $row[2]; 
                $nominal = $row[3]; 
                $pph = $row[4]; 
                $diterima = $row[5]; 
                $kode_akses = $row[6]; 
                // Persiapkan statement SQL dengan placeholder (:placeholders)
                    $sql = "INSERT INTO ttd_jasa (kode_transaksi, nik, nama, jabatan, nominal, pph, diterima,kode_akses) VALUES (:kode_transaksi, :nik,
                    :nama, 
                    :jabatan, 
                    :nominal,
                    :pph,
                    :diterima,
                    :kode_akses)";

                    // Persiapkan prepared statement
                    $stmt = $pdo->prepare($sql);

                    // Bind parameter ke placeholder
                    $stmt->bindParam(':kode_transaksi', $kode_transaksi);
                    $stmt->bindParam(':nik', $nik);
                    $stmt->bindParam(':nama', $nama);
                    $stmt->bindParam(':jabatan', $jabatan);
                    $stmt->bindParam(':nominal', $nominal);
                    $stmt->bindParam(':pph', $pph);
                    $stmt->bindParam(':diterima', $diterima);
                    $stmt->bindParam(':kode_akses', $kode_akses);

                    // Eksekusi prepared statement
                    $stmt->execute(); 
                } 
             
            $qstring = '?status=succ'; 

        } catch (Exception $e) {
            $qstring = '?status=err';
            // Perintah SQL untuk menghapus baris dari tabel 'judul'
            $sql_judul = "DELETE FROM judul WHERE kode_transaksi = :kode_transaksi";
            $stmt_judul = $pdo->prepare($sql_judul);
            $stmt_judul->bindParam(':kode_transaksi', $kode_transaksi);
            $stmt_judul->execute();

            // Perintah SQL untuk menghapus baris dari tabel 'ttd_jasa'
            $sql_ttd_jasa = "DELETE FROM ttd_jasa WHERE kode_transaksi = :kode_transaksi";
            $stmt_ttd_jasa = $pdo->prepare($sql_ttd_jasa);
            $stmt_ttd_jasa->bindParam(':kode_transaksi', $kode_transaksi);
            $stmt_ttd_jasa->execute();

        }
    }
    }else{ 
        $qstring = '?status=invalid_file'; 
    } 
} 
 
// Redirect to the listing page 
header("Location: ./adm/upload".$qstring.$pesan1); 
 
?>