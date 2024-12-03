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
			
					$coordinator_id = "";
					$name = "";
					if (isset($_POST['submit']))
					{

						$coordinator_id = $_POST['coordinator_id'];
						$name = $_POST['name'];
						$program_code  = $_POST['program_code'];
						$email = $_POST['email'];
						$phone_no = $_POST['phone_no'];
						$gender_id = $_POST['gender_id'];

						// First, add the login details for the coordinator
						$addLogin = mysqli_query($conn, "INSERT INTO login (UserID, Password, UserLvl) VALUES ('$coordinator_id', '$coordinator_id', '3')");

						if ($addLogin == true) {

							// Now, add the coordinator details 
							$addCoordinator = mysqli_query($conn, "INSERT INTO coordinator (coordinator_id, name, email, phone_no, gender_id, photo, program_code) 
																						VALUES ('$coordinator_id', '$name', '$email', '$phone_no', '$gender_id', 'avatar.jpg', '$program_code')");

							if ($addCoordinator == true)
							{
								echo "<div class='alert alert-success alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Thank you!</strong> Coordinator $name account successfully registered.
									</div>";

								// Clear form fields
								$coordinator_id = "";
								$name = "";
								$program_code = "";
								$email = "";
								$phone_no = "";
								$gender_id = "";
								
								
							} else {
								echo "<div class='alert alert-danger alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Sorry!</strong> Failed to register Coordinator $name.
									</div>";
							}
						} else {
							echo "<div class='alert alert-danger alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Sorry!</strong> Coordinator ID $coordinator_id is already registered.
								</div>";
						}
					}

					
					// Fungsi untuk menjana ID
					function generateCoordinatorID() {
							$randomNum = mt_rand(10000, 99999); 
							return 'C' . $randomNum;
					}

					// Jana ID
					$coordinator_id = generateCoordinatorID();


			?>
			
               <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Register Program Coordinator</h4>

                  <form method="post" enctype="multipart/form-data">
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-user-star-01"></i> Program Coordinator Details
                    </p>
					
					<hr />
                    <div class="row">
                      <div class="col-md-3">
						<div class="form-group">
							<label>Coordinator ID</label>
							<input type="text" class="form-control" name="coordinator_id" value="<?php echo $coordinator_id; ?>" placeholder="Program Coordinator ID" readonly required />
						</div>
                      </div>
					  <div class="col-md-9">
						<div class="form-group">
							<label>Coordinator Name</label>
							<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Program Coordinator Name" required />
						</div>
                      </div>
                    </div>
					
                    
                    
					
					<div class="row">
                      
					<div class="col-md-3">
						<div class="form-group">
						  <label>Program</label>
						  <select class="form-control" id="program_code" name="program_code" required>
							<option value="">- choose program -</option>
							<?php
							  $sqlProgram = mysqli_query($conn, "SELECT * FROM program");
							  while($rowProgram = mysqli_fetch_array($sqlProgram)) {
								if($rowProgram['program_code'] == $program_code)
								  echo "<option value='$rowProgram[program_code]' selected>$rowProgram[program]</option>";
								else
								  echo "<option value='$rowProgram[program_code]'>$rowProgram[program]</option>";
							  }
							?>
						  </select>
						</div>
					</div>
					  
					  <div class="col-md-3">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email Address" required />
						</div>
                      </div>
					  
					  <div class="col-md-3">
						<div class="form-group">
							<label>Phone No.</label>
							<input type="number" class="form-control" name="phone_no" value="<?php echo $phone_no; ?>" placeholder="Phone No." required />
						</div>
                      </div>
                      
					  <div class="col-md-3">
						<div class="form-group">
							<label>Gender</label>
							<select class="form-control" name="gender_id" required />
							<option value="">- choose gender -</option>
							<?php
								$sqlGender = mysqli_query($conn, "SELECT * FROM gender");
								while($rowGender = mysqli_fetch_array($sqlGender))
								{
									if($rowGender['gender_id'] == $gender_id)
										echo "<option value='$rowGender[gender_id]' selected>$rowGender[gender]</option>";
									else
										echo "<option value='$rowGender[gender_id]'>$rowGender[gender]</option>";
								}
							?>
							</select>
						</div>
                      </div>
                    </div>
					
					<p class="card-description text-primary mt-3">
                      <i class="hgi-stroke hgi-lock-password"></i> Login Details
                    </p>
					<hr />
					
					<div class="row">
                      <div class="col-md-12">
						<div class="form-group">
							<label>User ID & Password</label><br />
							<div class="text-warning"><small>Password same as Coordinator ID (Auto matched)</small></div>
						</div>
                      </div>
                    </div>
					
                    
                    <button type="reset" class="btn btn-outline-dark mt-3"><i class="mdi mdi-refresh"></i> Reset</button>
					<button type="submit" name="submit" class="btn btn-primary  mt-3 mr-2"><i class="mdi mdi-check"></i> Register</button>
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