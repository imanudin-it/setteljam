
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
                        <button onclick="javascript:window.history.back()" class="btn btn-warning btn-sm mb-3"> <i class="bx bx-arrow-back"></i> &nbsp; </button>
                        <a href="/laporan_ttd.php?kode=<?=$kode;?>" target="_blank" class="btn btn-success btn-sm mb-3"  id="pdf"> <i class='bx bxs-file-pdf' ></i> Download PDF </a> 
                        <div style="float:right"> <button type="button" class="btn btn-danger btn-sm"  data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="top" data-bs-html="true" data-bs-content="<small>Berkas dan tanda tangan akan dihapus </small> <div align='right' class='mt-2'><a href='./?link=list&hapus=<?=$kode;?>' type='button' class='btn btn-sm btn-primary'>Ya</a></div>" title="" data-bs-original-title="Yakin akan dihapus ?" aria-describedby="popover583573"><i class='bx bx-trash'></i> Hapus </button>
                        </div>
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
                    <th> NIP/NRPTT </th>
                    <th> Nama </th>
                    <th> Jabatan </th>
                    <th> Jumlah </th>
                    <th> PPh </th>
                    <th> Diterima </th>
                    <th> Kode</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Inisialisasi variabel total
                $total_nominal = 0.0;
                $total_pph = 0.0;
                $total_diterima = 0.0;
                ?>
                 <?php $no=1; 
                 foreach ($results as $row) :
                  if(empty($row['ttd']) || $row['ttd']=='-') {
                    $warna = '❌';
                  }else{ $warna = '✔️';
                  }
                    ?>
                  <tr >
                    <td> <?=$warna;?> </td>
                    <td> <?=$row['nik'];?> </td>
                    <td> <?=$row['nama'];?> </td>
                    <td> <?=$row['jabatan'];?> </td>
                    <td align="right"> <?=number_format($row['nominal'],'2',',','.');?> </td>
                    <td align="right"> <?=number_format($row['pph'],'2',',','.');?> </td>
                    <td align="right"> <?=number_format($row['diterima'],'2',',','.');?> </td>
                    <td align="center"> <button class="btn btn-warning btn-xs" data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="right" data-bs-html="true" data-bs-content="<p>Kode Akses : <b><?=$row['kode_akses'];?></b></p>" title="" data-bs-original-title="<?=$row['nama'];?>"> <i class='bx bxs-low-vision'></i> </button></td>
                    <?php
                    // Tambahkan nilai ke total
                    $total_nominal += (float)$row['nominal'];
                    $total_pph += (float)$row['pph'];
                    $total_diterima += (float)$row['diterima'];
                    ?>
        
                  <?php
                     endforeach;
                     ?>
                  </tr>
                 
                <?php 
                   }
                } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"> Total </td>
                    <td align="right"><strong><?= number_format($total_nominal, 2, ',', '.'); ?></strong></td>
                    <td align="right"><strong><?= number_format($total_pph, 2, ',', '.'); ?></strong></td>
                    <td align="right"><strong><?= number_format($total_diterima, 2, ',', '.'); ?></strong></td>
                  </tr> 
                  <tr>
                    <td colspan="7"><?= terbilang($total_nominal); ?></td>
                  </tr>
                  </tfoot>
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
	