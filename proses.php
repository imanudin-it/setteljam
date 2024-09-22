<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    require_once('./db-config.php');

    if (isset($_POST['foto'])) { 
        $data_uri = $_POST['foto'];
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        
        // Folder untuk menyimpan gambar
        $folder = '/images/' . $_POST['kode'] . '/';
        
        // Jika folder tidak ada, buat folder tersebut
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true); // Buat folder dengan izin tertentu (0777)
        }
        
        if (file_put_contents($folder . $_POST['nama'] . '.png', $decoded_image)) {
            try {    
                // Persiapkan kueri UPDATE
                $nama = $folder . $_POST['nama'] . '.png';
                $id = $_POST['id'];
                $sql = "UPDATE ttd_jasa SET ttd = :ttd WHERE id = :id";
                $stmt = $pdo->prepare($sql);

                // Bind parameter
                $stmt->bindParam(':ttd', $nama);
                $stmt->bindParam(':id', $id);

                // Jalankan kueri
                $stmt->execute();

                // Respon ke client bahwa proses berhasil
                echo "success";
            } catch(PDOException $e) {
                // Respon ke client jika terjadi kesalahan pada update query
                http_response_code(500);
                echo "Error: " . $e->getMessage();
            }
        } else {
            // Respon ke client jika penyimpanan gambar gagal
            http_response_code(500);
            echo "Error: Gagal menyimpan gambar.";
        }
    } else {
        // Respon ke client jika data tidak lengkap
        http_response_code(400);
        echo "Error: Data tidak lengkap.";
    }
} else {
    // Jika bukan permintaan AJAX
    http_response_code(403);
    echo "Error: Forbidden - hanya permintaan AJAX yang diperbolehkan.";
}
?>
