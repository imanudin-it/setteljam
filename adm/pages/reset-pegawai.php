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
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {
        $_SESSION['message'] = "Password baru dan konfirmasi tidak cocok!";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Mohon cek ulang dan coba lagi.";
        header('Location: /pegawai/');
        exit();
    }

    // Hash the new password using bcrypt
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

    // Query to update the employee password
    $query = $pdo->prepare("UPDATE pegawai SET password = :new_password WHERE nip = :nip");
    $query->bindParam(':new_password', $new_password_hashed);
    $query->bindParam(':nip', $nip);

    if ($query->execute()) {
        $_SESSION['message'] = "Password berhasil direset!";
        $_SESSION['message_code'] = "success";
        $_SESSION['message_text'] = "Password pegawai telah diperbarui.";
    } else {
        $_SESSION['message'] = "Gagal mereset password!";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Terjadi kesalahan, silakan coba lagi.";
    }

    header('Location: /adm/?link=pegawai');
    exit();
}
?>
