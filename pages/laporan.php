
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
                <?php 
                 
                    $sql2 = "SELECT * FROM ttd_jasa WHERE kode_transaksi = :kode";
                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->bindParam(':kode', $kode);
                    $stmt2->execute();
                    $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    $total = $stmt2->rowCount();
                    $no = 1;
                    if (!$results) {
                        echo "<center> Data tidak ditemukan ! </center>";
                    }else{ ?>
              <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <!-- <div class="btn-group pull-right mb-3"> <button class="btn btn-info btn-sm" onclick="printDiv('laporan')"/> <i class='bx bx-printer' ></i> | PRINT </button> <button class="btn btn-success btn-sm" id="excel"> <i class='bx bx-table' ></i> | EXCEL </button> </div>  -->
                        <a onclick="javascript:window.history.back()" class="btn btn-warning btn-sm mb-3" href="./index.php"> <i class="bx bx-arrow-back"></i> &nbsp; </a>
                        <a href="laporan_ttd.php?kode=<?=$kode;?>" target="_blank" class="btn btn-success btn-sm mb-3"  id="pdf"> <i class='bx bxs-file-pdf' ></i> Download PDF </a> 
                        
            <style>
           		table {
                border-collapse: collapse;
                font-size: 11px;
                }
           		thead {
                font-size:11px;
                
              }
            	th, td {
                padding: 3px;
                font-size: 11px;
                }
            </style>
            
            <div class="table-responsive text-wrap">
                <table width="100%" class="table table-bordered table-hover" id="myTable">
                <thead align="center">
                <tr align="center">
                    <th width="10"> 📝 </th>
                    <th> Nama </th>
                    <th> Jabatan </th>
                    <th> Jumlah </th>
                    <th> PPh </th>
                    <th> Diterima </th>
                </tr>
                </thead>
                <tbody>

                 <?php $no=1; 
                 foreach ($results as $row) {
                  if(empty($row['ttd']) || $row['ttd']=='-') {
                    $warna = '❌';
                  }else{ $warna = '✔️';
                  }
                    ?>
                  <tr >
                    <td> <?=$warna;?> </td>
                    <td> <?=$row['nama'];?> </td>
                    <td> <?=$row['jabatan'];?> </td>
                    <td align="right"> <?=number_format($row['nominal'],'0',',','.');?> </td>
                    <td align="right"> <?=number_format($row['pph'],'0',',','.');?> </td>
                    <td align="right"> Rp. <?=number_format($row['diterima'],'0',',','.');?> </td>
                   <?php
                     }
                     ?>
                  </tr>
                <?php 
                   }
                } ?>
                </tbody>
                </table>
            </div>
                </div>
                
                </div>
                    </div>
              </div>
              
              <?php }else{
              ?>
            <!-- Error -->
    <div class="container-xxl container-p-y">
      <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Page Not Found :(</h2>
        <p class="mb-4 mx-2">Oops! 😖 The requested URL was not found on this server.</p>
        <a href="./" class="btn btn-primary">Back to home</a>
        
      </div>
    </div>
<?php } ?>
	