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

    // Query to delete the employee
    $query = $pdo->prepare("DELETE FROM pegawai WHERE nip = :nip");
    $query->bindParam(':nip', $nip);

    if ($query->execute()) {
        $_SESSION['message'] = "Pegawai berhasil dihapus!";
        $_SESSION['message_code'] = "success";
        $_SESSION['message_text'] = "Pegawai dengan NIP $nip telah dihapus.";
    } else {
        $_SESSION['message'] = "Gagal menghapus pegawai!";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Terjadi kesalahan, silakan coba lagi.";
    }

    header('Location: /adm/?link=pegawai');
    exit();
}
?>
