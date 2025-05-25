<?php 
 session_start();
// Check if the session is valid and data exists
if(empty($_SESSION['data'])){
    http_response_code(500);
    header('Location: /404/');
    exit();
}
// Load the database configuration file 
include_once 'db-config.php'; 
 
// Include PhpSpreadsheet library autoloader 
require_once 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 
 
if(isset($_POST['kode_transaksi'])){ 

    $kode_transaksi = $_POST['kode_transaksi']; 

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
 
            foreach ($worksheet_arr as $row) { 
    $nik = $row[0]; 
    $nama = $row[1]; 
    $jabatan = $row[2]; 
    $nominal = $row[3]; 
    $pph = $row[4]; 
    $diterima = $row[5]; 
    $kode_akses = $row[6]; 

    // Update berdasarkan nik dan kode_transaksi (sesuai kebutuhan)
    $sql = "UPDATE ttd_jasa SET 
                nama = :nama,
                jabatan = :jabatan,
                nominal = :nominal,
                pph = :pph,
                diterima = :diterima,
                kode_akses = :kode_akses
            WHERE nik = :nik AND kode_transaksi = :kode_transaksi";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':jabatan', $jabatan);
    $stmt->bindParam(':nominal', $nominal);
    $stmt->bindParam(':pph', $pph);
    $stmt->bindParam(':diterima', $diterima);
    $stmt->bindParam(':kode_akses', $kode_akses);
    $stmt->bindParam(':nik', $nik);
    $stmt->bindParam(':kode_transaksi', $kode_transaksi);

    $stmt->execute(); 
}

             
            $qstring = '?status=succ'; 

        } catch (Exception $e) {
            $qstring = '?status=err';
        }
    }
    }else{ 
        $qstring = '?status=invalid_file'; 
    } 
} 
 
// Redirect to the listing page 
$kode = $_POST['kode_transaksi'];
header("Location: ./adm/?link=laporan&kode=$kode&$qstring");
exit;
?>