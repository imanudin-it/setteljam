
<!DOCTYPE html>
<?php 
    require_once('./db-config.php');
    require_once('./layouts/header.php');
    ?>

    <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
      <div class="layout-container">
        <?php //menu 
            //require_once('./layouts/menu.php'); 
            ?>

        <!-- Layout container -->
        <div class="layout-page">
        <?php //navbar 
            require_once('./layouts/navbar.php'); 
            ?>

         <!-- Content wrapper -->
         <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <?php 
              $kode = isset($_GET['kode']) ? $_GET['kode'] : '';
              if($kode){ 
                $sql = "SELECT * FROM judul WHERE kode_transaksi = :kode";
                $stmt = $pdo->prepare($sql);

                $stmt->execute([':kode' => $kode]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(empty($result)){
                  echo '
                  <div class="card bg-secondary text-white text-center p-2 mb-3">
                  <figure class="mb-0">
                    <blockquote class="blockquote mb-0">
                      <p> Data tidak ditemukan ! </p>
                    </blockquote>
                    
                  </figure>
                </div>';
                }else{
                ?>
                
            <div class="card bg-secondary text-white text-center p-2 mb-3">
                    <figure class="mb-0">
                      <blockquote class="blockquote mb-0">
                        <p> <?=$result['nama'];?> </p>
                      </blockquote>
                      
                    </figure>
                  </div>
                <div class="row">
                    <div class="col-lg-8 col-md-8 mx-auto">
                      <div class="card card-info">
                        <div class="card-body">
                    <form action="./signature.php" method="GET" class="mb-3">
                    <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-fullname">NIP / NRPK</label>
                          <div class="input-group input-group-merge">
                            <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" class="form-control" name="nik" value="<?php echo isset($_GET['nik']) ? $_GET['nik'] : ''; ?>" placeholder="NIP / NRPK"  required >
                          </div>
                        </div>   
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-fullname">KODE AKSES</label>
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-key"></i></span>
                            <input type="text" class="form-control"  name="kode_akses"  placeholder="Kode Akses / Password" autocomplete="off" required >
                          </div>
                        </div> 
                        <div class="mb-3" align="center">
                        <input type="hidden" name="kode" value="<?=$kode;?>">
                                <button type="submit" class="btn btn-primary mb-3"><i class="bx bx-search"></i> Cari </button>
                                <br>
                        <div class="alert alert-info alert-sm">Jika tidak tahu Kode Akses atau Password, Silahkan hubungi Bagian Keuangan </div>    
                        </div>
                        </form>
                        
                      </div>
                      </div>
                        <div class="row">
                     
                <?php 
                // $nik = isset($_GET['nik']) ? '%' . $_GET['nik'] . '%' : '';

                // if($nik){ 
                //     $sql2 = "SELECT * FROM ttd_jasa WHERE nik LIKE :nik AND kode_transaksi = :kode";
                //     $stmt2 = $pdo->prepare($sql2);
                //     $stmt2->bindParam(':nik', $nik);
                //     $stmt2->bindParam(':kode', $kode);
                //     $stmt2->execute();
                //     $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                //     $no = 1;
                //     if (!$results) {
                //         echo "<center> Data tidak ditemukan ! </center>";
                //     }else{
                        //foreach ($results as $row) {
                    ?>
                      <!-- <div class="col-md-6 col-lg-6">
                    <div class="card card-body p-2 mb-3">
                    <div class="demo-inline-spacing mt-0">
                        <ul class="list-group">
                          <li class="list-group-item d-flex align-items-center">
                            <i class='bx bxs-user me-2'></i> <a href="./signature.php?id=<?=$row['id'];?>" class="badge bg-warning text-white"> <?=$row['nama'];?></a>
                          </li>
                          <li class="list-group-item d-flex align-items-center">
                            <i class='bx bxs-buildings me-2'></i> <small> <?=$row['jabatan'];?> </small>
                          </li>
                          <li class="list-group-item d-flex align-items-center">
                            <i class='bx bx-edit-alt me-2'></i> <?php if(empty($row['ttd'])) {
                                echo'<small class="text-danger">Belum</small>'; }else{ echo'<small class="text-success">Sudah</small>'; } ?>
                          </li>
                        </ul>
                    </div>
                    </div>
                    </div> -->
                <?php 
                     //   }
                    //}
               // } ?>
                </div>
                    </div>
                </div>
              <?php }
              }else{
              ?>
            <!-- Error -->
    <div class="container-xxl container-p-y">
      <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Page Not Found :(</h2>
        <p class="mb-4 mx-2">Oops! 😖 The requested URL was not found on this server.</p>
        <a href="./" class="btn btn-primary">Back to home</a>
        
      </div>
    </div>
    <!-- /Error -->
    <?php }
          ?>
            </div>
            </div>
            <!-- / Content -->

            <?php 
            //footer 
                require_once('./layouts/footer.php');
                ?>
               
        </div> 
      </div>
    </div>
    </body>
    </html>