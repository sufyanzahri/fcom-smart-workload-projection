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
                  <h4 class="card-title">Manage Lecturer</h4>
				  
				  <?php
			
					$code=$_GET['code'];
					$act=$_GET['act'];

					if ($act=='del')
					{
						$lecturer_id =  $_GET['lecturer_id'];
						$name =  $_GET['name'];
						
						$deleteAcc = mysqli_query($conn, "DELETE FROM lecturer WHERE lecturer_id = '$lecturer_id'");
						
						
						if($deleteAcc == true)
						{
							echo "<div class='alert alert-danger alert-dismissible'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Thank you!</strong> Lecturer $name account successfully deleted.
									</div>";
						}
							
					}

					
				?>

				  <div class="table-responsive">
                    <table id="datatable" class="table dataTable no-footer" role="grid">
                      <thead>
                        <tr>
                          <th>Photo</th>
                          <th>Lecturer</th>
                          <th>Specialization</th>
						  <th>Phone No.</th>
						  <th>Gender</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
						// Fetch data
						$sql = mysqli_query($conn, "SELECT * FROM lecturer");

						while($row = mysqli_fetch_array($sql))
						{
							//get specialization name 
							$sqlSpecialization = mysqli_query($conn, "SELECT * FROM specialization WHERE specialization_code = '$row[specialization_code]'");
							$rowSpecialization = mysqli_fetch_array($sqlSpecialization);
							
							//highlight Gender
							if($row['gender_id'] == "M")
								$gender = "<span class='badge badge-pill badge-primary'>$row[gender_id]</span>";
							else if($row['gender_id'] == "F")
								$gender = "<span class='badge badge-pill badge-danger'>$row[gender_id]</span>";
							
							echo "<tr>
									<td><img src='photo/$row[photo]' data-toggle='tooltip' data-placement='right' title data-original-title='$row[lecturer_id]'/></td>
									<td>$row[name]</td>
									<td>$rowSpecialization[specialization_code] - $rowSpecialization[specialization]</td>
									<td>$row[phone_no]</td>
									<td>$gender</td>
									<td>
										<a href='update_lecturer.php?lecturer_id=$row[lecturer_id]'
										data-toggle='tooltip' data-placement='left' title='Update'>
											<i class='hgi-stroke hgi-pencil-edit-02 text-warning' style='font-size: 20px;'></i>
										</a>
										<a href='manage_lecturer.php?act=del&lecturer_id=$row[lecturer_id]&name=$row[name]'
										data-toggle='tooltip' data-placement='left' title='Remove'
										onclick=\"return confirm('Are you sure you want to remove Lecturer $row[name] account?');\">
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
    function togglePasswordVisibility(lecturer_id) {
        var password = document.getElementById("password-" + lecturer_id);
        var passwordVisible = document.getElementById("password-visible-" + lecturer_id);
        var icon = document.getElementById("icon-" + lecturer_id);
    
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
