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
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<body>
  <div class="container-scroller">
  
    <!-- partial:partials/_navbar.html -->
	<?php include "layout/top.php";?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
	  
	  
	  <?php  include "layout/menu.php"; ?>
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
		
		<?php
		
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$today = date("Y-m-d");
		$month = date('m');
		$year = date('Y');
		
		$todayString = str_replace('-', '/', $today);
		$todayStringFormat = date('d/m/Y', strtotime($todayString));
		
		
		// dashboard admin and deputy dean
		if(($_SESSION['UserLvl'] == 1) || ($_SESSION['UserLvl'] == 2)) 
		{
			//calculate total coordinator
			$sqlCoordinator = mysqli_query($conn, "SELECT * FROM coordinator");
			$numRowCoordinator = mysqli_num_rows($sqlCoordinator);
			
			//calculate total session
			$sqlSession = mysqli_query($conn, "SELECT * FROM session");
			$numRowSession = mysqli_num_rows($sqlSession);
			
			//calculate total program
			$sqlProgram = mysqli_query($conn, "SELECT * FROM program");
			$numRowProgram = mysqli_num_rows($sqlProgram);
			
			//calculate total course
			$sqlCourse = mysqli_query($conn, "SELECT * FROM course");
			$numRowCourse = mysqli_num_rows($sqlCourse);
			
			
			
			
			echo "<h4><i class='menu-icon hgi-stroke hgi-dashboard-square-01'></i> Welcome to FCOM Smart Workload Projection</h4><br />";
			
			echo "<div class='row'>
					
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-info'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon hgi-stroke hgi-user-group icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Coordinator</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowCoordinator</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Coordinator
						  </small>
						</div>
					  </div>
					</div>
					
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-success'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon menu-icon hgi-stroke hgi-folder-02 icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Session</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowSession</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Session
						  </small>
						</div>
					  </div>
					</div>
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-primary'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon hgi-stroke hgi-stroke hgi-folder-favourite icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Program</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowProgram</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Available Program
						  </small>
						</div>
					  </div>
					</div>
					
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-warning'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon hgi-stroke hgi-file-01 icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Course</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowCourse</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Registered Course
						  </small>
						</div>
					  </div>
					</div>
			
					
					
				</div>";
				
				// Define an array with the possible background color classes
				$bgClasses = ['bg-info', 'bg-success', 'bg-primary', 'bg-warning'];
				$bgCount = count($bgClasses); // Get the total number of background classes
				$index = 0; // Initialize an index to cycle through the background classes

				// Get list of Program
				$sqlProgram = mysqli_query($conn, "SELECT * FROM program");
				while ($rowProgram = mysqli_fetch_array($sqlProgram)) {
					// Select the background class based on the current index
					$bgClass = $bgClasses[$index];

					echo "<div class='row'>
							<div class='col-xl-12 col-lg-12 col-md-12 col-sm-6 grid-margin stretch-card'>
							  <div class='card card-statistics $bgClass pull-up shadow'>
								<div class='card-body text-white'>
								  <div class='clearfix'>
									<div class='float-left'>
									  <i class='hgi-stroke hgi-cardiogram-01 icon-lg'></i>
									</div>
									<div class='float-right'>
									  <p class='mb-0 text-right'>Lecturer's Workload</p>
									  <div class='fluid-container'>
										<h3 class='font-weight-medium text-right mb-0'>{$rowProgram['program_code']} - {$rowProgram['program']}</h3>
									  </div>
									</div>
								  </div>
								  <p class='mt-3 mb-0 text-right'>
									<a href='program_session.php?program_code={$rowProgram['program_code']}&bgcolor=$bgClass' class='btn btn-outline-dark text-white'>
										View Program Session
									</a>
								  </p>
								</div>
							  </div>
							</div>
						  </div>";

					// Update the index to the next background class
					$index = ($index + 1) % $bgCount; // Reset to 0 after reaching the last class
				}
		}
		

		// dashboard coordinator
		else if($_SESSION['UserLvl'] == 3)
		{
			  // Fetch the coordinator's program_code from the coordinator table using the UserID
			$query = "SELECT * FROM coordinator WHERE coordinator_id = '$_SESSION[UserID]'";
			$result = mysqli_query($conn, $query);
			$coordinator = mysqli_fetch_array($result);
			$coordinatorProgramCode = $coordinator['program_code']; // This is the program code associated with the coordinator


			//calculate total coordinator
			$sqlCoordinator = mysqli_query($conn, "SELECT * FROM coordinator");
			$numRowCoordinator = mysqli_num_rows($sqlCoordinator);
			
			//calculate total session
			$sqlSession = mysqli_query($conn, "SELECT * FROM session");
			$numRowSession = mysqli_num_rows($sqlSession);
			
			//calculate total program
			$sqlProgram = mysqli_query($conn, "SELECT * FROM program");
			$numRowProgram = mysqli_num_rows($sqlProgram);
			
			//calculate total course
			$sqlCourse = mysqli_query($conn, "SELECT * FROM course");
			$numRowCourse = mysqli_num_rows($sqlCourse);
			
			
			
			
			echo "<h4><i class='menu-icon hgi-stroke hgi-dashboard-square-01'></i> Welcome to FCOM Smart Workload Projection</h4><br />";
			
			echo "<div class='row'>
					
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-info'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon hgi-stroke hgi-user-group icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Coordinator</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowCoordinator</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Coordinator
						  </small>
						</div>
					  </div>
					</div>
					
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-success'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon menu-icon hgi-stroke hgi-folder-02 icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Session</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowSession</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Session
						  </small>
						</div>
					  </div>
					</div>
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-primary'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon hgi-stroke hgi-stroke hgi-folder-favourite icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Program</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowProgram</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Available Program
						  </small>
						</div>
					  </div>
					</div>
					
					
					<div class='col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card'>
					  <div class='card card-statistics bg-warning'>
						<div class='card-body text-white'>
						  <div class='clearfix'>
							<div class='float-left'>
							  <i class='icon hgi-stroke hgi-file-01 icon-lg'></i>
							</div>
							<div class='float-right'>
							  <p class='mb-0 text-right'>Course</p>
							  <div class='fluid-container'>
								<h3 class='font-weight-medium text-right mb-0'>$numRowCourse</h3>
							  </div>
							</div>
						  </div>
						  <small class='mt-3 mb-0'>
							<i class='mdi mdi-information mr-1' aria-hidden='true'></i> Number of Registered Course
						  </small>
						</div>
					  </div>
					</div>
			
					
					
				</div>";
				
				// Define an array with the possible background color classes
				$bgClasses = ['bg-primary'];
				$bgCount = count($bgClasses); // Get the total number of background classes
				$index = 0; // Initialize an index to cycle through the background classes

				// Get list of Program
				$sqlProgram = mysqli_query($conn, "SELECT * FROM program WHERE program_code = '$coordinatorProgramCode'");
				while ($rowProgram = mysqli_fetch_array($sqlProgram)) {
					// Select the background class based on the current index
					$bgClass = $bgClasses[$index];

					echo "<div class='row'>
							<div class='col-xl-12 col-lg-12 col-md-12 col-sm-6 grid-margin stretch-card'>
							  <div class='card card-statistics $bgClass pull-up shadow'>
								<div class='card-body text-white'>
								  <div class='clearfix'>
									<div class='float-left'>
									  <i class='hgi-stroke hgi-cardiogram-01 icon-lg'></i>
									</div>
									<div class='float-right'>
									  <p class='mb-0 text-right'>Lecturer's Workload</p>
									  <div class='fluid-container'>
										<h3 class='font-weight-medium text-right mb-0'>{$rowProgram['program_code']} - {$rowProgram['program']}</h3>
									  </div>
									</div>
								  </div>
								  <p class='mt-3 mb-0 text-right'>
									<a href='program_session.php?program_code={$rowProgram['program_code']}&bgcolor=$bgClass' class='btn btn-outline-dark text-white'>
										View Program Session
									</a>
								  </p>
								</div>
							  </div>
							</div>
						  </div>";

					// Update the index to the next background class
					$index = ($index + 1) % $bgCount; // Reset to 0 after reaching the last class
				}
		}
		

		


		
		
		?>
          
          
         
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
		<?php include "layout/footer.php";?>
		
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  
   <!-- SCRIPT -->
   
  
    <script>
        // Pass the PHP arrays to JavaScript
        const lecturerNames = <?php echo json_encode($lecturer_names); ?>;
        const totalContactHours = <?php echo json_encode($total_contact_hours); ?>;

        // Log data to verify
        console.log("Lecturer Names: ", lecturerNames);
        console.log("Total Contact Hours: ", totalContactHours);

        // Create the bar chart
        const ctx = document.getElementById('contactHoursChart').getContext('2d');
        const contactHoursChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: lecturerNames,  // Lecturer names on the X-axis
                datasets: [{
                    label: 'Total Contact Hours', // Label for the chart
                    data: totalContactHours,    // Total contact hours for each lecturer
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1             // Border width
                }]
            },
            options: {
                responsive: true,  // Make the chart responsive
                scales: {
                    y: {
                        beginAtZero: true,  // Start the Y-axis from 0
                        min: 0
                    }
                }
            }
        });
    </script>
	
	<script>
		// Pass the PHP arrays to JavaScript
		const programNames = <?php echo json_encode($program_names); ?>;
		const totalContactHoursByProgram = <?php echo json_encode($total_contact_hours_by_program); ?>;

		// Log data to verify
		console.log("Program Names: ", programNames);
		console.log("Total Contact Hours by Program: ", totalContactHoursByProgram);

		// Create the pie chart
		const ctx2 = document.getElementById('contactHoursByProgramChart').getContext('2d');
		const contactHoursByProgramChart = new Chart(ctx2, {
			type: 'pie',
			data: {
				labels: programNames,  // Program names on the chart
				datasets: [{
					label: 'Contact Hours by Program',
					data: totalContactHoursByProgram,  // Total contact hours for each program
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)',
					],  // Different colors for each segment
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)',
					],  // Border color for each segment
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,  // Make the chart responsive
				plugins: {
					legend: {
						position: 'top',  // Position the legend at the top
					},
					tooltip: {
						callbacks: {
							label: function(tooltipItem) {
								// Add custom tooltips showing the percentage
								let percentage = Math.round((tooltipItem.raw / totalContactHoursByProgram.reduce((a, b) => a + b, 0)) * 100);
								return tooltipItem.label + ': ' + tooltipItem.raw + ' hours (' + percentage + '%)';
							}
						}
					}
				}
			}
		});
	</script>
	
	<script>
		// Pass the PHP arrays to JavaScript
		const lecturerNamesTrend = <?php echo json_encode($lecturer_names_trend); ?>;
		const workloadByMonth = <?php echo json_encode($workload_by_month); ?>;

		// Log data to verify
		console.log("Lecturer Names: ", lecturerNamesTrend);
		console.log("Workload by Month: ", workloadByMonth);

		// Create the Line Chart for Workload Trends
		const ctx3 = document.getElementById('workloadTrendChart').getContext('2d');
		const workloadTrendChart = new Chart(ctx3, {
			type: 'line',
			data: {
				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Month labels
				datasets: lecturerNamesTrend.map((lecturer_name, index) => ({
					label: lecturer_name, // Lecturer name as label
					data: workloadByMonth[lecturer_name], // Total contact hours for each month
					borderColor: `rgba(${(index * 50) % 255}, ${(index * 100) % 255}, ${(index * 150) % 255}, 1)`, // Dynamic color
					backgroundColor: `rgba(${(index * 50) % 255}, ${(index * 100) % 255}, ${(index * 150) % 255}, 0.2)`, // Transparent background color
					fill: false,
					tension: 0.1 // Line smoothing
				}))
			},
			options: {
				responsive: true,
				scales: {
					x: {
						title: {
							display: true,
							text: 'Months'
						}
					},
					y: {
						title: {
							display: true,
							text: 'Total Workload'
						},
						beginAtZero: true
					}
				},
				plugins: {
					legend: {
						position: 'top' // Position the legend at the top
					}
				}
			}
		});
	</script>
	

   
   <?php include "layout/script.php";?>
   
   


</body>

</html>
<?php
}
?>