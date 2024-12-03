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
			
				<?php
					
							if (isset($_POST['submit']))
							{
								$month = $_POST['month'];
								$year = $_POST['year'];
								
								// Convert the numeric month to a month name
								$dateObj = DateTime::createFromFormat('!m', $month);
								$month_name = $dateObj->format('F');  // e.g., "January" for 1
								
								$sqlCheck = mysqli_query($conn, "SELECT * FROM session WHERE month = '$month' AND year = '$year'");
								$numRowCheck = mysqli_fetch_array($sqlCheck);
								
								if($numRowCheck > 0)
								{
									echo "<div class='alert alert-danger alert-dismissible'>
											<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
											<strong>Sorry!</strong> Session $month_name $year already exist.
										</div>";
								}
								else
								{
									$add = mysqli_query($conn, "INSERT INTO session (month, year) VALUES ('$month', '$year')");
								
																
									if($add == true)
									{
										
										echo "<div class='alert alert-success alert-dismissible'>
													<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
													<strong>Thank you!</strong> New session $month_name $year successfully added.
												</div>";
									
										
										$month = "";
										$year = "";
									}
									else
										echo "<div class='alert alert-danger alert-dismissible'>
												<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
												<strong>Sorry!</strong> Error.
											</div>";
								}
								
								
							}


				?>
			
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Session</h4>
				  

                  <form method="post" enctype="multipart/form-data">
					<p class="card-description text-primary">
                      <i class="hgi-stroke hgi-folder-02"></i> Add Session details.
					</p>
					<hr />


                  <form method="post" enctype="multipart/form-data">
                    
					
                    <div class="row">
                      <div class="col-md-3">
							<div class="form-group">
								<label>Month</label>
								<select class="form-control" name="month" style="height: calc(2.75rem + 2px);" required>
									<option value="">- choose month -</option>
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</div>
                      </div>
                      
                    
                      <div class="col-md-3">
						<div class="form-group">
							<label>Year</label>
							<input type="number" min="2023" class="form-control" name="year" placeholder="Year" required />
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