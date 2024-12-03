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
                // Function to check if the Deputy Dean already exists
                function checkDeputyDeanExists($conn) {
                    $query = "SELECT * FROM deputy_dean LIMIT 1"; // Fetch only one record
                    $result = mysqli_query($conn, $query);
                    return mysqli_num_rows($result) > 0;
                }

                if (isset($_POST['submit'])) {
                    $deputy_dean_id = $_POST['deputy_dean_id'];
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $phone_no = $_POST['phone_no'];
                    $gender_id = $_POST['gender_id'];

                    // Check if the Deputy Dean exists
                    if (checkDeputyDeanExists($conn)) {
                        // If the Deputy Dean exists, update their details
                        $updateDeputyDean = mysqli_query($conn, "UPDATE deputy_dean 
                                                                 SET name='$name',
                                                                     email='$email',
                                                                     phone_no='$phone_no',
                                                                     gender_id='$gender_id' 
                                                                 WHERE deputy_dean_id = '$deputy_dean_id'");

                        if ($updateDeputyDean) {
                            echo "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Deputy Dean $name's details have been updated.
                                  </div>";
                        } else {
                            echo "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Sorry!</strong> Failed to update Deputy Dean $name's details.
                                  </div>";
                        }
                    }
                    else {
                       

                        // Now add the login details for the Deputy Dean
                        $addLogin = mysqli_query($conn, "INSERT INTO login (UserID, Password, UserLvl) 
                                                         VALUES ('$deputy_dean_id', '$deputy_dean_id', '2')");

                        if ($addLogin == true) {
                            // If the Deputy Dean doesn't exist, insert a new record
                            $addDeputyDean = mysqli_query($conn, "INSERT INTO deputy_dean (deputy_dean_id, name, email, phone_no, gender_id, photo) 
                                                                   VALUES ('$deputy_dean_id', '$name', '$email', '$phone_no', '$gender_id', 'avatar.jpg')");

                            if ($addDeputyDean) {
                                echo "<div class='alert alert-success alert-dismissible'>
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                        <strong>Thank you!</strong> Deputy Dean $name account successfully created.
                                      </div>";
                            } else {
                                echo "<div class='alert alert-danger alert-dismissible'>
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                        <strong>Sorry!</strong> Failed to create Deputy Dean $name.
                                      </div>";
                            }
                        }
                    }
                }
				
                // Generate a new Deputy Dean ID
                function generateDeanID() {
                            $randomNum = mt_rand(10000, 99999); 
                            return 'DD' . $randomNum;
                }

                // Fetch the existing Deputy Dean details (if any)
                $query = "SELECT * FROM deputy_dean LIMIT 1";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $name = $row['name'];
                    $email = $row['email'];
                    $phone_no = $row['phone_no'];
                    $gender_id = $row['gender_id'];
                    $deputy_dean_id = $row['deputy_dean_id']; // Fetch the existing ID if exists
                } else {
                    // If no record is found, initialize empty values
                    $name = "";
                    $email = "";
                    $phone_no = "";
                    $gender_id = "";
                    $deputy_dean_id = generateDeanID(); // Generate a new ID if no Deputy Dean exists
                }
              ?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Manage Deputy Dean</h4>
                  <form method="post" enctype="multipart/form-data">
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-user-star-01"></i> Manage Deputy Dean Account
                    </p>
                    <hr />
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Deputy Dean ID</label>
                          <input type="text" class="form-control" name="deputy_dean_id" value="<?php echo $deputy_dean_id; ?>" readonly required />
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label>Deputy Dean Name</label>
                          <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Deputy Dean Name" required />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email Address" required />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Phone No.</label>
                          <input type="number" class="form-control" name="phone_no" value="<?php echo $phone_no; ?>" placeholder="Phone No." required />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Gender</label>
                          <select class="form-control" name="gender_id" required />
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
                    </div>

                    <p class="card-description text-primary mt-3">
                      <i class="hgi-stroke hgi-lock-password"></i> Login Details
                    </p>
                    <hr />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>User ID & Password</label><br />
                          <div class="text-warning"><small>Password same as Deputy Dean ID (Auto matched)</small></div>
                        </div>
                      </div>
                    </div>

                    <button type="reset" class="btn btn-outline-dark mt-3"><i class="mdi mdi-refresh"></i> Reset</button>
                    <button type="submit" name="submit" class="btn btn-primary mt-3 mr-2"><i class="mdi mdi-check"></i> Submit</button>
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
