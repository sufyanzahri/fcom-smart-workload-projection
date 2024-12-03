<?php
include "conn/conn.php";
session_start();
if (empty($_SESSION['UserID']) AND empty($_SESSION['Password'])) {
    header('location:index.php');
} else {
  	
	// Fetch the coordinator's program_code from the coordinator table using the coordinator_id
    $userID = $_SESSION['UserID'];
    $query = "SELECT program_code FROM coordinator WHERE coordinator_id = '$userID'";
    $result = mysqli_query($conn, $query);
    $coordinator = mysqli_fetch_array($result);
    $coordinatorProgramCode = $coordinator['program_code'];

?>


<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include "layout/head.php";?>

<body>
  <div class="container-scroller">
    <?php include "layout/top.php";?>
    <div class="container-fluid page-body-wrapper">
      <?php include "layout/menu.php";?>
      <div class="main-panel">
        <div class="content-wrapper">
		
		<!-- Modal HTML (hidden by default) -->
		<div class="modal fade" id="noDataModal" tabindex="-1" role="dialog" aria-labelledby="noDataModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="noDataModalLabel"><i class="hgi-stroke hgi-alert-01"></i> Sorry...</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						No data available for the selected program and session.
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>


          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Generate Report</h4>

                  <!-- Report Generation Form -->
                  <form method="post">
                    <p class="card-description text-primary">
                      <i class="hgi-stroke hgi-file-01"></i> Generate Report
                    </p>
                    <hr />

                    <!-- Program Selection -->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Program</label>
                          <select class="form-control" name="program_code" required>
                            <option value="">- Choose Program -</option>
                            <?php
                            // Fetch available programs from the database
                            $sqlProgram = mysqli_query($conn, "SELECT * FROM program");
                            while ($rowProgram = mysqli_fetch_assoc($sqlProgram)) {
                                echo "<option value='{$rowProgram['program_code']}'>{$rowProgram['program_code']} - {$rowProgram['program']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- Session Selection -->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Session</label>
                          <select class="form-control" name="session_id" required>
                            <option value="">- Choose Session -</option>
                            <?php
                            // Fetch available sessions from the database
                            $sqlSession = mysqli_query($conn, "SELECT * FROM session ORDER BY year ASC");
                            while ($rowSession = mysqli_fetch_assoc($sqlSession)) {
                                $formattedDate = date('M-Y', strtotime($rowSession['year'] . '-' . $rowSession['month'] . '-01'));
                                echo "<option value='{$rowSession['session_id']}'>$formattedDate</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <br />
                    
                    <!-- Generate Button -->
                    <button type="submit" name="generate_report" class="btn btn-primary"><i class="mdi mdi-file-pdf"></i> Generate Report</button>
                  </form>


                </div>
              </div>
            </div>
          </div>
        
			<!-- Display Bar Chart and Line Chart Side by Side -->
			<?php if (isset($lecturer_names) && isset($lecturer_names_trend)) { ?>
				<div class="row">
					<h4 class="card-title ml-3"><i class="hgi-stroke hgi-analytics-01"></i> Chart Report for Program <?php echo $program; ?>, Session <?php echo $session; ?></h4>
					<div class="col-lg-6 grid-margin"> <!-- Half width for the bar chart -->
						<div class="card shadow card-equal-height">
							<div class="card-body">
								<h4 class="card-title"><i class="hgi-stroke hgi-analytics-01"></i> Total Lecturer's Workload</h4>
								<canvas id="contactHoursChart" width="400" height="200"></canvas>
							</div>
						</div>
					</div>

					<div class="col-lg-6 grid-margin"> <!-- Half width for the line chart -->
						<div class="card shadow card-equal-height">
							<div class="card-body">
								<h4 class="card-title"><i class="hgi-stroke hgi-chart-line-data-03"></i> Lecturer's Monthly Workload Trend</h4>
								<canvas id="projectionTrendChart" width="400" height="200"></canvas>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
			<!-- Display Scatter and Pie Charts Side by Side -->
			<?php if (!empty($scatter_data) && !empty($lecturer_names_pie)) { ?>
				<div class="row">
					<div class="col-lg-12 grid-margin">
						<div class="card shadow card-equal-height">
							<div class="card-body">
								<h4 class="card-title"><i class="hgi-stroke hgi-chart-scatter"></i> Scatter and Pie Chart Workload Analysis</h4>
								<div class="row">
									<!-- Scatter Chart Column -->
									<div class="col-lg-8">
										<h5 class="text-center">Lecturer's Workload vs Program's Projection Workload</h5>
										<canvas id="projectionScatterChart" width="400" height="200"></canvas>
									</div>

									<!-- Pie Chart Column -->
									<div class="col-lg-4">
										<h5 class="text-center">Workload Distribution by Lecturer</h5>
										<canvas id="projectionPieChart" width="400" height="200"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		

									
		</div>
        <?php include "layout/footer.php";?>
      </div>
    </div>
  </div>

  <?php include "layout/script.php";?>
  
  <?php
      // If form is submitted
    if (isset($_POST['generate_report'])) {
        // Get selected program and session
        $program_code = $_POST['program_code'];
        $session_id = $_POST['session_id'];
		echo $program_code;
		
		//check from worload if program code or session exist or not
		$sqlCheck = mysqli_query($conn, "SELECT * FROM projection WHERE program_code = '$program_code' AND session_id = '$session_id'");
		$numRowCheck = mysqli_num_rows($sqlCheck);
		if($numRowCheck > 0)
		{
			// Query to get program name and session information for the title
			$sqlProgram = mysqli_query($conn, "SELECT program FROM program WHERE program_code = '$program_code'");
			$rowProgram = mysqli_fetch_assoc($sqlProgram);
			$program = $rowProgram['program'];

			// Fetch session information from the session table
			$sessionQuery = mysqli_query($conn, "SELECT * FROM session WHERE session_id = '$session_id'");
			$sessionData = mysqli_fetch_assoc($sessionQuery);
			$session = date('M-Y', strtotime($sessionData['year'] . '-' . $sessionData['month'] . '-01'));

			// Query to get total assigned hours for each lecturer based on selected program and session
			$sql = mysqli_query($conn, "
				SELECT 
					l.lecturer_id, 
					l.name AS lecturer_name, 
					SUM(w.assigned_hours) AS total_workload
				FROM projection w
				JOIN course c ON w.course_code = c.course_code
				JOIN lecturer l ON w.lecturer_id = l.lecturer_id
				JOIN session s ON w.session_id = s.session_id
				WHERE w.program_code = '$program_code' 
				AND s.session_id = '$session_id'
				GROUP BY l.lecturer_id
				ORDER BY lecturer_name
			");




			// Prepare data arrays for JavaScript
			$lecturer_names = [];
			$total_workload = [];

			// Fetch the data and populate the arrays
			while ($row = mysqli_fetch_array($sql)) {
				$lecturer_names[] = $row['lecturer_name'];
				$total_workload[] = $row['total_workload'];
			}

			// Prepare the data for Chart.js (JSON format)
			$lecturer_names_json = json_encode($lecturer_names);
			$total_workload_json = json_encode($total_workload);
			
			// Line Chart
			// Query to get the projection per lecturer for each month for the selected program and session
			$sqlTrend = mysqli_query($conn, "
				SELECT l.name AS lecturer_name, s.month, SUM(w.assigned_hours) AS total_workload
				FROM projection w
				JOIN course c ON w.course_code = c.course_code
				JOIN lecturer l ON w.lecturer_id = l.lecturer_id
				JOIN session s ON w.session_id = s.session_id
				WHERE w.program_code = '$program_code' 
				AND s.session_id = '$session_id'
				GROUP BY l.lecturer_id, s.month
				ORDER BY lecturer_name, s.month
			");

			// Initialize arrays for JavaScript
			$lecturer_names_trend = [];
			$projection_by_month = []; // Array to hold the data per month for each lecturer

			// Fetch the data and populate the arrays
			while ($rowTrend = mysqli_fetch_array($sqlTrend)) {
				$lecturer_name = $rowTrend['lecturer_name'];
				$month = $rowTrend['month']; // Get the month (1 = January, 12 = December)
				$total_workload_trend = $rowTrend['total_workload'];

				// If this is the first time encountering this lecturer, add them to the list
				if (!in_array($lecturer_name, $lecturer_names_trend)) {
					$lecturer_names_trend[] = $lecturer_name;
				}

				// Add the data to the projection array for each lecturer
				if (!isset($projection_by_month[$lecturer_name])) {
					$projection_by_month[$lecturer_name] = array_fill(0, 12, 0); // 12 months for each lecturer
				}

				// Store the total contact hours in the corresponding month (adjusted for 0-based index)
				$projection_by_month[$lecturer_name][$month - 1] = $total_workload_trend;
			}

			// Prepare the data for Chart.js (JSON format)
			$lecturer_names_json = json_encode($lecturer_names_trend);
			$projection_by_month_json = json_encode($projection_by_month);
			
			/* scatter chart */
			// SQL query to get the lecturer's projection and program's total projection
			$sqlScatter = mysqli_query($conn, "
				SELECT 
					l.name AS lecturer_name, 
					p.program, 
					SUM(w.assigned_hours) AS lecturer_projection,
					(SELECT SUM(c2.assigned_hours)
					 FROM projection c2
					 WHERE c2.program_code = p.program_code) AS program_projection
				FROM projection w
				JOIN course c ON w.course_code = c.course_code
				JOIN lecturer l ON w.lecturer_id = l.lecturer_id
				JOIN program p ON w.program_code = p.program_code
				JOIN session s ON w.session_id = s.session_id
				GROUP BY l.lecturer_id, p.program
				ORDER BY l.name
			");


			// Initialize arrays to hold the data for the scatter plot
			$scatter_data = [];

			// Fetch the data and populate the arrays
			while ($rowScatter = mysqli_fetch_array($sqlScatter)) {
				$lecturer_name = $rowScatter['lecturer_name'];
				$lecturer_projection = $rowScatter['lecturer_projection'];
				$program_projection = $rowScatter['program_projection'];

				// Populate the scatter data as an array of points
				$scatter_data[] = [
					'x' => $lecturer_projection,  // X-axis: Lecturer projection
					'y' => $program_projection,   // Y-axis: Program projection
					'label' => $lecturer_name   // Label: Lecturer's name
				];
			}
			
			/* pie chart */
			// Query to get each lecturer's projection for the given program and session
			$sqlPieChart = mysqli_query($conn, "
				SELECT 
					l.name AS lecturer_name, 
					SUM(w.assigned_hours) AS lecturer_projection
				FROM projection w
				JOIN course c ON w.course_code = c.course_code
				JOIN lecturer l ON w.lecturer_id = l.lecturer_id
				JOIN session s ON w.session_id = s.session_id
				WHERE w.program_code = '$program_code' 
				AND s.session_id = '$session_id'
				GROUP BY l.lecturer_id
			");

			$lecturer_names_pie = [];
			$lecturer_projections_pie = [];
			$total_projection = 0;

			// Populate data arrays and calculate the total projection
			while ($rowPie = mysqli_fetch_array($sqlPieChart)) {
				$lecturer_names_pie[] = $rowPie['lecturer_name'];
				$lecturer_projections_pie[] = $rowPie['lecturer_projection'];
				$total_projection += $rowPie['lecturer_projection'];
			}

			// Calculate percentage projections
			$projection_percentages = array_map(function($projection) use ($total_projection) {
				return round(($projection / $total_projection) * 100); // Calculate percentage and round to 2 decimal places
			}, $lecturer_projections_pie);
		
		}
		else
		{
			echo "<script>
					$(document).ready(function() {
						$('#noDataModal').modal('show');
					});
				  </script>";
		}

    }
  ?>
  
  <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
		<?php if (isset($lecturer_names_json)) { ?>
			var ctx = document.getElementById('contactHoursChart').getContext('2d');
			var contactHoursChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: <?php echo $lecturer_names_json; ?>, // Lecturer names
					datasets: [{
						label: 'Total Workloads',
						data: <?php echo $total_workload_json; ?>, // Total assigned hours
						backgroundColor: 'rgba(54, 162, 235, 0.2)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		<?php } ?>
	</script>



	
	<script>
        <?php if (isset($lecturer_names_trend)) { ?>
            var ctx = document.getElementById('projectionTrendChart').getContext('2d');
            var projectionTrendChart = new Chart(ctx, {
                type: 'line', // Line chart type
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Months labels
                    datasets: <?php 
                        // Prepare the datasets for Chart.js based on lecturer names and their monthly projections
                        $datasets = [];
                        foreach ($projection_by_month as $lecturer_name => $monthly_data) {
                            $datasets[] = [
                                'label' => $lecturer_name,
                                'data' => $monthly_data,
                                'fill' => false, // Disable filling under the line
                                'borderColor' => 'rgba(75, 192, 192, 1)', // Color for the line
                                'tension' => 0.1 // Tension for the curve of the line
                            ];
                        }
                        echo json_encode($datasets);
                    ?>,
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Workloads'
                            }
                        }
                    }
                }
            });
        <?php } ?>
    </script>
	



<script>
    <?php if (!empty($scatter_data)) { ?>
        var ctx = document.getElementById('projectionScatterChart').getContext('2d');

        var scatterData = <?php echo json_encode($scatter_data); ?>; // Fetch scatter data from PHP

        var scatterChart = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: "Lecturer Workload vs Program's Projection Workload",
                    data: scatterData, // Use the PHP data here
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue points
                    borderColor: 'rgba(54, 162, 235, 1)', // Line color
                    borderWidth: 2,
                    fill: false, // Do not fill the area under the curve
                    showLine: false, // Connect the points with lines
                    tension: 0.1 // Smooth out the curve between points
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear', // Treat X-axis as continuous numeric data
                        position: 'bottom',
                        ticks: {
                            stepSize: 1,
                            min: 0,  // Start from zero for projection
                        },
                        title: {
                            display: true,
                            text: 'Lecturer Workload'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Program's Projection Workload"
                        }
                    }
                }
            }
        });
    <?php } ?>
</script>

<script>
    <?php if (!empty($lecturer_names_pie)) { ?>
        var ctx = document.getElementById('projectionPieChart').getContext('2d');

        var pieChartData = {
            labels: <?php echo json_encode($lecturer_names_pie); ?>, // Lecturer names
            datasets: [{
                label: 'Workload Percentage',
                data: <?php echo json_encode($projection_percentages); ?>, // Workload as percentages
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
                    '#F7464A', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360', '#AC64AD'
                ], // Colors for each section
                hoverOffset: 10 // Increase hover size for better visual feedback
            }]
        };

        var projectionPieChart = new Chart(ctx, {
            type: 'pie',
            data: pieChartData,
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let label = tooltipItem.label || '';
                                let value = tooltipItem.raw;
                                return label + ': ' + value + '%';
                            }
                        }
                    }
                }
            }
        });
    <?php } ?>
</script>



</body>
</html>

<?php
}
?>
