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
			$program_code = $_GET['program_code']; // Get the program code from the URL parameter

			// Query to fetch the program name based on program code
			$sqlProgram = mysqli_query($conn, "SELECT program FROM program WHERE program_code = '$program_code'");
			$program = mysqli_fetch_array($sqlProgram);

			// Check if program exists and get its name
			$programName = $program ? $program['program'] : 'Program Not Found';

			// Define an array with the possible background color classes
			//$bgClasses = ['bg-info', 'bg-success', 'bg-primary', 'bg-warning'];
			//$bgCount = count($bgClasses); // Total number of background classes
			//$index = 0; // Initialize an index to cycle through the background classes
			$bgClass = $_GET['bgcolor'];

			// Display the title with the program name
			echo "<h4><i class='menu-icon hgi-stroke hgi-folder-02'></i> Session List for Program $programName</h4><br />";

			// Fetch all available sessions from the session table
			$sqlSessions = mysqli_query($conn, "SELECT * FROM session ORDER BY year ASC");

			while ($row = mysqli_fetch_array($sqlSessions)) {
				// Format the date for each session
				$formattedDate = date('M-Y', strtotime($row['year'] . '-' . $row['month'] . '-01'));

				// Select the background class based on the current index
				//$bgClass = $bgClasses[$index];

				echo "<div class='row'>
						<div class='col-xl-12 col-lg-12 col-md-12 col-sm-6 grid-margin stretch-card'>
						  <div class='card card-statistics $bgClass pull-up shadow'>
							<div class='card-body text-white'>
							  <div class='clearfix'>
								<div class='float-left'>
								  <i class='hgi-stroke hgi-timer-02 icon-lg'></i>
								</div>
								<div class='float-right'>
								  <p class='mb-0 text-right'>Workload</p>
								  <div class='fluid-container'>
									<h3 class='font-weight-medium text-right mb-0'>Lecturer's Workload for $formattedDate</h3>
								  </div>
								</div>
							  </div>
							  <p class='mt-3 mb-0 text-right'>
								<button onclick='checkWorkload(\"$program_code\", \"{$row['session_id']}\")' class='btn btn-outline-dark text-white'>
								  View Lecturer's Workload
								</button>
							  </p>
							</div>
						  </div>
						</div>
					  </div>";

				// Update the index to the next background class
				//$index = ($index + 1) % $bgCount;
			}
		?>
		
		<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="alertModalLabel"><i class="hgi-stroke hgi-alert-01"></i> Sorry...</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  </div>
			  <div class="modal-body">
				No workload data available for this session.
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
         
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
   <?php include "layout/script.php";?>
   <script>
function checkWorkload(programCode, sessionId) {
    $.ajax({
        url: 'check_projection.php',
        type: 'GET',
        data: {
            program_code: programCode,
            session_id: sessionId
        },
        success: function(response) {
            console.log("AJAX response:", response); // Log the response for debugging
            if (response.trim() === 'exists') {
                // Redirect to workload page if data exists
                window.location.href = `view_workload.php?program_code=${programCode}&session_id=${sessionId}`;
            } else {
                // Show alert modal if no data exists
                $('#alertModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error); // Log any AJAX errors
        }
    });
}

	</script>


</body>

</html>
<?php
}
?>