
<!DOCTYPE html>
<?php 
    require_once('./db-config.php');
    require_once('./layouts/header.php');
    ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <body>
         <style>
            /* mengatur ukuran canvas tanda tangan  */
            canvas {
                border: 1px solid #ccc;
                border-radius: 0.5rem;
                width: 300px;
                height: 300px;
            }
        </style>
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
                
                <div class="row">
              <?php 
              $kode = isset($_GET['kode']) ? $_GET['kode'] : '';
              $nik = isset($_GET['nik']) ? $_GET['nik'] : '';
              if($kode){ 
                $sql = "SELECT a.*, b.nama as judul FROM ttd_jasa a
                        LEFT JOIN judul b on b.kode_transaksi = a.kode_transaksi 
                        WHERE a.kode_transaksi = :kode AND a.nik = :nik";
                $stmt = $pdo->prepare($sql);

                $stmt->execute([':kode' => $kode,
                                 ':nik' => $nik]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                 if (!$result) {
                        echo "<center> Data tidak ditemukan ! </center>";
                    }else{
                        $id = $result['id'];
                         ?>
                      <div class="col-md-8 col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title" align="center"> <?=$result['judul'];?> </h5>
                        </div>
                        <div class="card-body">
                        <div class="demo-inline-spacing mt-0">
                            <ul class="list-group">
                            <li class="list-group-item d-flex align-items-center">
                                <i class='bx bxs-user me-2'></i> <a href="#" class="badge bg-warning text-white"> <?=$result['nama'];?></a>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class='bx bxs-buildings me-2'></i> <small> <?=$result['jabatan'];?> </small>
                            </li>
                            </ul>
                            <div class="table-responsive"> 
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr class="table-warning"> <td width="30%"> Jumlah </td><td> Rp. <?=number_format($result['nominal'], 0,',','.');?> </td> </tr>
                                        <tr class="table-danger"> <td> PPh </td><td> Rp. <?=number_format($result['pph'], 0,',','.');?> </td> </tr>
                                        <tr class="table-success">  <td> Diterima </td><td> Rp. <?=number_format($result['diterima'], 0,',','.');?> </td> </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-4">
                    <?php if(!empty($result['ttd'])){ ?>
                        <div class="card mb-3">
                        <div class="card-body" align="center">
                        <img src="<?=$result['ttd'];?>" style="width:80%">
                        </div>
                        </div>
                    <?php }else{ ?>
                    <div class="card shadow-none bg-transparent border border-info mb-3">
                        <div class="card-header"> Silahkan Tanda Tangan : </div>
                        <div class="card-body" align="center"> <font color="red" class="mb-2"><small> * Usahakan besar tanda tangan sesuai kotak ! </small></font>
                        <canvas id="signature-pad" class="signature-pad"></canvas>
    
    
    <div style="float: right;">
         <button id="btn-submit" class="btn btn-primary btn-sm">
            Simpan
        </button><!-- tombol undo  -->
        <button type="button" class="btn btn-dark btn-sm" id="undo">
            <span class="fas fa-undo"></span>
            Undo
        </button>

        <!-- tombol hapus tanda tangan  -->
        <button type="button" class="btn btn-danger btn-sm" id="clear">
            <span class="fas fa-eraser"></span>
            Clear
        </button>
    </div>
                        </div>
                    </div>
                <?php 
                    } //end else
                }
                } ?>
                </div>
                </div>
                    </div>
                </div>
        
            </div>
            </div>
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
    <script src="./assets/js/signature_pad.min.js"></script>
    <script>
            // script di dalam ini akan dijalankan pertama kali saat dokumen dimuat
            document.addEventListener('DOMContentLoaded', function () {
                resizeCanvas();
            })
    
            //script ini berfungsi untuk menyesuaikan tanda tangan dengan ukuran canvas
            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }
    
    
            var canvas = document.getElementById('signature-pad');
    
            //warna dasar signaturepad
            var signaturePad = new SignaturePad(canvas, {
                
            });
    
            //saat tombol clear diklik maka akan menghilangkan seluruh tanda tangan
            document.getElementById('clear').addEventListener('click', function () {
                signaturePad.clear();
            });
    
            //saat tombol undo diklik maka akan mengembalikan tanda tangan sebelumnya
            document.getElementById('undo').addEventListener('click', function () {
                var data = signaturePad.toData();
                if (data) {
                    data.pop(); // remove the last dot or line
                    signaturePad.fromData(data);
                }
            });
    
            
    
            //fungsi untuk menyimpan tanda tangan dengan metode ajax
            $(document).on('click', '#btn-submit', function () {
    var signature = signaturePad.toDataURL();

    $.ajax({
        url: "proses.php",
        data: {
            foto: signature,
            id: <?=$id;?>,
            kode: "<?=$result['kode_transaksi'];?>",
            nama: "<?=$result['nama'];?>",
        },
        method: "POST",
        method: "POST",
        success: function (response) {
            if (response.trim() === "success") {
                Swal.fire({
                  title: 'Terima Kasih 😉 ',
                  text: 'Telah melakukan tanda tangan !',
                  icon: 'success',
                  confirmButtonText: '✔️ Sip',
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.reload();
                  }
                });
            } else {
                Swal.fire({
                  title: 'Error 😒 ',
                  text: 'Tidak terhubung ke sistem !',
                  icon: 'error',
                  confirmButtonText: 'Ok'
                })
            }
        },
        error: function () {
                 Swal.fire({
                  title: 'Error 😮 ',
                  text: 'Proses Tidak terhubung ke sistem !',
                  icon: 'error',
                  confirmButtonText: 'Ok'
                })
            }
    });
});
        </script>
    </body>
    </html>