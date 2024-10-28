<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                   Selamat Datang..
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                <span class="badge rounded-pill bg-secondary"><a href="./"><i class="bx bx-home"></i> </a> </span>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="/assets/img/logo-rsud.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="/assets/img/logo-rsud.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?=$_SESSION['data']['nama'];?></span>
                            <small class="text-muted"><?= isset($_SESSION['data']['nip']) && $_SESSION['data']['nip'] ? $_SESSION['data']['nip'] : 'STTELJAM'; ?>
                            </small>
                          </div>
                        </div>
                      </a>
                    </li>
                    
                    <li>
                      <a class="dropdown-item" href="/logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->


          <!-- / Navbar -->
          <nav style="font-size:10px; background-color: #fcfdfd !important; border-top-left-radius: 1.0rem; border-top-right-radius: 1.0rem;" class="navbar navbar-white navbar-expand fixed-bottom text-white d-md-none d-lg-none d-xl-none">
      <ul class="navbar-nav nav-justified w-100">
     
      <li class="nav-item" style="border-left:1px gey">
        <a href="/" class="nav-link" >
        <i class='bx bx-home'></i><br> Home
          </a>
      </li>
       <li class="nav-item" style="border-left: 2px solid #eceef1; border-right: 2px solid #eceef1;">
         <a href="#" onclick="javascript:window.location.reload()" class="nav-link">
         <i class='bx bx-refresh'></i> <br> Refresh
         </a>
      </li>
      <li class="nav-item" style="border-left: 0px solid #eceef1; border-right: 2px solid #eceef1;">
         <a href="#" onclick="javascript:window.history.back()" class="nav-link">
         <i class='bx bx-left-arrow-alt'></i><br>Back
         </a>
      </li>
      
    </ul>
  </nav>