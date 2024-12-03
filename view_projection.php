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
	   
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Projection List</h4>
					
				  <?php
                    // Handle Delete Projection
                    $act = $_GET['act'];
                    if ($act == 'del') {
                        $projection_id = $_GET['projection_id'];
                        $delete = mysqli_query($conn, "DELETE FROM projection WHERE projection_id = '$projection_id'");

                        if ($delete == true) {
                            echo "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Thank you!</strong> Projection $projection_id successfully removed.
                                  </div>";
                        }
                    }
                  ?>
                  
                  <br />
                  <div class="table-responsive">
					<table id="datatable" class="table dataTable no-footer" role="grid">
						<thead>
							<tr>
								<th>No</th>
								<th>Program Code</th>
								<th>Program</th>
								<th>Session</th>
								<th>Semester</th>
								<th>Batch</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$bil = 1;

							// SQL query to fetch program code, session details, semester, and batch
							$sql = mysqli_query($conn, "
								SELECT DISTINCT w.program_code, w.session_id, w.batch, w.semester_id, p.program, s.month, s.year, sm.semester
								FROM projection w
								JOIN program p ON w.program_code = p.program_code
								JOIN session s ON w.session_id = s.session_id
								JOIN semester sm ON w.semester_id = sm.semester_id
								ORDER BY s.year ASC
							");

							// Check for errors in the query
							if (!$sql) {
								die('Query Failed: ' . mysqli_error($conn));
							}

							// Fetch and display the results
							while ($row = mysqli_fetch_array($sql)) {
								// Format session as 'Month-Year'
								$session = date('M-Y', strtotime($row['year'].'-'.$row['month'].'-01'));
								
								echo "<tr>
										<th scope='row'>$bil</th>
										<td>$row[program_code]</td>
										<td>$row[program]</td>
										<td>$session</td>
										<td>$row[semester]</td>
										<td>$row[batch]</td>
										<td>
											<a href='view_semester_batch_projection.php?program_code=$row[program_code]&session_id=$row[session_id]&semester_id=$row[semester_id]&batch=$row[batch]'
											   data-toggle='tooltip' data-placement='left' title='View'>
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
