
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
                    <button type="submit" class="btn btn-primary" name="link" value="list"><i class="bx bx-search"></i> Cari </button>
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
                                     <td> 
                                     
                         <a href="./?link=laporan&kode=<?=$row['kode_transaksi'];?>"><small>  
                          <span class="badge bg-secondary badge-sm mb-2"><cite><?=date('d-m-Y', strtotime($row['tanggal']));?></cite> </span> - <span class="badge bg-warning badge-sm"><cite><?=$row['kode_transaksi'];?></cite> </span>
                        </small> <br> <?=$row['nama'];?></a></td> 

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