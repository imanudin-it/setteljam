<!-- Footer -->
<footer class="content-footer footer bg-footer-theme" >
              <div class="container-xxl d-flex flex-wrap py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0"align="center">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://facebook.com/imanudin.it" target="_blank" class="footer-link fw-bolder">&copy; IT <?=$namaRS;?></a>
                </div>
                <div>
                  
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/js/bootstrap.js"></script>

    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/DataTables/datatables.js"></script>
    <script>
$(document).ready( function () {
    // Inisialisasi DataTable
    $('#myTable').DataTable({
      pageLength: 50
    });
} );
</script>
    <!-- Main JS -->
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/js/main.js"></script>
    <script src="//<?=$_SERVER['HTTP_HOST'] ;?>/assets/js/ui-popover.js"></script>
