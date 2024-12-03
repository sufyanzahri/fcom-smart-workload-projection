<?php
include "conn/conn.php";
error_reporting(0);
session_start();
if (!empty($_SESSION['UserID']) AND !empty($_SESSION['Password']))
{
  header('location:dashboard.php');
}
else
{
?>
<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include "layout/head.php";?>
<style>
/* === Input Fields Rounded Styles === */
.form-control {
  border-radius: 25px;
  padding: 12px 20px;
}

.input-group-text {
  border-radius: 0 25px 25px 0;
}

/* Default Icon Color */
.glow {
    color: #ffaf00; /* Default color */
    transition: color 0.3s ease; /* Smooth transition */
}

/* Change color on hover */
.glow:hover {
    color: #308ee0; /* New color on hover */
}


</style>
<body>
  <div class="container-scroller">
	
	
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
		
          <div class="col-lg-4 mx-auto">
		  
            <div class="auto-form-wrapper">
			<h1 class="display-1 text-center font-weight-bold">
				<img src="images/logo.png" class="img-fluid" alt="logo" />
			</h1>

			<hr />
			<?php
			
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$today = date("Y-m-d");
			if (isset($_POST['login']))
			{
				$UserID = $_POST['UserID'];
				$password = $_POST['password'];

				$login = mysqli_query($conn, "SELECT * FROM login WHERE UserID = '$UserID' AND Password = '$password' AND Status = 'Active'");
				$success = mysqli_num_rows($login);
				$row = mysqli_fetch_array($login);

				if ($success > 0){
					
					session_start();		
					
					$_SESSION['UserID'] = $row['UserID'];
					$_SESSION['Password'] = $row['Password'];				
					$_SESSION['UserLvl'] = $row['UserLvl'];	
					
					echo "<script>window.location = 'dashboard.php';</script>";
				}
				else
				{
																	
					echo "<div class='alert alert-danger alert-dismissible'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<strong>Sorry!</strong> Authentication failed.
							</div>";
				}
					
			}

		?>
              <form method="post">
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="UserID" placeholder="Username" required />
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-account text-warning"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="*********" required />
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-eye glow" id="password-toggle"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" name="login" class="btn btn-primary btn-block">Log me in</button>
                </div>
				<p class="text-center">
					 <small>&copy; 2024 <a href="#" class="text-primary">FCOM Smart Workload Projection</a></small><br />
					 <small>All rights reserved.</small>
				</p>
              </form>
            </div>
            <br />
			 
          </div>
        </div>
		

      </div>
      <!-- content-wrapper ends -->

    </div>
    <!-- page-body-wrapper ends -->
	
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <!-- SCRIPT -->
   <?php include "layout/script.php";?>
<script>
    // Toggle password visibility and glowing effect
    $(document).ready(function() {
        $('#password-toggle').on('click', function() {
            var passwordInput = $('#password');
            var icon = $(this);

            // Toggle password visibility
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
            }
        });
    });
</script>


</body>

</html>
<?php
}
?>