<?php

if(isset($_POST['simpan'])) {
    // Assuming these fields are sent via POST method
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    // Prepare an SQL statement with placeholders
    $stmt = $pdo->prepare("INSERT INTO penanggung_jawab_spj (nip, nama, jabatan) VALUES (:nip, :nama, :jabatan)");

    // Bind parameters
    $stmt->bindParam(':nip', $nip);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':jabatan', $jabatan);

    // Execute the statement
    $stmt->execute();
    
    // Optionally, you can check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            $_SESSION['pesan'] = '<div class="alert alert-success">Berhasil disimpan !</div>';
            } else {
            $_SESSION['pesan'] = '<div class="alert alert-danger">Proses gagal !</div>';
        }
}

if(isset($_POST['hapus'])) {
    $kode = $_POST['hapus'];
    
    // Hapus terlebih dahulu record terkait di tabel ttd_jasa
    $sql = "DELETE FROM penanggung_jawab_spj WHERE id = :kode";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kode', $kode);
    
    try {
        $pdo->beginTransaction();
        
        // Hapus record terkait dari tabel ttd_jasa
        $stmt->execute();
        $pdo->commit();
        $_SESSION['pesan'] = '<div class="alert alert-warning">Berhasil dihapus!</div>';
        } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['pesan'] = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
       }
}


// Mengecek apakah pesan tersedia dalam session
if(isset($_SESSION['pesan'])) {
    // Menampilkan pesan
    echo $_SESSION['pesan'];
    // Menghapus pesan dari session (jika Anda ingin pesan hanya ditampilkan sekali)
    unset($_SESSION['pesan']);
}
?>

<div class="card mb-4">
<h5 class="card-header mb-3"> <i class="bx bx-list-ol"></i> Penanggung Jawab :
<span style="float:right" ><small><a href="javascript: window.history.back()"class="badge badge-sm bg-warning">&laquo; Kembali</a></small></span> </h5>
     <div class="card-body mb-2">
     <div class="card accordion-item mb-3">
                      <h2 class="accordion-header" id="headingOne">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                        <i class='bx bxs-file-plus '></i> &nbsp; Tambah Data 
                        </button>
                      </h2>

                      <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" >
                        <div class="accordion-body mt-2">
                            <form action="" method="POST">
                            <div class="row"> 
                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="nip" type="text" class="form-control" id="floatingInput" placeholder="1234567890" aria-describedby="floatingInputHelp">
                                        <label for="floatingInput">NIP</label>
                                        <div id="floatingInputHelp" class="form-text"> <cite> * kosongkan jika tidak ada </cite>
                                    </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input name="nama" type="text" class="form-control" id="floatingInput" placeholder="Nama" aria-describedby="floatingInputHelp">
                                        <label for="floatingInput">Nama</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input name="jabatan" type="text" class="form-control" id="floatingInput" placeholder="Jabatan" aria-describedby="floatingInputHelp">
                                        <label for="floatingInput">Jabatan</label>
                                    </div>
                                    <div align="right">
                                    <button type="submit" name="simpan" class="btn btn-primary btn-sm"><i class="bx bxs-save"></i> Simpan</button>
                                    </div>
                            </div>
                            </div>
                            </form>
                        </div>
                      </div>
                    </div>
  
        <div class="table-responsive text-wrap" style="font-size: 12px;">
                  <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>JABATAN</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        
                            $sql = "SELECT * FROM penanggung_jawab_spj";

                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();

                            // Ambil data yang dipilih
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Gunakan data yang telah dipilih
                            $no = 1;
                            foreach ($results as $row) {
                                echo'
                                    <tr>
                                    <td> '.$no++.' </td>
                                    <td> '.$row['nip'].' </td>
                                    <td> '.$row['nama'].' </td>
                                    <td> '.$row['jabatan'].' </td>
                                    ';
                                    ?>
                                    
                                    <td align="center"style="font-size: 12px;"> <button type="button" class="btn btn-danger btn-sm"  data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="left" data-bs-html="true" data-bs-content="<small>Nama : <?=htmlspecialchars($row['nama']);?>  <br> Jabatan : <?=htmlspecialchars($row['jabatan']);?>    </small>  <div align='right' class='mt-2'>
        <form action='' method='POST'>
            <input type='hidden' name='hapus' value='<?php echo $row['id']; ?>'>
            <button type='submit' class='btn btn-sm btn-primary'><i class='bx bx-trash'></i> Ya</button>
        </form>
    </div>" title="" data-bs-original-title="Yakin akan dihapus ?" aria-describedby="popover583573"><i class='bx bx-trash'></i> </button>
                                    </td>
                                    </tr>

                              <?php   
                            } ?>
                    </tbody>
                </table>
        </div>
  </div>
</div>
