
<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<?php session_start();
if(empty($_SESSION['user'])){
    $user = 'Tamu';
}else{  $user = $_SESSION['user']; 
}
?>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title><?=$title;?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/css/demo.css" />
    

    <link href="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/DataTables/datatables.min.css" rel="stylesheet">
     <!-- Page CSS -->

    <!-- Helpers -->
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/js/config.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   
  </head>
