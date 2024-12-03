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
                  <h4 class="card-title">Add Program</h4>
				  

                  <form method="post" enctype="multipart/form-data">
					<p class="card-description text-primary">
                      <i class="hgi-stroke hgi-folder-favourite"></i> Add Program details.
					</p>
					<hr />
				  <?php
					
							if (isset($_POST['submit']))
							{
									
								$program_code = $_POST['program_code'];
								$program = $_POST['program'];
								
								$sqlCheck = mysqli_query($conn, "SELECT * FROM program WHERE program_code = '$program_code'");
								$numRowCheck = mysqli_fetch_array($sqlCheck);
								
								if($numRowCheck > 0)
								{
									echo "<div class='alert alert-danger alert-dismissible'>
											<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
											<strong>Sorry!</strong> Program Code $program_code already exist.
										</div>";
								}
								else
								{
									$add = mysqli_query($conn, "INSERT INTO program (program_code, program) VALUES ('$program_code', '$program')");
								
																
									if($add == true)
									{
										$program_code = "";
										$program = "";
										
										echo "<div class='alert alert-success alert-dismissible'>
													<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
													<strong>Thank you!</strong> New program successfully added.
												</div>";
									}
									else
										echo "<div class='alert alert-danger alert-dismissible'>
												<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
												<strong>Sorry!</strong> Error.
											</div>";
								}
								
								
							}


				?>

                  <form method="post" enctype="multipart/form-data">
                    
					
                    <div class="row">
                      <div class="col-md-3">
						<div class="form-group">
							<label>Program Code</label>
							<input type="text" class="form-control" name="program_code" placeholder="Program Code" required />
						</div>
                      </div>
                      <div class="col-md-6">
						<div class="form-group">
							<label>Program</label>
							<input type="text" class="form-control" name="program" placeholder="Program" required />
						</div>
                      </div>
                    </div>
					  
                   
                    
                    
                    <br />
                    <button type="reset" class="btn btn-outline-dark"><i class="mdi mdi-refresh"></i> Reset</button>
					<button type="submit" name="submit" class="btn btn-primary mr-2"><i class="mdi mdi-check"></i> Submit</button>
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