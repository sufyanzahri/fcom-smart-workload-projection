<?php
include "conn/conn.php";
error_reporting(0);
session_start();

if (empty($_SESSION['UserID']) AND empty($_SESSION['Password'])) {
    header('location:index.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include "layout/head.php"; ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php include "layout/top.php"; ?>
	
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      <?php include "layout/menu.php"; ?>
	   
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
			
			<?php
				$coordinator_id = "";
				$name = "";
				$photo = ""; // Initialize photo variable

				if (isset($_POST['submit'])) {
					$coordinator_id = $_POST['coordinator_id'];
					$name = $_POST['name'];
					$program_code  = $_POST['program_code'];
					$email = $_POST['email'];
					$phone_no = $_POST['phone_no'];
					$gender_id = $_POST['gender_id'];
					
					// Handle file upload for photo
					if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
						// Define allowed file types
						$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
						$fileType = $_FILES['photo']['type'];
						$fileTmpName = $_FILES['photo']['tmp_name'];

						// Check if the uploaded file is a valid image
						if (in_array($fileType, $allowedTypes)) {
							// Define the upload directory
							$uploadDir = 'photo/'; // Specify directory where photos will be stored
							
							// Ensure the upload directory exists
							if (!is_dir($uploadDir)) {
								mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
							}

							// Generate a unique file name to avoid conflicts (only save the image name, not the full path)
							$imageName = uniqid() . '-' . basename($_FILES['photo']['name']);

							// Define the full path to where the file will be uploaded
							$uploadFilePath = $uploadDir . $imageName;

							// Move the uploaded file to the server's designated directory
							if (move_uploaded_file($fileTmpName, $uploadFilePath)) {
								// Successfully uploaded the photo; store only the image name in the database
								$photo = $imageName;  // Store only the image name, without the directory path
							} else {
								$photo = ''; // In case the file upload fails
							}
						}
					}

					// Update coordinator details in the database
					$updateCoordinator = mysqli_query($conn, "UPDATE coordinator SET 
																	name = '$name', 
																	program_code = '$program_code', 
																	email = '$email', 
																	phone_no = '$phone_no', 
																	gender_id = '$gender_id',
																	photo = '$photo' 
																	WHERE coordinator_id = '$coordinator_id'");

					if ($updateCoordinator) {
					  echo "<div class='alert alert-success alert-dismissible'>
							  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							  <strong>Thank you!</strong> Coordinator $name's details successfully updated.
							</div>";
					} else {
					  echo "<div class='alert alert-danger alert-dismissible'>
							  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							  <strong>Error!</strong> Failed to update Coordinator $name's details.
							</div>";
					}
				}

				// Get coordinator id details
				$coordinator_id = $_GET['coordinator_id'];
				$sql = mysqli_query($conn, "SELECT * FROM coordinator WHERE coordinator_id = '$coordinator_id'");
				$row = mysqli_fetch_array($sql);
			?>

               <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Program Coordinator</h4>

                  <form method="post" enctype="multipart/form-data">
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-user-star-01"></i> Program Coordinator Details
                    </p>
					
					<hr />
                    <div class="row">
                      <div class="col-md-3">
						<div class="form-group">
							<label>Coordinator ID</label>
							<input type="text" class="form-control" name="coordinator_id" value="<?php echo $row['coordinator_id']; ?>" placeholder="Program Coordinator ID" readonly required />
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label>Coordinator Name</label>
							<input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" placeholder="Program Coordinator Name" required />
						</div>
                      </div>
					  
                      <div class="col-md-3">
						<div class="form-group">
						  <label>Program</label>
						  <select class="form-control" id="program_code" name="program_code" required>
							<option value="">- choose program -</option>
							<?php
							  $sqlProgram = mysqli_query($conn, "SELECT * FROM program");
							  while($rowProgram = mysqli_fetch_array($sqlProgram)) {
								if($rowProgram['program_code'] == $row['program_code'])
								  echo "<option value='$rowProgram[program_code]' selected>$rowProgram[program]</option>";
								else
								  echo "<option value='$rowProgram[program_code]'>$rowProgram[program]</option>";
							  }
							?>
						  </select>
						</div>
					  </div>
                    </div>
					
                    <div class="row">
					  
					  <div class="col-md-3">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" placeholder="Email Address" required />
						</div>
                      </div>
					  
					  <div class="col-md-3">
						<div class="form-group">
							<label>Phone No.</label>
							<input type="number" class="form-control" name="phone_no" value="<?php echo $row['phone_no']; ?>" placeholder="Phone No." required />
						</div>
                      </div>
                      
					  <div class="col-md-3">
						<div class="form-group">
							<label>Gender</label>
							<select class="form-control" name="gender_id" required />
							<option value="">- choose gender -</option>
							<?php
								$sqlGender = mysqli_query($conn, "SELECT * FROM gender");
								while($rowGender = mysqli_fetch_array($sqlGender)) {
									if($rowGender['gender_id'] == $row['gender_id'])
										echo "<option value='$rowGender[gender_id]' selected>$rowGender[gender]</option>";
									else
										echo "<option value='$rowGender[gender_id]'>$rowGender[gender]</option>";
								}
							?>
							</select>
						</div>
                      </div>
					  
                      <div class="col-md-3">
                        <div class="form-group">
                            <label>Photo <span class="text-warning">(optional)</span></label>
                          <input type="file" class="form-control" name="photo" />
                        </div>
                      </div>
                    </div>

					
					<br />
                    <a href="manage_program_coordinator.php" class="btn btn-outline-dark">
						<i class="mdi mdi-keyboard-backspace"></i> Back
					</a>
					<button type="submit" name="submit" class="btn btn-primary  mr-2"><i class="mdi mdi-check"></i> Update</button>
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
