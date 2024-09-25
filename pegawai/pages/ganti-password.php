<?php
session_start();
include '../../db-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $nip = $_SESSION['data']['nip']; // Ambil nip dari sesi

    // Cek apakah password baru dan konfirmasi cocok
    if ($new_password != $confirm_password) {
        $_SESSION['message'] = "New password and confirmation do not match!";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Please check and try again!";
        header('Location: /pegawai/?link=akun');
        exit();
    }

    // Query untuk cek current password berdasarkan nip
    $query = $pdo->prepare("SELECT password FROM pegawai WHERE nip = :nip");
    $query->bindParam(':nip', $nip);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Verifikasi password lama
    if (password_verify($current_password, $result['password'])) {
        // Hash password baru dengan bcrypt
        $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);  // menggunakan bcrypt

        // Query untuk update password baru
        $update_query = $pdo->prepare("UPDATE pegawai SET password = :new_password WHERE nip = :nip");
        $update_query->bindParam(':new_password', $new_password_hashed);
        $update_query->bindParam(':nip', $nip);

        // Eksekusi update dan cek apakah berhasil
        if ($update_query->execute()) {
            $_SESSION['message'] = "Password successfully changed!";
            $_SESSION['message_code'] = "success";
            $_SESSION['message_text'] = "Your password has been updated.";
        } else {
            $_SESSION['message'] = "Failed to change password.";
            $_SESSION['message_code'] = "error";
            $_SESSION['message_text'] = "There was an issue, please try again.";
        }
    } else {
        $_SESSION['message'] = "Current password is incorrect!";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Please check your current password.";
    }

    // Redirect ke halaman akun dengan pesan status
    header('Location: /pegawai/?link=akun');
    exit();
}
?>
