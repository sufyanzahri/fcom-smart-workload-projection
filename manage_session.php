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
i
{
	font-size: 20px;
}
</style>

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
            
            
           <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
				   <h4 class="card-title">List of All Session</h4>
				  
				  <?php
			
					$code=$_GET['code'];
					$act=$_GET['act'];

					if ($act == 'del')
					{
						$session_id = $_GET['session_id'];
						
						// Fetch the month and year of the session before deleting
						$result = mysqli_query($conn, "SELECT month, year FROM session WHERE session_id = '$session_id'");
						$session = mysqli_fetch_assoc($result);
						
						if ($session)
						{
							// Convert numeric month to month name
							$dateObj = DateTime::createFromFormat('!m', $session['month']);
							$month_name = $dateObj->format('F');
							$year = $session['year'];
							
							// Proceed to delete the session
							$delete = mysqli_query($conn, "DELETE FROM session WHERE session_id = '$session_id'");
							
							if ($delete == true)
							{
								echo "<div class='alert alert-danger alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Thank you!</strong> Session $month_name $year successfully removed.
									  </div>";
							}
						}
						else
						{
							echo "<div class='alert alert-danger alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error!</strong> Session not found.
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
						  <th>Month</th>
						  <th>Year</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  
						$bil = 1;
						$sql = mysqli_query($conn, "SELECT * FROM session ORDER BY year ASC");
						while($row = mysqli_fetch_array($sql))
						{
							// Convert numeric month to month name
							$dateObj = DateTime::createFromFormat('!m', $row['month']);
							$month_name = $dateObj->format('F');
							
							echo "<tr>
									<th scope='row'>$bil</th>
									<td>$month_name</td>
									<td>$row[year]</td>
									<td>
										<a href='update_session.php?session_id=$row[session_id]'
											data-toggle='tooltip' data-placement='left' title='Update'>
											<i class='hgi-stroke hgi-pencil-edit-02 text-warning'></i>
										</a>
															
										<a href='manage_session.php?act=del&session_id=$row[session_id]'
											data-toggle='tooltip' data-placement='left' title='Remove'
											onclick=\"return confirm('Are you sure want to remove session $month_name $row[year]?');\">
											<i class='hgi-stroke hgi-delete-03 text-danger'></i>
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