
<!DOCTYPE html>
<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/function.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db-config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');
    
if($_SESSION['status']!='pegawai'){
    header('Location: /login/');
}
?>
    <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
      <div class="layout-container">
        
        <!-- <?php //menu 
            //require_once($_SERVER['DOCUMENT_ROOT'] . '/adm/layouts/menu.php'); 
            ?> -->

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
                
                case  'list'  :
                  require_once('./pages/list.php');
                break;
                
                case  'akun'  :
                  require_once('./pages/akun.php');
                break;
                
                case  'ttd'  :
                  require_once('./pages/signature.php');
                break;
                
                case  'laporan'  :
                  require_once('./pages/laporan.php');
                break;
  
                
              default :
              ?>
            <div class="card bg-info text-white text-right mb-3">
              <div class="card-body mb-0">
                    <h6 class="text-white"><cite> Hai,</cite> </h6>
                        <h3 class="text-white"> <?=$_SESSION['data']['nama'];?> </h3>
                     
              </div>
                  </div>
                  
            <div class="card">
              <div class="card-body">
            <div class="divider text-start">
                <div class="divider-text">
                    <h5><span class="badge bg-warning"><i class='bx bx-menu'></i> MENU : &nbsp; &nbsp; </span></h5>
                 </div>
            </div>
            <div class="row">
              
                <div class="col-md-4 col-lg-4 col-6" >
                <a href="./?link=list">
                <div class="card shadow bg-label-info border border-info mb-3">
                    <div class="card-body">
                      <h5 class="card-title"><i class='bx bxs-edit-alt'></i></h5>
                      <p class="card-text">Tanda Tangan </p>
                    </div>
                  </div>
                </a>
                </div>
                
               
                <div class="col-md-4 col-lg-4 col-6">
                <a href="./?link=akun"> 
                <div class="card shadow bg-label-info border border-info mb-3">
                <div class="card-body">
                      <h5 class="card-title"><i class='bx bxs-cog'></i></h5>
                      <p class="card-text">Pengaturan Akun</p>
                    </div>
                  </div>
                </a>
                </div>
             
                <div class="col-md-4 col-lg-4 col-6">
                <a href="/logout.php"> 
                <div class="card bg-label-warning shadow border border-danger mb-3">
                    <div class="card-body">
                      <h5 class="card-title"><i class='bx bxs-exit' ></i></h5>
                      <p class="card-text">Keluar Akun</p>
                    </div>
                  </div>
                </a>
                </div>
             
                
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
    </body>
    </html>