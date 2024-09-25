
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="card mb-4">
<h5 class="card-header mb-3"> <i class="bx bx-list-ol"></i> Pengaturan Akun :
<span style="float:right" ><small><a href="javascript: window.history.back()"class="badge badge-sm bg-warning">&laquo; Kembali</a></small></span> </h5>
     <div class="card-body mb-2">
     <div class="card-body p-0">
                      <!-- <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="../assets/img/avatars/user.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                       <div><h3><?=$_SESSION['data']['nama'];?> </h3> </div>
                       <div> <?=$_SESSION['data']['nip'];?> </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                             
                            <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                        <img src="../assets/img/avatars/user.webp" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                        <h5> <?=$_SESSION['data']['nama'];?> </h5>
                        <p class="text-muted mb-0"><?=$_SESSION['data']['nip'];?></p>
                        </div>
                        
                      </div>
                      


                        <!-- <div class="d-flex justify-content-center pt-4 gap-2">
                            <div class="flex-shrink-0" style="position: relative;">
                              <div id="expensesOfWeek" style="min-height: 57.7px;">
                              <img src="../assets/img/avatars/user.png" alt="user-avatar" class="d-block rounded" height="80" width="80" id="uploadedAvatar">
                            </div>
                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 61px; height: 59px;"></div></div><div class="contract-trigger"></div></div></div>
                            <div>
                              <h4 class="mt-2 mb-2"><?=$_SESSION['data']['nama'];?></h4>
                              <small class="text-muted"> <?=$_SESSION['data']['nip'];?></small>
                            </div>
                          </div> -->
                            </div>
                            <div class="col-md-8 col-lg-8">
                                <div class="card">
                                <h5 class="card-header mb-0"> Ganti Password :</h5>
                                <hr class="text-muted"> 
                                    <div class="card-body">
                                    <form method="POST" action="./pages/ganti-password.php">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Sekarang :</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Ulangi Password Baru</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePasswordVisibility()">
                                <label class="form-check-label" for="showPassword">Show Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Change Password</button>
                        </form>
                                    </div>
                                </div>
                                
                            </div>
                    </div>
  </div>
</div>
<script>
        function togglePasswordVisibility() {
            var currentPassword = document.getElementById("current_password");
            var newPassword = document.getElementById("new_password");
            var confirmPassword = document.getElementById("confirm_password");
            var showPasswordCheckbox = document.getElementById("showPassword");

            if (showPasswordCheckbox.checked) {
                currentPassword.type = "text";
                newPassword.type = "text";
                confirmPassword.type = "text";
            } else {
                currentPassword.type = "password";
                newPassword.type = "password";
                confirmPassword.type = "password";
            }
        }

        // SweetAlert for success or error message
        <?php if (isset($_SESSION['message']) && $_SESSION['message'] != '') { ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['message_code']; ?>',
                title: '<?php echo $_SESSION['message']; ?>',
                text: '<?php echo $_SESSION['message_text']; ?>'
            });
            <?php unset($_SESSION['message']); unset($_SESSION['message_code']); unset($_SESSION['message_text']); ?>
        <?php } ?>
    </script>