<?php
include "conn/conn.php";
error_reporting(0);
session_start();
if (empty($_SESSION['UserID']) AND empty($_SESSION['Password']))
{
  header('location:index.php');
}
else
{
?>

<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include "layout/head.php";?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php include "layout/top.php";?>
	
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
       <?php include "layout/menu.php";?>
	   
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
		
          <div class="row">
            
            
            <div class="col-12 grid-margin">
			
              <div class="card">
                <div class="card-body">
                   <h4 class="card-title">Update Program</h4>
				  

                  <form method="post" enctype="multipart/form-data">
					<p class="card-description text-primary">
                      <i class="hgi-stroke hgi-folder-favourite"></i> Update Program details.
					</p>
					<hr />
				  <?php
					
							if (isset($_POST['submit']))
							{
									
								$program_code = $_POST['program_code'];
								$program = $_POST['program'];
								
								$sqlCheck = mysqli_query($conn, "SELECT * FROM program WHERE program = '$program'");
								$numRowCheck = mysqli_fetch_array($sqlCheck);
								
								if($numRowCheck > 0)
								{
									echo "<div class='alert alert-danger alert-dismissible'>
											<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
											<strong>Sorry!</strong> Program $program already exist.
										</div>";
								}
								else
								{
									$sql = mysqli_query($conn, "UPDATE program SET program = '$program' WHERE program_code = '$program_code'");
								
																
									if($sql == true)
									{
										
										echo "<div class='alert alert-success alert-dismissible'>
													<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
													<strong>Thank you!</strong> Program $program_code successfully updated.
												</div>";
									}
									else
										echo "<div class='alert alert-danger alert-dismissible'>
												<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
												<strong>Sorry!</strong> Error.
											</div>";
								}
								
								
							}
							
							$program_code = $_GET['program_code'];
							$sql = mysqli_query($conn, "SELECT * FROM program WHERE program_code = '$program_code'");
							$row = mysqli_fetch_array($sql);


				?>
				<br />

                  <form method="post" enctype="multipart/form-data">
                  <input type="hidden" class="form-control" name="program_code" value="<?php echo $row['program_code']; ?>" />
 
					
                    <div class="row">
                      <div class="col-md-3">
						<div class="form-group">
							<label>Program Code</label>
							<input type="text" class="form-control" name="program_code" value="<?php echo $row['program_code']; ?>" placeholder="Program Code" readonly />
						</div>
                      </div>
                      <div class="col-md-6">
						<div class="form-group">
							<label>Program</label>
							<input type="text" class="form-control" name="program" value="<?php echo $row['program']; ?>" placeholder="Program" required />
						</div>
                      </div>
                    </div>
					
					<br />
                    <a href="manage_program.php" class="btn btn-outline-dark">
						<i class="mdi mdi-keyboard-backspace"></i> Back
					</a>
					<button type="submit" name="submit" class="btn btn-primary mr-2"><i class="mdi mdi-check"></i> Update</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php include "layout/footer.php";?>
		
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <!-- SCRIPT -->
   <?php include "layout/script.php";?>
</body>

</html>
<?php
}
?>