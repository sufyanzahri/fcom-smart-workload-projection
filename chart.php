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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Workload Bar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body>
    <div style="width: 80%; margin: 0 auto;">
        <canvas id="contactHoursChart"></canvas>
    </div>

    <?php
    // Fetch the data from your database
    // Assume you've already connected to your database with $conn
    // and $current_year contains the current year
	$current_year = date('Y'); // Get the current year 
    $sql = mysqli_query($conn, "
        SELECT l.lecturer_id, l.name AS lecturer_name, SUM(c.contact_hour) AS total_contact_hours
        FROM workload w
        JOIN course c ON w.course_code = c.course_code
        JOIN lecturer l ON w.lecturer_id = l.lecturer_id
        JOIN session s ON w.session_id = s.session_id
        WHERE s.year = '$current_year'
        GROUP BY l.lecturer_id
        ORDER BY total_contact_hours DESC
    ");

    // Prepare data arrays for JavaScript
    $lecturer_names = [];
    $total_contact_hours = [];

    // Fetch the data and populate the arrays
    while ($row = mysqli_fetch_array($sql)) {
        $lecturer_names[] = $row['lecturer_name'];
        $total_contact_hours[] = $row['total_contact_hours'];
    }
    ?>

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
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                    borderColor: 'rgba(75, 192, 192, 1)',      // Border color for the bars
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

</body>
</html>
<?php
}
?>