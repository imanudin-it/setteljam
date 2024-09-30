
<div class="card mb-4">
    <h5 class="card-header">
        <i class='bx bx-user'></i> Data Pegawai / User Login:
        <div style="float:right">
            <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#basicModal">
                <i class='bx bx-plus'></i> Tambah Data
            </button>
        </div>
    </h5>
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
    <div class="card-body">
        
    <div class="card-body">
        <!-- Search Form -->
        <form method="GET" action="" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari nama atau NIP..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="btn btn-info" name="link" value="pegawai">
                    <i class="bx bx-search"></i> Cari
                </button>
            </div>
        </form>
        <div class="table-responsive text-no-wrap mb-3">
            <table width="100%" class="table table-bordered table-hover">
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
                    // Pagination settings
                    $limit = 50; // Number of records per page
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Search functionality
                    $search = isset($_GET['search']) ? '%'.$_GET['search'].'%' : '%';

                    // Fetch data with limit, offset, and search
                    $sql = "SELECT * FROM pegawai WHERE nama LIKE :search OR nip LIKE :search ORDER BY nama ASC LIMIT :limit OFFSET :offset";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
                    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $no = $offset + 1;
                    foreach ($results as $row) {
                        echo '<tr>';
                        echo '<td>'.$no++.'</td>';
                        echo '<td>'.$row['nama'].'</td>';
                        echo '<td>'.$row['nip'].'</td>';
                        echo '<td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal'.$row['nip'].'">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#resetModal'.$row['nip'].'">
                                    <i class="bx bx-reset"></i> Reset Password
                                </button>
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
                                    <h5 class="modal-title" id="editModalLabel'.$row['nip'].'">Edit : '.$row['nama'].'</h5>
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
                                    <h5 class="modal-title" id="resetModalLabel'.$row['nip'].'">Reset : '.$row['nama'].'</h5>
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
                                    <h5 class="modal-title" id="deleteModalLabel'.$row['nip'].'">Hapus : '.$row['nama'].'</h5>
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

        <!-- Pagination Controls -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php 
                // Calculate total pages
                $sql_count = "SELECT COUNT(*) AS total FROM pegawai";
                $stmt_count = $pdo->prepare($sql_count);
                $stmt_count->execute();
                $total_rows = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];
                $total_pages = ceil($total_rows / $limit);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li class="page-item '.($i == $page ? 'active' : '').'">
                            <a class="page-link" href="./?link=pegawai&page='.$i.'">'.$i.'</a>
                          </li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</div>
