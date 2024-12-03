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
		  
            
            <!-- Card for Staff with Position ID 2 -->
            <div class="col-lg-12 grid-margin stretch-card">
							  
              <div class="card">
		  
                <div class="card-body">			
                  <h4 class="card-title">Manage Program Coordinator</h4>
				  
				  <?php
			
					$code=$_GET['code'];
					$act=$_GET['act'];

					if ($act=='del')
					{
						$coordinator_id =  $_GET['coordinator_id'];
						
						$deleteLogin = mysqli_query($conn, "DELETE FROM login WHERE UserID = '$coordinator_id'");
						$deleteAcc = mysqli_query($conn, "DELETE FROM coordinator WHERE coordinator_id = '$coordinator_id'");
						
						
						if(($deleteLogin == true) && ($deleteAcc == true))
						{
							echo "<div class='alert alert-danger alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Thank you!</strong> Coordinator $coordinator_id account successfully deleted.
									</div>";
						}
							
					}

					
				?>

				  <div class="table-responsive">
                    <table id="datatable" class="table dataTable no-footer" role="grid">
                      <thead>
                        <tr>
                          <th>Photo</th>
                          <th>Coordinator</th>
                          <th>Program</th>
						  <th>Phone No.</th>
						  <th>Gender</th>
						  <th>Status</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
						// Fetch data
						$sql = mysqli_query($conn, "SELECT * FROM login l, coordinator c
																	WHERE l.UserID = c.coordinator_id
																	AND l.UserLvl = 3");

						while($row = mysqli_fetch_array($sql))
						{
							//get program name 
							$sqlProgram = mysqli_query($conn, "SELECT * FROM program WHERE program_code = '$row[program_code]'");
							$rowProgram = mysqli_fetch_array($sqlProgram);
							
							//action status
							if($row['Status'] == "Active")
							{
								$displayStatus = "<a href='manage_CoordinatorID.php?act=deactivate&coordinator_id=$row[coordinator_id]&name=$row[name]'
													data-toggle='tooltip' data-placement='right' title='Nyahaktif'
													onclick=\"return confirm('Are you sure you want to deactivated Coordinator $row[name] account?');\">
														<button class='btn btn-success btn-xs'>
															$row[Status]
														</button>
													</a>";
							}
							else if($row['Status'] == "Inactive")
							{
								$displayStatus = "<a href='manage_CoordinatorID.php?act=activate&coordinator_id=$row[coordinator_id]&name=$row[name]'
													data-toggle='tooltip' data-placement='right' title='Active'>
														<button class='btn btn-danger btn-xs'>
															$row[Status]
														</button>
													</a>";
							}
							
							//highlight Gender
							if($row['gender_id'] == "M")
								$gender = "<span class='badge badge-pill badge-primary'>$row[gender_id]</span>";
							else if($row['gender_id'] == "F")
								$gender = "<span class='badge badge-pill badge-danger'>$row[gender_id]</span>";
							
							echo "<tr>
									<td><img src='photo/$row[photo]' data-toggle='tooltip' data-placement='right' title data-original-title='$row[coordinator_id]'/></td>
									<td>
									    $row[name]<br /><br />
									    <small class='text-warning'>ID: $row[coordinator_id]<br />
									             Pass: <span id='password-$row[coordinator_id]' style='display: inline;'>".str_repeat('*', strlen($row['Password']))."</span>
                                				<span id='password-visible-$row[coordinator_id]' style='display: none;'>$row[Password]</span>
                                				<a href='javascript:void(0);' onclick=\"togglePasswordVisibility('$row[coordinator_id]');\">
                                					<i id='icon-$row[coordinator_id]' class='mdi mdi-eye text-muted'></i>
                                				</a>
									    </small>
									</td>
									<td>$rowProgram[program]</td>
									<td>$row[phone_no]</td>
									<td>$gender</td>
									<td>$displayStatus</td>
									<td>
										<a href='update_program_coordinator.php?coordinator_id=$row[coordinator_id]'
										data-toggle='tooltip' data-placement='left' title='Update'>
											<i class='hgi-stroke hgi-pencil-edit-02 text-warning' style='font-size: 20px;'></i>
										</a>
										<a href='manage_program_coordinator.php?act=del&coordinator_id=$row[coordinator_id]&name=$row[name]'
										data-toggle='tooltip' data-placement='left' title='Remove'
										onclick=\"return confirm('Are you sure you want to remove Coordinator $row[name] account?');\">
											<i class='hgi-stroke hgi-delete-03 text-danger' style='font-size: 20px;'></i>
										</a>
									</td>
									</tr>";
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
   <script>
    function togglePasswordVisibility(coordinator_id) {
        var password = document.getElementById("password-" + coordinator_id);
        var passwordVisible = document.getElementById("password-visible-" + coordinator_id);
        var icon = document.getElementById("icon-" + coordinator_id);
    
        if (password.style.display === "none") {
            password.style.display = "inline";
            passwordVisible.style.display = "none";
            icon.classList.remove("mdi-eye-off");
            icon.classList.add("mdi-eye");
        } else {
            password.style.display = "none";
            passwordVisible.style.display = "inline";
            icon.classList.remove("mdi-eye");
            icon.classList.add("mdi-eye-off");
        }
    }
    </script>
</body>

</html>
<?php
}
?>
