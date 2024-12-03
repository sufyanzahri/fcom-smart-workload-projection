<?php
include "conn/conn.php";
error_reporting(0);
session_start();

if (empty($_SESSION['UserID']) AND empty($_SESSION['Password'])) {
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
	
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <?php include "layout/menu.php";?>
	  
	  <?php
		  // Get the URL parameters for program_code, semester_id, and batch
		  $program_code = $_GET['program_code'];
		  $session_id = $_GET['session_id'];
		  $semester_id = $_GET['semester_id'];
		  $batch = $_GET['batch'];  // Assuming batch is passed as a parameter

		  // Query to get program name based on the program_code
		  $program_query = mysqli_query($conn, "SELECT program FROM program WHERE program_code = '$program_code'");
		  $program_row = mysqli_fetch_assoc($program_query);
		  $program = $program_row['program'];  // Fetch the program name

		  // Query to get session name based on session_id
		  $session_query = mysqli_query($conn, "SELECT month, year FROM session WHERE session_id = '$session_id'");
		  $session_row = mysqli_fetch_assoc($session_query);
		  $session = date('M-Y', strtotime($session_row['year'].'-'.$session_row['month'].'-01')); 

		  // Query to get semester name based on semester_id
		  $semester_query = mysqli_query($conn, "SELECT semester FROM semester WHERE semester_id = '$semester_id'");
		  $semester_row = mysqli_fetch_assoc($semester_query);
		  $semester = $semester_row['semester'];  // Fetch the semester name

	  ?>

	   
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
				
				  <?php
						echo "<h4 class='card-title'>Projection for Program {$program} Semester {$semester_id}, Session {$session}, {$batch}</h4>";
				  ?>
                  	
				  <?php
                    // Handle Delete Projection
                    $act = $_GET['act'];
                    if ($act == 'del') {
                        $projection_id = $_GET['projection_id'];
                        $delete = mysqli_query($conn, "DELETE FROM projection WHERE projection_id = '$projection_id'");

                        if ($delete == true) {
                            echo "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Thank you!</strong> Projection successfully removed.
                                  </div>";
                        }
                    }
                  ?>
                  
                  <br />
                  <div class="table-responsive">
					<table id="datatable" class="table table-sm dataTable no-footer" role="grid">
						<thead>
							<tr>
								<th>No</th>
								<th>Course Code</th>
								<th>Course Name</th>
								<th>Credit Hour</th>
								<th>Contact Hour</th>
								<th>Section</th>
								<th>Grouping</th>
								<th>Group</th>
								<th>Total</th>
								<th>Status</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php

							// SQL query to fetch the details of courses for the specific program, session, batch
							$sql = mysqli_query($conn, "
								SELECT w.projection_id, w.course_code, w.lecturer_id, w.assigned_hours,
									   c.course, c.prerequisite, c.credit_hour, c.contact_hour,
									   w.sections, w.groupings, w.total_by_group, w.total
								FROM projection w
								JOIN course c ON w.course_code = c.course_code
								WHERE w.program_code = '$program_code' 
								AND w.session_id = '$session_id'
								ORDER BY w.sections, w.groupings
							");

							// Check for query error
							if (!$sql) {
								die('Query Failed: ' . mysqli_error($conn));
							}

							$bil = 1;

							// Loop through the query results and display the data
							while ($row = mysqli_fetch_array($sql)) {
								
								// Only show the prerequisite if it exists
								if ($row['prerequisite'] != NULL && $row['prerequisite'] != '') {
									$prerequisite =  "<br/>Pre-requisite:<br />$row[prerequisite]";
								}
								
								//display assign status 
								if($row['assigned_hours'] == NULL)
								{
									$status = "<span class='badge badge-warning'>- - -</span>";
								}
								else
								{
									$status = "<span class='badge badge-success'>Assigned</span>";
								}
						
								echo "<tr>
										<th scope='row'>$bil</th>
										<td>$row[course_code]</td>
										<td>
											$row[course]
											$prerequisite
										</td>
										<td>$row[credit_hour]</td>
										<td>$row[contact_hour]</td>
										<td>$row[sections]</td>
										<td>$row[groupings]</td>
										<td>$row[total_by_group]</td>
										<td>$row[total]</td>
										<td>$status</td>
										<td>
											<a href='view_assigned_workload.php?projection_id=$row[projection_id]'
												data-toggle='tooltip' title='View'>
												<i class='hgi-stroke hgi-view text-success'></i>
											</a>
										</td>
									  </tr>";
								$bil++;
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
