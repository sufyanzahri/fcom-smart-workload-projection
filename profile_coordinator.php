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
<head>
    <?php include "layout/head.php"; ?>
</head>
<body>
  <div class="container-scroller">
    <?php include "layout/top.php"; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include "layout/menu.php"; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <?php
                if (isset($_POST['submit'])) {
                    $coordinator_id = $_POST['coordinator_id'];
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $phone_no = $_POST['phone_no'];
                    $gender_id = $_POST['gender_id'];

                    // Handle image upload
                    $file_location = $_FILES['photo']['tmp_name'];
                    $file_type = $_FILES['photo']['type'];
                    $file_name = $_FILES['photo']['name'];

                    if (!empty($file_location)) {
                        $unique_name = uniqid() . '_' . $file_name;
                        $target_dir = "photo/";
                        $target_file = $target_dir . $unique_name;
                        $new_width = 500;
                        $new_height = 500;

                        if ($file_type == "image/jpeg" || $file_type == "image/jpg") {
                            $source = imagecreatefromjpeg($file_location);
                        } else if ($file_type == "image/png") {
                            $source = imagecreatefrompng($file_location);
                        } else if ($file_type == "image/gif") {
                            $source = imagecreatefromgif($file_location);
                        } else {
                            echo "Unsupported image format!";
                            exit;
                        }

                        list($width, $height) = getimagesize($file_location);
                        $min_dimension = min($width, $height);
                        $crop_x = ($width - $min_dimension) / 2;
                        $crop_y = ($height - $min_dimension) / 2;
                        $cropped_resized_image = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled(
                            $cropped_resized_image, $source,
                            0, 0, $crop_x, $crop_y,
                            $new_width, $new_height,
                            $min_dimension, $min_dimension
                        );

                        if ($file_type == "image/jpeg" || $file_type == "image/jpg") {
                            imagejpeg($cropped_resized_image, $target_file);
                        } else if ($file_type == "image/png") {
                            imagepng($cropped_resized_image, $target_file);
                        } else if ($file_type == "image/gif") {
                            imagegif($cropped_resized_image, $target_file);
                        }

                        imagedestroy($source);
                        imagedestroy($cropped_resized_image);

                        $updateDeputyDean = mysqli_query($conn, "UPDATE coordinator 
                                                                 SET name='$name',
                                                                     email='$email',
                                                                     phone_no='$phone_no',
                                                                     gender_id='$gender_id',
                                                                     photo='$unique_name' 
                                                                 WHERE coordinator_id = '$coordinator_id'");
                    } else {
                        $updateDeputyDean = mysqli_query($conn, "UPDATE coordinator 
                                                                 SET name='$name',
                                                                     email='$email',
                                                                     phone_no='$phone_no',
                                                                     gender_id='$gender_id' 
                                                                 WHERE coordinator_id = '$coordinator_id'");
                    }

                    if ($updateDeputyDean) {
                        echo "<div class='alert alert-success alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Success!</strong> Coordinator $name's details have been updated.
                              </div>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Sorry!</strong> Failed to update Coordinator $name's details.
                              </div>";
                    }
                }

                $query = "SELECT * FROM coordinator WHERE coordinator_id = '$_SESSION[UserID]' LIMIT 1";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $name = $row['name'];
                    $email = $row['email'];
                    $phone_no = $row['phone_no'];
                    $gender_id = $row['gender_id'];
                    $coordinator_id = $row['coordinator_id'];
                }
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
                          <label>Coordinator ID</label>
                          <input type="text" class="form-control" name="coordinator_id" value="<?php echo $coordinator_id; ?>" readonly required />
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <label>Coordinator Name</label>
                          <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Coordinator Name" required />
                        </div>
                      </div>
                    </div>

                    <div class="row">
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
                          <select class="form-control" name="gender_id" required>
                            <option value="">- choose gender -</option>
                            <?php
                              $sqlGender = mysqli_query($conn, "SELECT * FROM gender");
                              while($rowGender = mysqli_fetch_array($sqlGender)) {
                                $selected = ($rowGender['gender_id'] == $gender_id) ? 'selected' : '';
                                echo "<option value='{$rowGender['gender_id']}' $selected>{$rowGender['gender']}</option>";
                              }
                            ?>
                          </select>
                        </div>
                      </div>
					  
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Photo <span class="text-warning">(optional)</span></label>
                          <input type="file" class="form-control" name="photo" placeholder="Upload Photo" />
                        </div>
                      </div>
                    </div>

                    <button type="reset" class="btn btn-outline-dark mt-3"><i class="mdi mdi-refresh"></i> Reset</button>
                    <button type="submit" name="submit" class="btn btn-primary mt-3 mr-2"><i class="mdi mdi-check"></i> Update</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include "layout/footer.php"; ?>
      </div>
    </div>
  </div>
  <?php include "layout/script.php"; ?>
</body>
</html>

<?php
}
?>
