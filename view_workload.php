<?php
include "conn/conn.php";
error_reporting(0);
session_start();
if (empty($_SESSION['UserID']) AND empty($_SESSION['Password'])) {
    header('location:index.php');
} else {
    // Get the program and session information
    $program_code = $_GET['program_code'];
    $session_id = $_GET['session_id'];

    // Fetch program name from the program table
    $programQuery = mysqli_query($conn, "SELECT program FROM program WHERE program_code = '$program_code'");
    $programData = mysqli_fetch_assoc($programQuery);
    $program = $programData['program'];

    // Fetch session information from the session table
    $sessionQuery = mysqli_query($conn, "SELECT * FROM session WHERE session_id = '$session_id'");
    $sessionData = mysqli_fetch_assoc($sessionQuery);
	$session = date('M-Y', strtotime($sessionData['year'] . '-' . $sessionData['month'] . '-01'));

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
                                    <h4 class="card-title">Lecturer's Workload for Program <?php echo $program; ?>, Session <?php echo $session; ?></h4>
                                    <br />
                                    <div class="table-responsive">
                                        <table id="datatable3" class="table dataTable no-footer" role="grid">
											<thead>
												<tr>
													<th>No</th>
													<th>Lecturer</th>
													<th>Specialization</th>
													<th>Subject Taught</th>
													<th>Subject Workload</th>
													<th>Total Workload</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$bil = 1;
													
													// Run the updated query to get the lecturer details, courses, and assigned hours
													$sql = mysqli_query($conn, "
													SELECT 
														pr.lecturer_id, 
														l.name AS lecturer_name, 
														l.specialization_code,
														s.specialization, 
														pr.program_code,
														pr.course_code,
														c.course AS course_name,
														pr.assigned_hours,
														(SELECT SUM(pr2.assigned_hours) FROM projection pr2 WHERE pr2.lecturer_id = pr.lecturer_id) AS total_assigned_hours
													FROM projection pr
													LEFT JOIN lecturer l ON pr.lecturer_id = l.lecturer_id
													LEFT JOIN specialization s ON l.specialization_code = s.specialization_code
													LEFT JOIN course c ON pr.course_code = c.course_code
													WHERE pr.program_code = '$program_code'
													AND pr.lecturer_id IS NOT NULL
													AND pr.assigned_hours IS NOT NULL
													GROUP BY pr.lecturer_id, pr.course_code
												");

													
													if (mysqli_num_rows($sql) > 0) {
														$lecturer_courses = [];
														while ($row = mysqli_fetch_array($sql)) {
															// Store each course and assigned hours in an array, grouped by lecturer
															$lecturer_courses[$row['lecturer_id']]['lecturer_name'] = $row['lecturer_name'];
															$lecturer_courses[$row['lecturer_id']]['specialization'] = $row['specialization'];
															$lecturer_courses[$row['lecturer_id']]['courses'][] = [
																'course_name' => $row['course_name'],
																'course_code' => $row['course_code'],
																'assigned_hours' => $row['assigned_hours']
															];
															// The total assigned hours for the lecturer is pulled from the query
															$lecturer_courses[$row['lecturer_id']]['total_assigned_hours'] = $row['total_assigned_hours'];
														}

														// Now iterate over the grouped data and display it
														foreach ($lecturer_courses as $lecturer_id => $data) {
															$firstCourse = true;  // Flag to check if it's the first course for this lecturer

															// Loop through the courses for this lecturer
															foreach ($data['courses'] as $course) {
																// For the first course, display the lecturer's name, specialization, and total workload
																if ($firstCourse) {
																	echo "<tr>
																			<th scope='row'>$bil</th>
																			<td>{$data['lecturer_name']}</td>
																			<td>{$data['specialization']}</td>
																			<td>{$course['course_code']} - {$course['course_name']}</td>
																			<td>{$course['assigned_hours']} Hours</td>
																			<td>{$data['total_assigned_hours']} Hours</td>
																		  </tr>";
																	$firstCourse = false;
																} else {
																	// For subsequent courses, display the course name and workload only (leave name, specialization, and total workload empty)
																	echo "<tr>
																			<th scope='row'></th>
																			<td></td>
																			<td></td>
																			<td>{$course['course_code']} - {$course['course_name']}</td>
																			<td>{$course['assigned_hours']} Hours</td>
																			<td></td>
																		  </tr>";
																}
															}
															$bil++;
														}
													} else {
														echo "<tr><td colspan='6'>No projection data available for this session.</td></tr>";
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
	<!-- jQuery (required for DataTables) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- DataTables JS -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

	<!-- DataTables Buttons JS -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>

	<!-- JSZip (required for Excel export) -->
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

	<!-- FileSaver (required for Excel export) -->
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

	<!-- DataTables Buttons for Excel -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>

	
<script>
    $(document).ready(function() {
        var programName = "<?php echo $program; ?>";
        var sessionName = "<?php echo $session; ?>";

        // Initialize DataTable with export buttons
        $('#datatable3').DataTable({
            dom: 'Bfrtip',  // This adds the buttons to the DataTable
			ordering: false,  // Disable sorting
            buttons: [
                {
                    extend: 'excel',  // Excel export button
                    text: 'Export to Excel',  // Custom text for the button
                    className: 'btn btn-primary', // Use the existing btn and btn-primary classes for styling
                    filename: function() {
                        return 'Lecturers_Workload_for_' + programName + '_Session_' + sessionName;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'  // Export all pages
                        },
                        columns: [0, 1, 2, 3, 4, 5], // Export all columns, change as needed
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 3 || column === 4) {
                                    // For "Subject Taught" and "Assigned Hours", split the data and add newlines
                                    var splitData = data.split("<br>");
                                    data = '';
                                    for (var i = 0; i < splitData.length; i++) {
                                        data += splitData[i];
                                        if (i + 1 < splitData.length) {
                                            // Add a newline for Excel format
                                            data += "\n";
                                        }
                                    }
                                }
                                return data;
                            }
                        }
                    },
                    // Adding a custom title row to the exported Excel
                    header: true,
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // Insert a custom title in the first row of the Excel sheet
                        $('row c[r="A1"]', sheet).attr('t', 'inlineStr');
                        $('row c[r="A1"]', sheet).html('<is><t>Lecturer\'s Workload for Program ' + programName + ', Session ' + sessionName + '</t></is>');
                    }
                }
            ]
        });
    });
</script>







</body>

</html>
<?php
}
?>
