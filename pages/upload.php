
<?php
    if (isset($_GET['up'])) {
        if($_GET['up'] == 'gagal') {
         echo '<div class="alert alert-danger"> Gagal Menambah Judul ! </div>'; }
    }
    if (isset($_GET['status'])) {
        if($_GET['status']=='succ'){
        echo '<div class="alert alert-success"> Berhasil Menambah Data</div>';
    }else{ echo '<div class="alert alert-danger"> Gagal Menambah Data ! </div>'; }
}
?>
            <div class="card mb-4">
            <form class="row g-3" action="import-data.php" method="post" enctype="multipart/form-data">
                    <h5 class="card-header mb-3"><i class="bx bx-upload"></i> Upload Berkas :</h5>
                    <div class="card-body mb-0">
                     <div class="row">
                        <div class="col-6">
                             <div class="form-floating mb-3">
                                <input type="text" name="kode_transaksi" class="form-control" id="floatingInput" placeholder="Kode " aria-describedby="floatingInputHelp"required>
                                    <label for="floatingInput">Kode Transaksi :</label>
                                    <div id="floatingInputHelp" class="form-text">
                                    <i>(Kode transaksi yang dilakukan)</i>
                                    </div>
                                </div>
                        </div>
                        
                        <div class="col-6">
                        <div class="form-floating mb-3">
                                <input type="date" name="tanggal" class="form-control" id="floatingInput" placeholder="Kode " aria-describedby="floatingInputHelp" required>
                                    <label for="floatingInput">Tanggal :</label>
                                    <div id="floatingInputHelp" class="form-text">
                                    <i>(Tanggal transaksi yang dilakukan)</i>
                                    </div>
                                </div>
                            </div>
                     </div>
                      <div class="form-floating mb-3">
                        <textarea row="2" name="judul" type="text" class="form-control" id="floatingInput" placeholder="Judul" aria-describedby="floatingInputHelp"required></textarea>
                        <label for="floatingInput">Judul :</label>
                        <div id="floatingInputHelp" class="form-text">
                          <i>(Judul dari berkas/transaksi)</i>
                        </div>
                      </div>
                      <div class="input-group">
                        <input type="file" name="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload"required>
                      </div>
                      <div id="floatingInputHelp" class="form-text">
                          <i>(Upload berkas Excel)</i>
                        </div>
                       
                  </div>
                  <div class="card-footer mt-0 text-right" align="right">
                  <div style="float:left" class="mt-3">
                    <a href="./contoh.xlsx" class="btn btn-info btn-xs"> <small>
                                      <i class='bx bxs-download' ></i> Contoh Template File Excel 
                                      </small> </a> </div>
                  <div class="demo-inline-spacing">
                       <a class="btn btn-warning" href="./index.php" > <i class='bx bx-arrow-back' ></i> &nbsp; </a>
                       <button type="submit" name="importSubmit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan </button>
                        
                        
                  </div>
                  </div>
            </form>
                    </div>

