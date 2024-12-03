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
							$admin_id = $_POST['admin_id'];
							$name = $_POST['name'];
							$background = $_POST['background'];
							$email = $_POST['email'];
							$phone_no = $_POST['phone_no'];
							$gender_id = $_POST['gender_id'];
							
							//upload image
							$file_location 	= $_FILES['photo']['tmp_name'];
							$file_type		= $_FILES['photo']['type'];
							$file_name		= $_FILES['photo']['name'];
							
							
							
							if (empty($file_location))
							{
								$sql = mysqli_query($conn, "UPDATE admin SET name = '$name',
																					background = '$background',
																					email = '$email',
																					phone_no = '$phone_no',
																					gender_id = '$gender_id'
																					WHERE admin_id = '$admin_id'");
							}
							else
							{
								// Generate unique name for the image
								$unique_name = uniqid() . '_' . $file_name;

								// Crop and resize image
								$target_dir = "photo/";
								$target_file = $target_dir . $unique_name;
								
								// Set the desired dimensions for the cropped and resized image
								$new_width = 500;
								$new_height = 500;

								// Create appropriate image resource based on image type
								if ($file_type == "image/jpeg" || $file_type == "image/jpg") 
								{
									$source = imagecreatefromjpeg($file_location);
								} 
								else if ($file_type == "image/png") 
								{
									$source = imagecreatefrompng($file_location);
								} 
								else if ($file_type == "image/gif") 
								{
									$source = imagecreatefromgif($file_location);
								} 
								else 
								{
									echo "Unsupported image format!";
									exit;
								}

								// Get original dimensions
								list($width, $height) = getimagesize($file_location);

								// Calculate crop dimensions for square crop (focus on center)
								$min_dimension = min($width, $height);
								$crop_x = ($width - $min_dimension) / 2;
								$crop_y = ($height - $min_dimension) / 2;

								// Create a new true color image for cropped and resized image
								$cropped_resized_image = imagecreatetruecolor($new_width, $new_height);

								// Crop and resize the image
								imagecopyresampled(
									$cropped_resized_image, $source,
									0, 0, $crop_x, $crop_y,
									$new_width, $new_height,
									$min_dimension, $min_dimension
								);

								// Save the cropped and resized image
								if ($file_type == "image/jpeg" || $file_type == "image/jpg") 
								{
									imagejpeg($cropped_resized_image, $target_file);
								} 
								else if ($file_type == "image/png") 
								{
									imagepng($cropped_resized_image, $target_file);
								} 
								else if ($file_type == "image/gif") 
								{
									imagegif($cropped_resized_image, $target_file);
								}

								// Clean up memory
								imagedestroy($source);
								imagedestroy($cropped_resized_image);
								
								$sql = mysqli_query($conn, "UPDATE admin SET name = '$name',
																					background = '$background',
																					email = '$email',
																					phone_no = '$phone_no',
																					gender_id = '$gender_id',
																					photo = '$unique_name'
																					WHERE admin_id = '$admin_id'");
								
							}								
																
								
							
															
							if($sql == true)
							{
							
								echo "<div class='alert alert-success alert-dismissible'>
											<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
											<strong>Thank you!</strong> Your profile successfully updated.
									</div>";
							}
							else
							{
								echo "<div class='alert alert-danger alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Sorry!</strong> error.
									</div>";
							}
						
						
						
						
						
							
					}
					
					$sql = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = '$_SESSION[UserID]'");
					$row = mysqli_fetch_array($sql);
					
					
					

			?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Profile</h4>

                  <form method="post" enctype="multipart/form-data">
					<p class="card-description text-primary">
                      <i class="hgi-stroke hgi-user-edit-01"></i> Update your profile if necessary
                    </p>
					<hr />
					
                    <div class="row">
                      <div class="col-md-3">
						<div class="form-group">
							<label>Admin ID</label>
							<input type="text" class="form-control" name="admin_id" value="<?php echo $row['admin_id']; ?>" placeholder="User ID" readonly />
						
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" placeholder="Name" required />
						</div>
                      </div>
					  <div class="col-md-3">
						<div class="form-group">
							<label>Background</label>
							<input type="text" class="form-control" name="background" value="<?php echo $row['background']; ?>" placeholder="Admin Background" required />
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
							<label>Phone No</label>
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
								while($rowGender = mysqli_fetch_array($sqlGender))
								{
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
							<input type="file" class="form-control" name="photo" placeholder="Photo" />
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