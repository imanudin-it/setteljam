<?php
session_start();

// Check if the session is valid and data exists
if(empty($_SESSION['data'])){
    http_response_code(500);
    header('Location: /404/');
    exit();
}

include '../../db-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];

    // Query to update the employee data
    $query = $pdo->prepare("UPDATE pegawai SET nama = :nama WHERE nip = :nip");
    $query->bindParam(':nama', $nama);
    $query->bindParam(':nip', $nip);

    if ($query->execute()) {
        $_SESSION['message'] = "Pegawai berhasil diperbarui!";
        $_SESSION['message_code'] = "success";
        $_SESSION['message_text'] = "Data pegawai telah diperbarui.";
    } else {
        $_SESSION['message'] = "Gagal memperbarui pegawai!";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Terjadi kesalahan, silakan coba lagi.";
    }

    header('Location: /adm/?link=pegawai');
    exit();
}
?>
