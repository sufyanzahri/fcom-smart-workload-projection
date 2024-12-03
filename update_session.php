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
    <?php include "layout/top.php";?>
    <div class="container-fluid page-body-wrapper">
        <?php include "layout/menu.php";?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Session</h4>
								<?php
								
									$session_id = $_GET['session_id'];

									// Fetch existing session data to pre-fill the form
									$sql = mysqli_query($conn, "SELECT * FROM session WHERE session_id = '$session_id'");
									$session = mysqli_fetch_assoc($sql);

									if (!$session) {
										echo "<div class='alert alert-danger'>Session not found.</div>";
										exit;
									}

									$selected_month = $session['month'];
									$selected_year = $session['year'];

									if (isset($_POST['submit'])) {
										$month = $_POST['month'];
										$year = $_POST['year'];

										// Convert month number to name
										$dateObj = DateTime::createFromFormat('!m', $month);
										$month_name = $dateObj->format('F');

										// Check if session with the same month and year already exists, excluding the current session
										$sqlCheck = mysqli_query($conn, "SELECT * FROM session WHERE month = '$month' AND year = '$year' AND session_id != '$session_id'");
										$numRowCheck = mysqli_num_rows($sqlCheck);

										if ($numRowCheck > 0)
										{
											echo "<div class='alert alert-danger alert-dismissible'>
													<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
													<strong>Sorry!</strong> Session $month_name $year already exists.
												  </div>";
										}
										else
										{
											// Update session in database
											$update = mysqli_query($conn, "UPDATE session SET month = '$month', year = '$year' WHERE session_id = '$session_id'");

											if ($update) {
												echo "<div class='alert alert-success alert-dismissible'>
														<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
														<strong>Thank you!</strong> Session $month_name $year has been updated.
													  </div>";
											} else {
												echo "<div class='alert alert-danger alert-dismissible'>
														<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
														<strong>Error!</strong> Failed to update session.
													  </div>";
											}
										}
									}
								?>
                                <form method="post">
                                    <p class="card-description text-primary">
                                        <i class="hgi-stroke hgi-folder-02"></i> Update Session details.
                                    </p>
                                    <hr />

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Month</label>
                                                <select class="form-control" name="month" required>
                                                    <option value="">- choose month -</option>
                                                    <?php
                                                    $months = [
                                                        1 => "January", 2 => "February", 3 => "March",
                                                        4 => "April", 5 => "May", 6 => "June",
                                                        7 => "July", 8 => "August", 9 => "September",
                                                        10 => "October", 11 => "November", 12 => "December"
                                                    ];
                                                    foreach ($months as $num => $name) {
                                                        $selected = ($num == $selected_month) ? "selected" : "";
                                                        echo "<option value='$num' $selected>$name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Year</label>
                                                <input type="number" min="2023" class="form-control" name="year" placeholder="Year" value="<?php echo $selected_year; ?>" required />
                                            </div>
                                        </div>
                                    </div>

					
									<br />
									<a href="manage_session.php" class="btn btn-outline-dark">
										<i class="mdi mdi-keyboard-backspace"></i> Back
									</a>
									<button type="submit" name="submit" class="btn btn-primary mr-2"><i class="mdi mdi-check"></i> Update</button>
                                </form>
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
