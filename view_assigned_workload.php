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

					
					// Update the data when the form is submitted
					if (isset($_POST['submit'])) {
						$projection_id = $_POST['projection_id'];
						$lecturer_id = $_POST['lecturer_id'];
						$assigned_hours = $_POST['assigned_hours'];

						// Ensure valid data before updating the database
						if ($lecturer_id && $assigned_hours) {
							// Update the projection table
							$updateQuery = "UPDATE projection SET lecturer_id = '$lecturer_id', assigned_hours = '$assigned_hours' WHERE projection_id = '$projection_id'";

							if (mysqli_query($conn, $updateQuery)) {
								echo "<div class='alert alert-success'>Workload updated successfully.</div>";
							} else {
								echo "<div class='alert alert-danger'>Error updating workload: " . mysqli_error($conn) . "</div>";
							}
						} else {
							echo "<div class='alert alert-warning'>Please select a lecturer and assign hours.</div>";
						}
					}
					
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
					} else {
						echo "<div class='alert alert-danger'>Projection ID is missing.</div>";
						exit;
					}
              ?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Assign Workload</h4>
                  
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-projector-01"></i> Projection Details
                    </p>
                    <hr />

                    <!-- Projection ID Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Projection ID</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $projection['projection_id']; ?></label>
                        </div>
                      </div>
                    </div>

                    <!-- Program Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Program</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            <?php
                            $sqlProgram = mysqli_query($conn, "SELECT * FROM program WHERE program_code = '$projection[program_code]'");
                            $rowProgram = mysqli_fetch_assoc($sqlProgram);
                            $program_code = $rowProgram['program_code'];
                            $program = $rowProgram['program'];
                            echo $program;
                            ?>
                          </label>
                        </div>
                      </div>
                    </div>

                    <!-- Course Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Course</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            <?php
                            $sqlCourse = mysqli_query($conn, "SELECT * FROM course WHERE course_code = '$projection[course_code]'");
                            $rowCourse = mysqli_fetch_assoc($sqlCourse);
                            $course_code = $rowCourse['course_code'];
                            $course = $rowCourse['course'];
                            echo $course_code . ' - ' . $course;
                            ?>
                          </label>
                        </div>
                      </div>
                    </div>

                    <!-- Session Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Session</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            <?php
                            $sqlSession = mysqli_query($conn, "SELECT * FROM session WHERE session_id = '$projection[session_id]'");
                            $rowSession = mysqli_fetch_assoc($sqlSession);
                            $formattedDate = date('M-Y', strtotime($rowSession['year'].'-'.$rowSession['month'].'-01'));
                            
                            $session_id = $rowSession['session_id'];
							
							echo $formattedDate;
                            ?>
                          </label>
                        </div>
                      </div>
                    </div>

                    <!-- Batch Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Batch</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
							<?php 
								$batch = $projection['batch'];
								echo $batch; 
							?>
						  </label>
                        </div>
                      </div>
                    </div>

                    <!-- Semester Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Semester</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            <?php
                            $sqlSemester = mysqli_query($conn, "SELECT * FROM semester WHERE semester_id = '$projection[semester_id]'");
                            $rowSemester = mysqli_fetch_assoc($sqlSemester);
                            $semester_id = $rowSemester['semester_id'];
                            $semester = $rowSemester['semester'];
							
                            echo $rowSemester['semester'];
                            ?>
                          </label>
                        </div>
                      </div>
                    </div>

                    <!-- Section Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Section</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $projection['sections']; ?></label>
                        </div>
                      </div>
                    </div>

                    <!-- Grouping Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Grouping</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $projection['groupings']; ?></label>
                        </div>
                      </div>
                    </div>

                    <!-- Total by Group Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Total by Group</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $projection['total_by_group']; ?></label>
                        </div>
                      </div>
                    </div>

                    <!-- Total Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Total</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $projection['total']; ?></label>
                        </div>
                      </div>
                    </div>

                    <!-- Remarks Display -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Remarks</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $projection['remarks']; ?></label>
                        </div>
                      </div>
                    </div>

                  <br />
                  <form method="post">
				  <input type="hidden" class="form-control" name="projection_id" value="<?php echo $projection_id; ?>" required />
                        
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-work-history"></i> Lecturer and Assigned Hours
                    </p>
					
					<hr />
					<div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                            <label>Lecturer</label>
                        </div>
                      </div>
					  
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
						  <?php
                              // Fetch the list of lecturers and their specializations
                              $sqlLect = mysqli_query($conn, "
                                SELECT l.lecturer_id, l.name, s.specialization
                                FROM lecturer l
                                JOIN specialization s ON l.specialization_code = s.specialization_code
								WHERE lecturer_id = '$projection[lecturer_id]'
                              ");

                              $rowLect = mysqli_fetch_assoc($sqlLect);
							  
							  if($rowLect['name'] != NULL)
								echo "{$rowLect['name']} - {$rowLect['specialization']}";
							  else
								echo "- - -";
                              
						  ?>
						  </label>
                        </div>
                      </div>
                    </div>

                    <!-- Assigned Hours Input -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Assigned Hours</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
							<?php
								if($projection['assigned_hours'] != NULL)
									echo $projection['assigned_hours'] . " Hours";
								  else
									echo "- - -";
							?>
						  </label>
                        </div>
                      </div>
                    </div>
                    

                    <br />
                    <a href="view_semester_batch_projection.php?program_code=<?php echo urlencode($program_code); ?>&session_id=<?php echo urlencode($session_id); ?>&semester_id=<?php echo urlencode($semester_id); ?>&batch=<?php echo urlencode($batch); ?>" class="btn btn-outline-dark">
					  <i class="mdi mdi-keyboard-backspace"></i> Back
					</a>
					
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
