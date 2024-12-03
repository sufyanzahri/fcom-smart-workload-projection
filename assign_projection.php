<?php
include "conn/conn.php";
session_start();
if (empty($_SESSION['UserID']) && empty($_SESSION['Password'])) {
    header('location:index.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<!-- head -->
<?php include "layout/head.php"; ?>

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
                  $projection_id = $_POST['projection_id'];
                  $program_code = $_POST['program_code'];
                  $session_id = $_POST['session_id'];
                  $batch = $_POST['batch'];
                  $course_code = $_POST['course_code'];
                  $semester_id = $_POST['semester_id'];
                  $sections = $_POST['sections'];
                  $groupings = $_POST['groupings'];
                  $total_by_group = $_POST['total_by_group'];
                  $total = $_POST['total'];
                  $remarks = $_POST['remarks'];
                  

                  $add = mysqli_query($conn, "INSERT INTO projection (projection_id, program_code, session_id, batch, course_code, semester_id, sections, groupings, total_by_group, total, remarks)
										VALUES ('$projection_id', '$program_code', '$session_id', '$batch', '$course_code', '$semester_id', '$sections', '$groupings', '$total_by_group', '$total', '$remarks')");

                  if ($add) {
                      echo "<div class='alert alert-success'>Projection successfully assigned.</div>";
                  } else {
                      echo "<div class='alert alert-danger'>Error in assigning projection.</div>";
                  }
              }

              $projection_id = 'P' . time() . rand(1000, 9999);
              $sqlCheck = mysqli_query($conn, "SELECT * FROM projection WHERE projection_id = '$projection_id'");
              while (mysqli_num_rows($sqlCheck) > 0) {
                  $projection_id = 'P' . time() . rand(1000, 9999);
                  $sqlCheck = mysqli_query($conn, "SELECT * FROM projection WHERE projection_id = '$projection_id'");
              }
              ?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Assign Projection</h4>
                  <form method="post">
					<p class="card-description text-primary">
                      <i class="hgi-stroke hgi-projector-01"></i> Add Projection details.
                    </p>
                    <hr />

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Projection ID</label>
                          <input type="text" class="form-control" name="projection_id" value="<?php echo $projection_id; ?>" readonly />
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <label>Program</label>
                          <select class="form-control" name="program_code" id="program_code" required onchange="fetchCoursesAndLecturers()">
                            <option value="">- choose program -</option>
                            <?php
                            $sqlProgram = mysqli_query($conn, "SELECT * FROM program");
                            while ($rowProgram = mysqli_fetch_assoc($sqlProgram)) {
                                echo "<option value='{$rowProgram['program_code']}'>{$rowProgram['program_code']} - {$rowProgram['program']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Course</label>
                          <select class="form-control" name="course_code" id="course_code" required>
                            <option value="">- choose course -</option>
							<?php
                            $sqlCourse = mysqli_query($conn, "SELECT * FROM course");
                            while ($rowCourse = mysqli_fetch_assoc($sqlCourse)) {
                                echo "<option value='{$rowCourse['course_code']}'>{$rowCourse['course_code']} - {$rowCourse['course']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Session</label>
                          <select class="form-control" name="session_id" id="session_id" required onchange="fetchCoursesAndLecturers()">
                            <option value="">- choose session -</option>
                            <?php
                            $sqlSession = mysqli_query($conn, "SELECT * FROM session ORDER BY year ASC");
                            while ($rowSession = mysqli_fetch_assoc($sqlSession)) {
                                $formattedDate = date('M-Y', strtotime($rowSession['year'].'-'.$rowSession['month'].'-01'));
                                echo "<option value='{$rowSession['session_id']}'>$formattedDate</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      
					  
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Batch</label>
                          <input type="text" class="form-control" name="batch" value="BATCH " placeholder="Batch" required />
                        </div>
                      </div>
                      <div class="col-md-3">
						<div class="form-group">
							<label>Semester</label>
							<select class="form-control" name="semester_id" id="semester_id" required>
                            <option value="">- choose course -</option>
							<?php
                            $sqlSemester = mysqli_query($conn, "SELECT * FROM semester");
                            while ($rowSemester = mysqli_fetch_assoc($sqlSemester)) {
                                echo "<option value='{$rowSemester['semester_id']}'>{$rowSemester['semester']}</option>";
                            }
                            ?>
                          </select>
						</div>
                      </div>
                    </div>
					
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Section</label>
                          <input type="text" class="form-control" name="sections" value="SEC "placeholder="Section" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Grouping</label>
                          <input type="text" class="form-control" name="groupings" placeholder="Grouping" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Total by Group</label>
                          <input type="number" class="form-control" name="total_by_group" placeholder="Total by Group" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Total</label>
                          <input type="number" class="form-control" name="total" placeholder="Total" required />
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Remarks</label>
                          <textarea class="form-control" name="remarks" rows="5" placeholder="Write remarks here..."></textarea>
                        </div>
                      </div>
                    </div>

                    <br />
                    <button type="reset" class="btn btn-outline-dark"><i class="mdi mdi-refresh"></i> Reset</button>
                    
					<button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
