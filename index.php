<?php 
session_start();
$status = isset($_SESSION['status']) ? $_SESSION['status'] : '';

    switch($status) 
    {
        case 'admin' :
            header('Location: /adm');
            
        break;

        case 'pegawai' :
            header('Location: /pegawai');
            
        break;

        default :
        header('Location: /login');
        
        break;
    }

?>