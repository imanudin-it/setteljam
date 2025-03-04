
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
         

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nik = $_POST['nik'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $jumlah = str_replace(['.', ','], ['', '.'], $_POST['jumlah'] ?? '0');
    $pph = str_replace(['.', ','], ['', '.'], $_POST['pph'] ?? '0');
    $diterima = str_replace(['.', ','], ['', '.'], $_POST['diterima'] ?? '0');
    
    if (!empty($id) && !empty($nik) && !empty($nama)) {
        try {
            $sql = "UPDATE ttd_jasa SET nik = :nik, nama = :nama, jabatan = :jabatan, nominal = :jumlah, pph = :pph, diterima = :diterima WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nik', $nik, PDO::PARAM_STR);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':jabatan', $jabatan, PDO::PARAM_STR);
            $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
            $stmt->bindParam(':pph', $pph, PDO::PARAM_STR);
            $stmt->bindParam(':diterima', $diterima, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Data berhasil diperbarui.";
                $_SESSION['message_code'] = "success";
            } else {
                $_SESSION['message'] = "Gagal memperbarui data.";
                $_SESSION['message_code'] = "error";
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = "Error: " . $e->getMessage();
            $_SESSION['message_code'] = "error";
        }
    } else {
        $_SESSION['message'] = "Harap lengkapi data yang wajib diisi.";
        $_SESSION['message_code'] = "warning";
    }
    
    echo '<meta http-equiv="refresh" content="0;url=/adm/?link=laporan&kode=' . $kode . '">';

}

// Proses hapus tanda tangan
if (isset($_GET['hapus']) && isset($_GET['kode'])) {
    $id = $_GET['hapus'];
    $kode = $_GET['kode'];
    
    try {
        $sql = "UPDATE ttd_jasa SET ttd = NULL WHERE kode_transaksi = :kode AND id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':kode', $kode, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Tanda tangan berhasil dihapus.";
            $_SESSION['message_code'] = "success";
        } else {
            $_SESSION['message'] = "Gagal menghapus tanda tangan.";
            $_SESSION['message_code'] = "error";
                }
            } catch (PDOException $e) {
                $_SESSION['message'] = "Error: " . $e->getMessage();
                $_SESSION['message_code'] = "error";
            }
            echo '<meta http-equiv="refresh" content="0;url=/adm/?link=laporan&kode=' . $kode . '">';

          }

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $nik = $_POST['nik'] ?? '';
            $nama = $_POST['nama'] ?? '';
            $jabatan = $_POST['jabatan'] ?? '';
            $nominal = str_replace(['.', ','], ['', '.'], $_POST['nominal'] ?? '0');
            $pph = str_replace(['.', ','], ['', '.'], $_POST['pph'] ?? '0');
            $diterima = str_replace(['.', ','], ['', '.'], $_POST['diterima'] ?? '0');
            
            if (!empty($id) && !empty($nik) && !empty($nama)) {
                try {
                    $sql = "UPDATE ttd_jasa SET nik = :nik, nama = :nama, jabatan = :jabatan, nominal = :nominal, pph = :pph, diterima = :diterima WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->bindParam(':nik', $nik, PDO::PARAM_STR);
                    $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
                    $stmt->bindParam(':jabatan', $jabatan, PDO::PARAM_STR);
                    $stmt->bindParam(':nominal', $nominal, PDO::PARAM_STR);
                    $stmt->bindParam(':pph', $pph, PDO::PARAM_STR);
                    $stmt->bindParam(':diterima', $diterima, PDO::PARAM_STR);
                    
                    if ($stmt->execute()) {
                        $_SESSION['message'] = "Data berhasil diperbarui.";
                        $_SESSION['message_code'] = "success";
                    } else {
                        $_SESSION['message'] = "Gagal memperbarui data.";
                        $_SESSION['message_code'] = "error";
                    }
                } catch (PDOException $e) {
                    $_SESSION['message'] = "Error: " . $e->getMessage();
                    $_SESSION['message_code'] = "error";
                }
            } else {
                $_SESSION['message'] = "Harap lengkapi data yang wajib diisi.";
                $_SESSION['message_code'] = "warning";
            }

            echo '<meta http-equiv="refresh" content="0;url=/adm/?link=laporan&kode=' . $kode . '">';
          }

          // Menampilkan pesan dari session jika ada

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
                        <a href="/adm/laporan_ttd.php?kode=<?=$kode;?>" target="_blank" class="btn btn-success btn-sm mb-3"  id="pdf"> <i class='bx bxs-file-pdf' ></i> Download PDF </a> 
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
                    <th> Opsi </th>
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
                    <td align="center"> 
                      
                    <button data-bs-toggle="modal" data-bs-target="#data<?=$row['id'];?>" class="btn btn-primary btn-sm"><i class='bx bx-edit'></i> Edit </button>
                    <button type="button" class="btn btn-warning btn-sm"  data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="top" data-bs-html="true" data-bs-content="<small>Nama : <?=$row['nama'];?> </small> <div align='right' class='mt-2'><a href='./?link=laporan&kode=<?=$kode;?>&hapus=<?=$row['id'];?>' type='button' class='btn btn-sm btn-primary'>Ya</a></div>" title="" data-bs-original-title="Ulang tanda tangan ini ?" aria-describedby="popover583573"><i class='bx bx-refresh'></i> Reset </button></td>
                    <?php
                    // Tambahkan nilai ke total
                    $total_nominal += (float)$row['nominal'];
                    $total_pph += (float)$row['pph'];
                    $total_diterima += (float)$row['diterima'];
                    ?>
        <div class="modal fade" id="data<?=$row['id'];?>" tabindex="-1" style="display: none;" aria-hidden="true">
        <form action="" method="POST"> 
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1"> Edit : <i><?=$row['nama'];?></i></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                 
                    <input type="hidden" name="id" value="<?=$row['id'];?>">
                  <div class="row mb-3">
                    <div class="col mb-6">
                      <label for="nameBasic" class="form-label">NIP / NRPTT </label>
                      <input type="text" name="nik" id="nameBasic" class="form-control" placeholder="NIP" value="<?=$row['nik'];?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col mb-6">
                      <label for="nameBasic" class="form-label">Nama</label>
                      <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" name="nama" value="<?=$row['nama'];?>">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <div class="col mb-6">
                      <label for="nameBasic" class="form-label">Jabatan</label>
                      <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" name="jabatan" value="<?=$row['jabatan'];?>">
                    </div>
                  </div>
                  <div class="row g-6">
                    <div class="col mb-3">
                      <label for="emailBasic" class="form-label">Jumlah</label>
                      <input type="text" class="form-control" name="nominal" value="<?=number_format($row['nominal'], 2, ',', '.');?>">
                    </div>
                    <div class="col mb-3">
                      <label for="dobBasic" class="form-label">PPh</label>
                      <input type="text" class="form-control" name="pph" value="<?=number_format($row['pph'], 2, ',', '.');?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col mb-6">
                      <label for="nameBasic" class="form-label">Diterima</label>
                      <input type="text" class="form-control" placeholder="Enter Name" name="diterima" value="<?=number_format($row['diterima'], 2, ',', '.');?>">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </div>
        </form>
          </div>
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
	