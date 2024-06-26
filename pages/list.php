
<div class="card mb-4">
<h5 class="card-header mb-3"> <i class="bx bx-list-ol"></i> List Berkas :
<span style="float:right" ><small><a href="javascript: window.history.back()"class="badge badge-sm bg-warning">&laquo; Kembali</a></small></span> </h5>
     <div class="card-body mb-2">
     <?php 
    if(isset($_GET['hapus'])) {
        $kode = $_GET['hapus'];
        
        // Hapus terlebih dahulu record terkait di tabel ttd_jasa
        $sql_delete_ttd_jasa = "DELETE FROM ttd_jasa WHERE kode_transaksi = :kode";
        $stmt_delete_ttd_jasa = $pdo->prepare($sql_delete_ttd_jasa);
        $stmt_delete_ttd_jasa->bindParam(':kode', $kode);
        
        // Kemudian hapus record dari tabel judul
        $sql_delete_judul = "DELETE FROM judul WHERE kode_transaksi = :kode";
        $stmt_delete_judul = $pdo->prepare($sql_delete_judul);
        $stmt_delete_judul->bindParam(':kode', $kode);
        
        try {
            $pdo->beginTransaction();
            
            // Hapus record terkait dari tabel ttd_jasa
            $stmt_delete_ttd_jasa->execute();
            
            // Hapus record dari tabel judul
            $stmt_delete_judul->execute();
            // Hapus direktori terkait
            $folder = './images/' . $kode . '/';
            if (is_dir($folder)) {
                // Hapus isi direktori
                array_map('unlink', glob("$folder/*.*"));
                // Hapus direktori itu sendiri
                rmdir($folder);
            }
            $pdo->commit();
            echo '<div class="alert alert-warning">Berhasil dihapus!</div>';
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
        }
    }
    
?>
        <div class="row">
            <div class="col-md-8 col-lg-8 mx-auto" align="right">
                <form action="" method="GET">
            <div class="input-group">
                 <span class="input-group-text">Periode : </span>
                    <input type="date" aria-label="periode a" class="form-control" name="tgl_a" value="<?php echo isset($_GET['tgl_a']) ? $_GET['tgl_a'] : date('Y-m-d'); ?>">
                    <input type="date" aria-label="periode b" class="form-control" name="tgl_b" value="<?php echo isset($_GET['tgl_b']) ? $_GET['tgl_b'] : date('Y-m-d'); ?>">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Cari </button>
               </div>
                </form>
            </div>
        </div>
        <br>
        <div class="table-responsive text-wrap">
                  <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Judul</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if(!isset($_GET['tgl_a'])){ 
                            ?>
                            <tr>
                            <td>-</td>
                            <td>Pilih periode terlebih dahulu !</td>
                            </tr>
                        <?php }else{ 
                            $sql = "SELECT a.*, b.kode_transaksi as spj FROM judul a
                            LEFT JOIN spj b on b.kode_transaksi = a.kode_transaksi 
                             WHERE a.tanggal BETWEEN :start_date AND :end_date";

                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':start_date', $_GET['tgl_a']);
                            $stmt->bindParam(':end_date', $_GET['tgl_b']);
                            $stmt->execute();

                            // Ambil data yang dipilih
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Gunakan data yang telah dipilih
                            $no = 1;
                            foreach ($results as $row) {
                                echo'
                                    <tr>
                                    <td> '.$no++.' </td>
                                    '; ?>
                                    <td> <a data-bs-toggle='modal'
                          data-bs-target='#data<?=$row['id'];?>'href="#"><small>  
                          <span class="badge bg-secondary badge-sm mb-2"><cite><?=date('d-m-Y', strtotime($row['tanggal']));?></cite> </span> - <span class="badge bg-warning badge-sm"><cite><?=$row['kode_transaksi'];?></cite> </span>
                        </small> <br> <?=$row['nama'];?></a></td> 

                                        

                        <!-- Modal -->
                        <div class="modal fade" id="data<?=$row['id'];?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle"><span class="badge bg-warning badge-sm">Kode : <cite><?=$row['kode_transaksi'];?></cite> </span>
                                </h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3">
                                  <textarea class="form-control mb-2" disabled><?=$row['nama'];?></textarea>
                                    <label for="nameWithTitle" class="form-label">Url :</label>
                                      <div class="input-group">
                                        <input type="text" id="link<?=$row['id'];?>" class="form-control" value="http://<?=$_SERVER['SERVER_NAME'];?>/<?=$folder;?>ttd.php?kode=<?=$row['kode_transaksi'];?>" aria-describedby="button-addon2">
                                        <!-- <a target="_blank" class="btn btn-outline-primary" href="http://<?=$_SERVER['SERVER_NAME'];?>/<?=$folder;?>/ttd.php?kode=<?=$row['kode_transaksi'];?>">&raquo;</a> -->
                                        <button type="button" class="btn btn-outline-primary" onclick="copyLink('link<?=$row['id'];?>')" title="Salin Link"><i class='bx bx-link-alt'></i></button>
                                      </div>
                                      <small><cite> Salin & Bagikan url ini untuk tanda tangan</cite></small>
                                    </div>
                                  </div>
                                  <div style="float: left;">
                                      <?php 
                                        if(empty($row['spj'])){
                                          echo'<a href="./spj?buat='.$row['kode_transaksi'].'" class="btn btn-info btn-sm"><i class="bx bxs-file-plus" ></i> Buat SPJ </i></a>';
                                        }else{
                                          echo'<a href="./spj?buat='.$row['kode_transaksi'].'" class="btn btn-info btn-sm"><i class="bx bxs-file"></i> Print SPJ </i></a>';
                                        }
                                      ?>
                                      
                                      <a href="./laporan?kode=<?=$row['kode_transaksi'];?>" class="btn btn-success btn-sm">
                                      <i class='bx bxs-report' ></i> Berkas Tanda Tangan  
                                        </a> 
                                  </div>
                                </div>
                              <div class="modal-footer">
                              
                              
                              
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                <i class="bx bx-x-circle"></i>Batal
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"  data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="top" data-bs-html="true" data-bs-content="<small>Berkas dan tanda tangan akan dihapus </small> <div align='right' class='mt-2'><a href='./list?hapus=<?php echo $row['kode_transaksi']; ?>' type='button' class='btn btn-sm btn-primary'>Ya</a></div>" title="" data-bs-original-title="Yakin akan dihapus ?" aria-describedby="popover583573"><i class='bx bx-trash'></i> Hapus </button>
                              </div>
                            </div>
                          </div>
                        </div>
                                   <?php echo'
                                    </tr>
                                ';

                            }
                            } ?>
                    </tbody>
                </table>
        </div>
  </div>
</div>
<script>
function copyLink(id) {
  var linkInput = document.getElementById(id);
  linkInput.select();
  document.execCommand('copy');
  var notification = document.createElement('div');
  notification.textContent = 'Link berhasil disalin!';
  notification.style.position = 'fixed';
  notification.style.top = '20px';
  notification.style.right = '20px';
  notification.style.padding = '10px';
  notification.style.backgroundColor = '#4CAF50';
  notification.style.color = 'white';
  notification.style.borderRadius = '5px';
  notification.style.zIndex = '9999';
  document.body.appendChild(notification);

  setTimeout(function() {
    notification.style.display = 'none';
  }, 5000);
}
</script>
