<?php
session_start();

if(empty($_SESSION['data'])){
    http_response_code(500);
    header('Location: /404/');
    exit();
}

include '../../db-config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $nip = $_POST['nip'];
    $password = $_POST['password'];

    // Check if NIP already exists
    $check_nip_query = $pdo->prepare("SELECT * FROM pegawai WHERE nip = :nip");
    $check_nip_query->bindParam(':nip', $nip);
    $check_nip_query->execute();

    if ($check_nip_query->rowCount() > 0) {
        // NIP already exists
        $_SESSION['message'] = "NIP sudah ada didatabase !";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Periksa kembali NIP tersebut.";
        header('Location: /adm/?link=pegawai');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert new employee data
    $insert_query = $pdo->prepare("INSERT INTO pegawai (nip, nama, password) VALUES (:nip, :nama, :password)");
    $insert_query->bindParam(':nip', $nip);
    $insert_query->bindParam(':nama', $name);
    $insert_query->bindParam(':password', $hashed_password);

    if ($insert_query->execute()) {
        // Success
        $_SESSION['message'] = "Data Pegawai berhasil ditambahkan!";
        $_SESSION['message_code'] = "success";
        $_SESSION['message_text'] = " $name - telah ditambahkan.";
    } else {
        // Error
        $_SESSION['message'] = "Gagal ditambahkan !";
        $_SESSION['message_code'] = "error";
        $_SESSION['message_text'] = "Terdapat kesalahan sistem, silahkan coba lagi !";
    }

    header('Location: /adm/?link=pegawai');
    exit();
}
?>
