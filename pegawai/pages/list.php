
<div class="card mb-4">
<h5 class="card-header mb-3"> <i class="bx bx-list-ol"></i> List Berkas :
<span style="float:right" ><small><a href="javascript: window.history.back()"class="badge badge-sm bg-warning">&laquo; Kembali</a></small></span> </h5>
     <div class="card-body mb-2">
     <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#basicModal">
     <i class='bx bx-search-alt'></i> Pilih Periode Laporan </button>
                        </button>

                        <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                          <form action="" method="GET">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Periode Laporan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                             
                                <div class="row g-2">
                                  <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Tgl. Mulai</label>
                                    <input type="date" id="emailBasic" class="form-control" placeholder="DD / MM / YY" name="tgl_a" value="<?php echo isset($_GET['tgl_a']) ? $_GET['tgl_a'] : date('Y-m-d'); ?>">
                                  </div>
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Sampai</label>
                                    <input type="date" id="dobBasic" class="form-control" placeholder="DD / MM / YY" name="tgl_b" value="<?php echo isset($_GET['tgl_b']) ? $_GET['tgl_b'] : date('Y-m-d'); ?>">
                                  </div>
                                </div>
                              
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Tutup
                                </button>
                                <button type="submit" name="link" value="list" class="btn btn-primary"><i class='bx bx-search-alt'></i> Cari </button>
                              </div>
                            </div>
                          </div>
                          </form>
                        </div>
        
        <br>
        <div class="table-responsive ">
                  <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Judul</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                       if (!isset($_GET['tgl_a']) || empty($_GET['tgl_a'])) { 
                           // Query untuk bulan dan tahun saat ini
                           $sql = "SELECT a.*, b.* 
                                   FROM ttd_jasa a
                                   LEFT JOIN judul b ON b.kode_transaksi = a.kode_transaksi 
                                   WHERE a.nik = :nip
                                  --  or (
                                  --      MONTH(b.tanggal) = MONTH(NOW()) 
                                  --      AND YEAR(b.tanggal) = YEAR(NOW())
                                  --  )
                                   AND a.ttd is NULL";
                           
                           $stmt = $pdo->prepare($sql);
                           $stmt->bindParam(':nip', $_SESSION['data']['nip']);
                           
                       } else { 
                           // Query untuk rentang tanggal
                           $sql = "SELECT a.*, b.* 
                                   FROM ttd_jasa a
                                   LEFT JOIN judul b ON b.kode_transaksi = a.kode_transaksi 
                                   WHERE a.nik = :nip
                                   AND b.tanggal BETWEEN :start_date AND :end_date
                                  ";
                           
                           $stmt = $pdo->prepare($sql);
                           $stmt->bindParam(':nip', $_SESSION['data']['nip']);
                           $stmt->bindParam(':start_date', $_GET['tgl_a']);
                           $stmt->bindParam(':end_date', $_GET['tgl_b']);
                       }
                       
                       $stmt->execute();
                       
                       // Ambil data yang dipilih
                       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                            // Gunakan data yang telah dipilih
                            $no = 1;
                            foreach ($results as $row) {
                              if(empty($row['ttd']) || $row['ttd']=='-') {
                                $tr = "bg-label-warning";
                              }else {$tr = "bg-label-success"; }
                              echo'
                                    <tr class="'.$tr.' text-primary">
                                    <td> '.$no++.' </td>
                                    '; ?>
                                    <td> <a href="./?link=ttd&kode=<?=$row['kode_transaksi'];?>"><small>  
                          <span class="badge bg-secondary badge-sm mb-2">
                            <cite><?=date('d-m-Y', strtotime($row['tanggal']));?></cite> 
                        </span> - 
                            <cite>
                                <?php
                                if(empty($row['ttd']) || $row['ttd']=='-') {
                                    echo '<span class="badge bg-warning badge-sm"> ❌ Belum TTD </span> ';
                                  }else{ echo '<span class="badge bg-success badge-sm"> ✔️ Sudah TTD </span>';
                                  } 
                                ?>
                            </cite> </span>
                        </small> <br> <?=$row['nama'];?></a></td> 

                                   <?php echo'
                                    </tr>
                                ';

                            } ?>
                    </tbody>
                </table>
        </div>
  </div>
</div>