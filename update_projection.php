<?php
include "conn/conn.php";
session_start();

if (empty($_SESSION['UserID']) && empty($_SESSION['Password'])) {
    header('location:index.php');
}
else
{

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
				 // Check if a projection_id is provided in the URL
					if (isset($_GET['projection_id'])) {
						$projection_id = $_GET['projection_id'];

						// Fetch the existing projection data
						$query = mysqli_query($conn, "SELECT * FROM projection WHERE projection_id = '$projection_id'");
						$projection = mysqli_fetch_assoc($query);

						// If projection doesn't exist, redirect to another page or show an error
						if (!$projection) {
							echo "<div class='alert alert-danger'>Projection not found.</div>";
							exit;
						}

						// If form is submitted, update the projection details
						if (isset($_POST['submit'])) {
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

							// Update the projection in the database
							$updateQuery = "UPDATE projection SET
												program_code = '$program_code',
												session_id = '$session_id',
												batch = '$batch',
												course_code = '$course_code',
												semester_id = '$semester_id',
												sections = '$sections',
												groupings = '$groupings',
												total_by_group = '$total_by_group',
												total = '$total',
												remarks = '$remarks'
											WHERE projection_id = '$projection_id'";

							if (mysqli_query($conn, $updateQuery)) {
								echo "<div class='alert alert-success'>Projection updated successfully.</div>";
							} else {
								echo "<div class='alert alert-danger'>Error in updating projection.</div>";
							}
						}
					} else {
						echo "<div class='alert alert-danger'>Projection ID is missing.</div>";
						exit;
					}
              ?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Projection</h4>
                  <form method="post">
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-projector-01"></i> Update Projection details.
                    </p>
                    <hr />

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Projection ID</label>
                          <input type="text" class="form-control" name="projection_id" value="<?php echo $projection['projection_id']; ?>" readonly />
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <label>Program</label>
                          <select class="form-control" name="program_code" id="program_code" required>
                            <option value="">- choose program -</option>
                            <?php
                            $sqlProgram = mysqli_query($conn, "SELECT * FROM program");
                            while ($rowProgram = mysqli_fetch_assoc($sqlProgram)) {
                                $selected = ($projection['program_code'] == $rowProgram['program_code']) ? 'selected' : '';
                                echo "<option value='{$rowProgram['program_code']}' $selected>{$rowProgram['program_code']} - {$rowProgram['program']}</option>";
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
                                $selected = ($projection['course_code'] == $rowCourse['course_code']) ? 'selected' : '';
                                echo "<option value='{$rowCourse['course_code']}' $selected>{$rowCourse['course_code']} - {$rowCourse['course']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Session</label>
                          <select class="form-control" name="session_id" id="session_id" required>
                            <option value="">- choose session -</option>
                            <?php
                            $sqlSession = mysqli_query($conn, "SELECT * FROM session ORDER BY year ASC");
                            while ($rowSession = mysqli_fetch_assoc($sqlSession)) {
                                $formattedDate = date('M-Y', strtotime($rowSession['year'].'-'.$rowSession['month'].'-01'));
                                $selected = ($projection['session_id'] == $rowSession['session_id']) ? 'selected' : '';
                                echo "<option value='{$rowSession['session_id']}' $selected>$formattedDate</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Batch</label>
                          <input type="text" class="form-control" name="batch" value="<?php echo $projection['batch']; ?>" placeholder="Batch" required />
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
                                $selected = ($projection['semester_id'] == $rowSemester['semester_id']) ? 'selected' : '';
                                echo "<option value='{$rowSemester['semester_id']}' $selected>{$rowSemester['semester']}</option>";
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
                          <input type="text" class="form-control" name="sections" value="<?php echo $projection['sections']; ?>" placeholder="Section" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Grouping</label>
                          <input type="text" class="form-control" name="groupings" value="<?php echo $projection['groupings']; ?>" placeholder="Grouping" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Total by Group</label>
                          <input type="number" class="form-control" name="total_by_group" value="<?php echo $projection['total_by_group']; ?>" placeholder="Total by Group" required />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Total</label>
                          <input type="number" class="form-control" name="total" value="<?php echo $projection['total']; ?>" placeholder="Total" required />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Remarks</label>
                          <textarea class="form-control" name="remarks" rows="5" placeholder="Write remarks here..."><?php echo $projection['remarks']; ?></textarea>
                        </div>
                      </div>
                    </div>

                    <br />
                    <a href="manage_semester_batch_projection.php?program_code=<?php echo urlencode($projection['program_code']); ?>&session_id=<?php echo urlencode($projection['session_id']); ?>&semester_id=<?php echo urlencode($projection['semester_id']); ?>&batch=<?php echo urlencode($projection['batch']); ?>" class="btn btn-outline-dark">
					  <i class="mdi mdi-keyboard-backspace"></i> Back
					</a>

                    <button type="submit" name="submit" class="btn btn-primary mr-2"><i class="mdi mdi-check"></i> Update</button>
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
