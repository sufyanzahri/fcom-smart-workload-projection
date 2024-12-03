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
    <?php include "layout/top.php";?>
    <div class="container-fluid page-body-wrapper">
      <?php include "layout/menu.php";?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Course</h4>
                  <form method="post" enctype="multipart/form-data">
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-file-01"></i> Add Course details.
                    </p>
                    <hr />
                    <?php
                    if (isset($_POST['submit'])) {
                        $course_code = $_POST['course_code'];
                        $course = $_POST['course'];
                        $credit_hour = $_POST['credit_hour'];
                        $contact_hour = $_POST['contact_hour'];
                        
                        $sqlCheck = mysqli_query($conn, "SELECT * FROM course WHERE course_code = '$course_code'");
                        $numRowCheck = mysqli_num_rows($sqlCheck);
                        
                        if($numRowCheck > 0)
						{
                            echo "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Sorry!</strong> Course Code $course_code already exists.
                                  </div>";
                        } else {
                            $add = mysqli_query($conn, "INSERT INTO course (course_code, course, credit_hour, contact_hour)
																		VALUES ('$course_code', '$course', '$credit_hour', '$contact_hour')");
                            if ($add)
							{
                                echo "<div class='alert alert-success alert-dismissible'>
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                        <strong>Thank you!</strong> New course successfully added.
                                      </div>";
                                $program_code = $course_code = $course = $credit_hour = $contact_hour = $semester_id = "";
                            }
							else
							{
                                echo "<div class='alert alert-danger alert-dismissible'>
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                        <strong>Sorry!</strong> Error in adding course.
                                      </div>";
                            }
                        }
                    }
                    ?>


                    <!-- Existing Fields for Course Details -->
                    <div class="row">
                    </div>
                    
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-group">
                          <label>Course Name</label>
                          <input type="text" class="form-control" name="course" placeholder="Course" required />
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Course Code</label>
                          <input type="text" class="form-control" name="course_code" placeholder="Course Code" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Credit Hour</label>
                          <input type="number" min="1" class="form-control" name="credit_hour" placeholder="Credit Hour" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Contact Hour</label>
                          <input type="number" min="0" class="form-control" name="contact_hour" placeholder="Contact Hour" required />
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
        <?php include "layout/footer.php";?>
      </div>
    </div>
  </div>
  <?php include "layout/script.php";?>
</body>
</html>
<?php
}
?>
