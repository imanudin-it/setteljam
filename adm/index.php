
<!DOCTYPE html>
<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/function.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db-config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');
    
if($_SESSION['status']!='admin'){
    header('Location: /');
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
      <div class="layout-container">
        <?php //menu 
            //require_once($_SERVER['DOCUMENT_ROOT'] . '/adm/layouts/menu.php'); 
            ?>

        <!-- Layout container -->
        <div class="layout-page">
        <?php //navbar 
            require_once('../layouts/navbar.php'); 
            ?>

         <!-- Content wrapper -->
         <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <?php 
              $akses = $_SESSION['data'];
              $link = isset($_GET['link']) ? $_GET['link'] : '';
              switch($link){
                case  'upload'  :
                  require_once('./pages/upload.php');
                break;

                case  'list'  :
                  require_once('./pages/list.php');
                break;
                
                case  'akun'  :
                  require_once('./pages/akun.php');
                break;
                
                case  'pegawai'  :
                  require_once('./pages/pegawai.php');
                break;
                
                case  'laporan'  :
                  require_once('./pages/laporan.php');
                break;
  
                case  'penanggung-jawab'  :
                  require_once('./pages/penanggung-jawab.php');
                break;
  
              default :
              ?>
            <div class="card bg-secondary text-white text-center mb-4 p-2">
                    <figure class="mb-2">
                      <blockquote class="blockquote">
                        <h1 class="text-white">STTELJAM </h1>
                      </blockquote><br>
                      <figcaption class="blockquote-footer mb-0 text-white">
                        <cite title="Source Title">Sistem Tanda Tangan Elektronik Jasa Medis <br>  by <?=$namaRS;?> &copy; <?=date('Y');?></cite>
                      </figcaption>
                    </figure>
                  </div>
                  
            <div class="card">
              <div class="card-body">
            <div class="divider text-start">
                <div class="divider-text">
                    <h5><span class="badge bg-warning"><i class='bx bx-qr'></i> MENU : &nbsp; &nbsp; </span></h5>
                 </div>
            </div>
            <div class="row">
              <?php if($akses['upload_berkas']== 1){ ?>
                <div class="col-md-4 col-lg-4 col-6" >
                <a href="./?link=upload">
                <div class="card shadow bg-transparent border border-info mb-3">
                    <div class="card-body">
                      <h5 class="card-title"><i class="bx bx-upload fw-3"></i> </h5>
                      <p class="card-text">Upload Berkas </p>
                    </div>
                  </div>
                </a>
                </div>
                <?php } ?>
                <?php if($akses['list_berkas']== 1){ ?>
                <div class="col-md-4 col-lg-4 col-6">
                <a href="./?link=list"> 
                <div class="card shadow bg-transparent border border-info mb-3">
                    <div class="card-body">
                      <h5 class="card-title"><i class='bx bx-list-ol'></i></h5>
                      <p class="card-text">List Berkas</p>
                    </div>
                  </div>
                </a>
                </div>
                <?php } ?>
                
                <!-- <?php if($akses['jadwal_dinas']== 1){ ?>
                <div class="col-md-4 col-lg-4 col-6">
                <a href="./?link=jadwal_dinas"> 
                <div class="card shadow bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <h5 class="card-title"><i class='bx bx-pie-chart-alt-2'></i></h5>
                      <p class="card-text">Jadwal Dinas</p>
                    </div>
                  </div>
                </a>
                </div>
                <?php } ?> -->
                <div class="col-md-4 col-lg-4 col-6">
                <a href="./?link=pegawai"> 
                <div class="card shadow bg-transparent border border-info mb-3">
                    <div class="card-body">
                      <h5 class="card-title"><i class='bx bx-user'></i></h5>
                      <p class="card-text">Akun / Pegawai</p>
                    </div>
                  </div>
                </a>
                </div>
            </div>
              </div>
            </div>
            <?php 
            break;
            
          }
          ?>
            </div>
            </div>
            <!-- / Content -->

            <?php 
            //footer 
                require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php');
                ?>
            
        </div> 
      </div>
    </div>

<?php if (isset($_SESSION['message']) && $_SESSION['message'] != '') { ?>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['message_code']; ?>',
            title: '<?php echo $_SESSION['message']; ?>',
            text: '<?php echo $_SESSION['message_text']; ?>'
        });
    </script>
    <?php unset($_SESSION['message']); unset($_SESSION['message_code']); unset($_SESSION['message_text']); ?>
<?php } ?>

    </body>
    </html>