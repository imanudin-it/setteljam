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
            <div class="card mb-4">
<h5 class="card-header"><i class='bx bx-user'></i>  Data Pegawai / User Login :
<div style="float:right"> <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#basicModal">
     <i class='bx bx-plus'></i> Tambah Data </button>
                        </button> </div>
                        <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="./pages/simpan-pegawai.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Tambah Data Pegawai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label" for="employee-name">Name</label>
            <div class="col-sm-8">
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-user"></i></span>
                <input type="text" class="form-control" id="employee-name" name="name" placeholder="Nama Pegawai" required>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label" for="employee-nip">NIP</label>
            <div class="col-sm-8">
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class='bx bx-user-pin'></i></span>
                <input type="text" class="form-control" id="employee-nip" name="nip" placeholder="NIP/NRPTT" required>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label" for="employee-password">Password</label>
            <div class="col-sm-8">
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class='bx bxs-key'></i></span>
                <input type="password" class="form-control" id="employee-password" name="password" placeholder="Password" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Simpan </button>
        </div>
      </div>
    </form>
  </div>
</div>

                        <br>
                        <br>
<div class="card-body">
<div class="table-responsive text-wrap">
    <table width="100%" class="table table-bordered table-hover" id="myTable">
        <thead align="center">
            <tr align="center">
                <th width="10">No</th>
                <th>NAMA</th>
                <th>NIP</th>
                <th>OPSI</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT * FROM pegawai ORDER BY nama ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $no = 1;

            foreach($results as $row) {
                echo '<tr>';
                echo '<td>'.$no++.'</td>';
                echo '<td>'.$row['nama'].'</td>';
                echo '<td>'.$row['nip'].'</td>';
                echo '<td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal'.$row['nip'].'">
                            <i class="bx bx-edit"></i> Edit
                        </button>

                        <!-- Reset Password Button -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#resetModal'.$row['nip'].'">
                            <i class="bx bx-reset"></i> Reset Password
                        </button>

                        <!-- Delete Button -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal'.$row['nip'].'">
                            <i class="bx bx-trash"></i> Hapus
                        </button>
                    </td>';
                echo '</tr>';

                // Edit Modal for each row
                echo '
                <div class="modal fade" id="editModal'.$row['nip'].'" tabindex="-1" aria-labelledby="editModalLabel'.$row['nip'].'" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="./pages/edit-pegawai.php" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel'.$row['nip'].'">Edit Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="nip" value="'.$row['nip'].'">
                                    <div class="mb-3">
                                        <label for="namaPegawai" class="form-label">Nama Pegawai</label>
                                        <input type="text" class="form-control" id="namaPegawai" name="nama" value="'.$row['nama'].'" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                ';

                // Reset Password Modal for each row
                echo '
                <div class="modal fade" id="resetModal'.$row['nip'].'" tabindex="-1" aria-labelledby="resetModalLabel'.$row['nip'].'" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="./pages/reset-pegawai.php" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resetModalLabel'.$row['nip'].'">Reset Password Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="nip" value="'.$row['nip'].'">
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-danger">Reset Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                ';

                // Delete Modal for each row
                echo '
                <div class="modal fade" id="deleteModal'.$row['nip'].'" tabindex="-1" aria-labelledby="deleteModalLabel'.$row['nip'].'" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="./pages/hapus-pegawai.php" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel'.$row['nip'].'">Hapus Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="nip" value="'.$row['nip'].'">
                                    <p>Apakah Anda yakin ingin menghapus pegawai <strong>'.$row['nama'].'</strong> dengan NIP <strong>'.$row['nip'].'</strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                ';
            }
            ?>
        </tbody>
    </table>
</div>
