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
<style>
a, a:hover {
    color: #fff;
}
i {
    font-size: 20px;
}
</style>

<body>
  <div class="container-scroller">
    <?php include "layout/top.php";?>
    <div class="container-fluid page-body-wrapper">
      <?php include "layout/menu.php";?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List of Courses</h4>

                  <?php
                  $act = $_GET['act'];
                  $course_code = $_GET['course_code'];

                  if ($act == 'del') {
                      $delete = mysqli_query($conn, "DELETE FROM course WHERE course_code = '$course_code'");
                      if ($delete) {
                          echo "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Thank you!</strong> Course $course_code successfully removed.
                                </div>";
                      }
                  } elseif ($act == 'assigned') {
                      echo "<div class='alert alert-success alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Thank you!</strong> Prerequisite for Course $course_code successfully assigned.
                            </div>";
                  } elseif ($act == 'reset') {
                      $reset = mysqli_query($conn, "UPDATE course SET prerequisite = NULL WHERE course_code = '$course_code'");
                      echo "<div class='alert alert-success alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Thank you!</strong> Prerequisite for Course $course_code successfully reset.
                            </div>";
                  }
                  ?>

                  <br />
                  <div class="table-responsive">
                    <table id="datatable2" class="table table-sm dataTable no-footer" role="grid">
						  <thead>
							<tr>
							  <th>No</th>
							  <th>Course</th>
							  <th>Credit Hour</th>
							  <th>Contact Hour</th>
							  <th>Pre-requisite?</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
						  $bil = 1;

						  // Query to fetch course data without program and semester
						  $sql = mysqli_query($conn, "
							  SELECT course.*
							  FROM course
							  ORDER BY course.course_code ASC");

						  while ($row = mysqli_fetch_array($sql)) {
							// Pre-requisite handling
							$preq = '';
							if ($row['prerequisite'] == NULL) {
								$displayBtn = "<a href='#' data-toggle='modal' data-target='#prereq$row[course_code]'>
												<i class='hgi-stroke hgi-add-square text-success'></i>
											  </a>";
							} else {
								$sqlPreq = mysqli_query($conn, "SELECT course_code, course FROM course WHERE course_code = '$row[prerequisite]'");
								$rowPreq = mysqli_fetch_array($sqlPreq);
								$preq = "<br />
										 Pre-requisite:<br />{$rowPreq['course_code']} - {$rowPreq['course']}";
								$displayBtn = "<a href='manage_course.php?act=reset&course_code=$row[course_code]'
												data-toggle='tooltip' title='Reset Pre-requisite'>
												<i class='hgi-stroke hgi-reload text-warning'></i>
											  </a>";
							}

							echo "<tr>
									<th scope='row'>$bil</th>
									<td>
										{$row['course_code']} - {$row['course']}
										$preq
									</td>
									<td>{$row['credit_hour']}</td>
									<td>{$row['contact_hour']}</td>
									<td>$displayBtn</td>
									<td>
										<a href='update_course.php?course_code={$row['course_code']}'
										   data-toggle='tooltip' title='Update'>
										   <i class='hgi-stroke hgi-pencil-edit-02 text-warning'></i>
										</a>
										
										<a href='manage_course.php?act=del&course_code={$row['course_code']}'
										   data-toggle='tooltip' title='Remove'
										   onclick=\"return confirm('Are you sure you want to remove course {$row['course']}?');\">
										   <i class='hgi-stroke hgi-delete-03 text-danger'></i>
										</a>
									</td>
								  </tr>";

							$bil++;
							include('modal_assign_prerequisite.php');
						  }
						  ?>
						  </tbody>
						</table>

                  </div>
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
