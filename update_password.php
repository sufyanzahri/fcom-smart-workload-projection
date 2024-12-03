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
       <?php 
	  
		include "layout/menu.php";
	  
	  ?>
	   
	  
	   
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            
            
            
            <div class="col-12 grid-margin">
			<?php
					
					if (isset($_POST['submit']))
					{
						$password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
						
						if($password == $cpassword)
						{
							$sql = mysqli_query($conn, "UPDATE login SET Password = '$password' WHERE UserID = '$_SESSION[UserID]'");
							
							echo "<div class='alert alert-success alert-dismissible'>
														<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
														<strong>Thank you!</strong> Your password successfully updated.
													  </div>";
						}
						else
							echo "<div class='alert alert-danger alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Sorry!</strong> Password does not matched.
									</div>";
					}
					

			?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Password</h4>
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-square-lock-02"></i> Update your password once in a while
                    </p>

                  <form method="post" enctype="multipart/form-data">
					<hr />
					
                    <div class="row">
                      <div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" placeholder="*******" required />
						</div>
                      </div>
                    </div>
                    
                   <div class="row">
                      <div class="col-md-6">
						<div class="form-group">
							<label>Password Confirmation</label>
							<input type="password" class="form-control" name="cpassword" placeholder="*******" required />
						</div>
                      </div>
                    </div>
                   
                    
                    
                    <br />
                    <button type="reset" class="btn btn-outline-dark"><i class="mdi mdi-refresh"></i> Reset</button>
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