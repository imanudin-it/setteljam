<?php 
// Load the database configuration file 
include_once 'db-config.php'; 
 
// Get status message 
if(!empty($_GET['status'])){ 
    switch($_GET['status']){ 
        case 'succ': 
            $statusType = 'alert-success'; 
            $statusMsg = 'Data SUKSES diimport !'; 
            break; 
        case 'err': 
            $statusType = 'alert-danger'; 
            $statusMsg = 'Ops, terjadi kesalahan. Silahkan coba lagi'; 
            break; 
        case 'invalid_file': 
            $statusType = 'alert-danger'; 
            $statusMsg = 'Format Excel tidak valid !'; 
            break; 
        default: 
            $statusType = ''; 
            $statusMsg = ''; 
    } 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Import Excel File Data with PHP</title>

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css">


<!-- Show/hide Excel file upload form -->
<script>
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}
</script>
</head>
<body>

<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12 p-3">
    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>

<div class="row p-3">
    <!-- Import link -->
    <div class="col-md-12 head">
        <div class="float-end">
            <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import Excel</a>
        </div>
    </div>
    <!-- Excel file upload form -->
    <div class="col-md-12" id="importFrm" style="display: none;">
        <form class="row g-3" action="import-data.php" method="post" enctype="multipart/form-data">
            <div class="col-auto">
                <label for="fileInput" class="visually-hidden">File</label>
                <input type="file" class="form-control" name="file" id="fileInput" />
            </div>
            <div class="col-auto">
                <input type="submit" class="btn btn-primary mb-3" name="importSubmit" value="Import">
            </div>
        </form>
    </div>

    <!-- Data list table --> 
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Kode_TF</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Nominal</th>
                <th>ttd</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        // Get member rows 
        if(isset($_GET['kode']))
        { 
            $kode = htmlspecialchars($_GET['kode']);
            $result = $db->query("SELECT * FROM ttd_jasa where kode_transfer = '$kode'"); 
            if($result->num_rows > 0){ $i=0; 
                while($row = $result->fetch_assoc()){ $i++; 
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['kode_transfer']; ?></td>
                <td><?php echo $row['tanggal']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td align="right"><?php echo number_format($row['nominal'], 0, ",", "."); ?></td>
                <td><?php echo $row['ttd']; ?></td>
            </tr>
        <?php } }else{ ?>
            <tr><td colspan="7">No member(s) found...</td></tr>
        <?php } ?>
    <?php }else{ ?>
            <tr><td colspan="7">Masukkan Kode Transfer...</td></tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>