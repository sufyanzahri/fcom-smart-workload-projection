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
			
					$lecturer_id = "";
					$name = "";
					if (isset($_POST['submit']))
					{

						$lecturer_id = $_POST['lecturer_id'];
						$name = $_POST['name'];
						$specialization_code  = $_POST['specialization_code'];
						$email = $_POST['email'];
						$phone_no = $_POST['phone_no'];
						$gender_id = $_POST['gender_id'];

						

							// Now, add the lecturer details 
							$addLecturer = mysqli_query($conn, "INSERT INTO lecturer (lecturer_id, name, email, phone_no, gender_id, photo, specialization_code) 
																						VALUES ('$lecturer_id', '$name', '$email', '$phone_no', '$gender_id', 'avatar.jpg', '$specialization_code')");

							if ($addLecturer == true) {
								echo "<div class='alert alert-success alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Thank you!</strong> Lecturer $name account successfully registered.
									</div>";

								// Clear form fields
								$lecturer_id = "";
								$name = "";
								$specialization_code = "";
								$email = "";
								$phone_no = "";
								$gender_id = "";
								
								
							} else {
								echo "<div class='alert alert-danger alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Sorry!</strong> Failed to add Lecturer $name.
									</div>";
							}
						
					}

					
					// Fungsi untuk menjana ID
					function generateLecturerID() {
							$randomNum = mt_rand(10000, 99999); 
							return 'L' . $randomNum;
					}

					// Jana ID
					$lecturer_id = generateLecturerID();


			?>
			
               <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Register Lecturer</h4>

                  <form method="post" enctype="multipart/form-data">
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-user-group"></i> Specialization Details
                    </p>
					
					<hr />
                    <div class="row">
                      <div class="col-md-3">
						<div class="form-group">
							<label>Lecturer ID</label>
							<input type="text" class="form-control" name="lecturer_id" value="<?php echo $lecturer_id; ?>" placeholder="Lecturer ID" readonly required />
						</div>
                      </div>
					  <div class="col-md-9">
						<div class="form-group">
							<label>Lecturer Name</label>
							<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Lecturer Name" required />
						</div>
                      </div>
                    </div>
					
                    
                    
					
					<div class="row">
                      
					<div class="col-md-3">
						<div class="form-group">
						  <label>Specialization</label>
						  <select class="form-control" id="specialization_code" name="specialization_code" required>
							<option value="">- choose specialization -</option>
							<?php
							  $sqlSpecialization = mysqli_query($conn, "SELECT * FROM specialization");
							  while($rowSpecialization = mysqli_fetch_array($sqlSpecialization)) {
								if($rowSpecialization['specialization_code'] == $specialization_code)
								  echo "<option value='$rowSpecialization[specialization_code]' selected>$rowSpecialization[specialization]</option>";
								else
								  echo "<option value='$rowSpecialization[specialization_code]'>$rowSpecialization[specialization]</option>";
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