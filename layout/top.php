<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="dashboard.php">
			<span class="font-weight-bold mb-2 text-dark">
				<img src="images/logo.png" alt="logo" />
			</span>	
        </a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.php">
           <img src="images/logo.png" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        
        <ul class="navbar-nav navbar-nav-right">
          <?php
		 
				if($_SESSION['UserLvl'] == 1)
				{
					$table = "admin";
					$id = "admin_id";
					$profileLink = "profile_admin.php";
				}
				else if($_SESSION['UserLvl'] == 2)
				{
					$table = "deputy_dean";
					$id = "deputy_dean_id";
					$profileLink = "profile_deputy_dean.php";
				}
				else if($_SESSION['UserLvl'] == 3)
				{
					$table = "coordinator";
					$id = "coordinator_id";
					$profileLink = "profile_coordinator.php";
				}
				
				$sql = mysqli_query($conn, "SELECT * FROM $table WHERE $id = '$_SESSION[UserID]'");
				$row = mysqli_fetch_array($sql);
			
			
				//dapatkan photo default
				if($row['photo'] == "")
					$link_photo = "photo/avatar.jpg";
				else
					$link_photo = "photo/$row[photo]";
				
				
				echo "<li class='nav-item dropdown  d-xl-inline-block'>
						<a class='nav-link dropdown-toggle' id='UserDropdown' href='#' data-toggle='dropdown' aria-expanded='false'>
						  <span class='profile-text'>Welcome!</span>
						  <img class='img-xs rounded-circle' src='$link_photo' alt='Profile image'>
						</a>
						<div class='dropdown-menu dropdown-menu-right navbar-dropdown' aria-labelledby='UserDropdown'>
						  <a href='$profileLink' class='dropdown-item mt-2 text-warning'>
							<i class='hgi-stroke hgi-user-edit-01'></i>	Update Profile
							</a>
						  <a href='update_password.php' class='dropdown-item text-success'>
							<i class='hgi-stroke hgi-square-lock-02'></i> Update Password
						  </a>
						  <a href='logout.php' class='dropdown-item text-danger'>
							<i class='hgi-stroke hgi-logout-01'></i> Log Out
						  </a>
						</div>
					  </li>";
				
			
			
			
		 ?>
          
        </ul>
		
			<button class='navbar-toggler navbar-toggler-right d-lg-none align-self-center' type='button' data-toggle='offcanvas'>
					  <span class='mdi mdi-menu'></span>
			</button>
			
      </div>
    </nav>