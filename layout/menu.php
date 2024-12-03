<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          
		  
		  <?php
		  
		  if($_SESSION['UserLvl'] == 1)
		  {
			  $table = "admin";
			  $id = "admin_id";
		  }
		  else if($_SESSION['UserLvl'] == 2)
		  {
			  $table = "deputy_dean";
			  $id = "deputy_dean_id";
		  }
		  else if($_SESSION['UserLvl'] == 3)
		  {
			  $table = "coordinator";
			  $id = "coordinator_id";
		  }
				
		  $sql = mysqli_query($conn, "SELECT * FROM $table WHERE $id = '$_SESSION[UserID]'");
		  $row = mysqli_fetch_array($sql);
			  
		  $name = mb_substr($row['name'], 0, 14);
		  
		  // menu admin
		  if($_SESSION['UserLvl'] == 1)
		  {
			  echo "<li class='nav-item nav-profile'>
					<div class='nav-link'>
					  <div class='user-wrapper'>
						<div class='profile-image'>
						  <img src='photo/$row[photo]' alt='profile image'>
						</div>
						<div class='text-wrapper'>
						  <p class='profile-name'>$name...</p>
						  <div>
							<small class='designation text-muted'>Admin</small>
							<span class='status-indicator online'></span>
						  </div>
						</div>
					  </div>
					  <a href='add_program_coordinator.php' class='btn btn-primary btn-block'
					  data-toggle='tooltip' data-placement='right' title='Add Program Coordinator'>
						<i class='mdi mdi-plus' style='font-size:12px;'></i> Coordinator
					  </a>
					</div>
				  </li>";
				  
			  echo "<li class='nav-item'>
					<a class='nav-link' href='dashboard.php'>
					  <i class='menu-icon hgi-stroke hgi-dashboard-square-01'></i>
					  <span class='menu-title'>Dashboard</span>
					</a>
				  </li>
				   
				   <li class='nav-item'>
					<a class='nav-link' href='manage_deputy_dean.php'>
					  <i class='menu-icon hgi-stroke hgi-user-account'></i>
					  <span class='menu-title'>Deputy Dean</span>
					</a>
				   </li>
				  
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-pc' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-user-star-01'></i>
							<span class='menu-title'>Coordinator</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-pc'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_program_coordinator.php'>Add Coordinator</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_program_coordinator.php'>Manage Coordinator</a>
							</li>
						</ul>
					</div>
				   </li>
				  
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-lecturer' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-user-group'></i>
							<span class='menu-title'>Lecturer</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-lecturer'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_lecturer.php'>Add Lecturer</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_lecturer.php'>Manage Lecturer</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-session' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-folder-02'></i>
							<span class='menu-title'>Session</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-session'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_session.php'>Add Session</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_session.php'>Manage Session</a>
							</li>
						</ul>
					</div>
				   </li>
				  
				  <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-program' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-stroke hgi-folder-favourite'></i>
							<span class='menu-title'>Program</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-program'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_program.php'>Add Program</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_program.php'>Manage Program</a>
							</li>
						</ul>
					</div>
				   </li>
				  
				  <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-course' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-file-01'></i>
							<span class='menu-title'>Course</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-course'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_course.php'>Add Course</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_course.php'>Manage Course</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-projection' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-projector-01'></i>
							<span class='menu-title'>Projection</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-projection'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='assign_projection.php'>Assign Projection</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_projection.php'>Manage Projection</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				   
				   
				   <li class='nav-item'>
					<a class='nav-link' href='report.php'>
					  <i class='menu-icon hgi-stroke hgi-analytics-01'></i>
					  <span class='menu-title'>Report</span>
					</a>
				   </li>
					  
				  ";
			
			
		  }
		  
		  //menu deputy dean
		  else if($_SESSION['UserLvl'] == 2)
		  {
			  echo "<li class='nav-item nav-profile'>
					<div class='nav-link'>
					  <div class='user-wrapper'>
						<div class='profile-image'>
						  <img src='photo/$row[photo]' alt='profile image'>
						</div>
						<div class='text-wrapper'>
						  <p class='profile-name'>$name...</p>
						  <div>
							<small class='designation text-muted'>Deputy Dean</small>
							<span class='status-indicator online'></span>
						  </div>
						</div>
					  </div>
					  <a href='add_lecturer.php' class='btn btn-primary btn-block'
					  data-toggle='tooltip' data-placement='right' title='Add Lecturer'>
						<i class='mdi mdi-plus' style='font-size:12px;'></i> Lecturer
					  </a>
					</div>
				  </li>";
				  
			  echo "<li class='nav-item'>
					<a class='nav-link' href='dashboard.php'>
					  <i class='menu-icon hgi-stroke hgi-dashboard-square-01'></i>
					  <span class='menu-title'>Dashboard</span>
					</a>
				  </li>
				   
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-lecturer' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-user-group'></i>
							<span class='menu-title'>Lecturer</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-lecturer'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_lecturer.php'>Add Lecturer</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_lecturer.php'>Manage Lecturer</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-session' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-folder-02'></i>
							<span class='menu-title'>Session</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-session'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_session.php'>Add Session</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_session.php'>Manage Session</a>
							</li>
						</ul>
					</div>
				   </li>
				  
				  <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-program' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-stroke hgi-folder-favourite'></i>
							<span class='menu-title'>Program</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-program'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_program.php'>Add Program</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_program.php'>Manage Program</a>
							</li>
						</ul>
					</div>
				   </li>
				  
				  <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-course' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-file-01'></i>
							<span class='menu-title'>Course</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-course'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_course.php'>Add Course</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_course.php'>Manage Course</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-projection' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-projector-01'></i>
							<span class='menu-title'>Projection</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-projection'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='assign_projection.php'>Assign Projection</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_projection.php'>Manage Projection</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				   
				   <li class='nav-item'>
					<a class='nav-link' href='report.php'>
					  <i class='menu-icon hgi-stroke hgi-analytics-01'></i>
					  <span class='menu-title'>Report</span>
					</a>
				   </li>
					  
				  ";
			
			
		  }
		  
		  //menu coordinator
		  else if($_SESSION['UserLvl'] == 3)
		  {
			  echo "<li class='nav-item nav-profile'>
					<div class='nav-link'>
					  <div class='user-wrapper'>
						<div class='profile-image'>
						  <img src='photo/$row[photo]' alt='profile image'>
						</div>
						<div class='text-wrapper'>
						  <p class='profile-name'>$name...</p>
						  <div>
							<small class='designation text-muted'>Coordinator</small>
							<span class='status-indicator online'></span>
						  </div>
						</div>
					  </div>
					  <a href='add_my_lecturer.php' class='btn btn-primary btn-block'
					  data-toggle='tooltip' data-placement='right' title='Add Lecturer'>
						<i class='mdi mdi-plus' style='font-size:12px;'></i> Lecturer
					  </a>
					</div>
				  </li>";
				  
			  echo "<li class='nav-item'>
					<a class='nav-link' href='dashboard.php'>
					  <i class='menu-icon hgi-stroke hgi-dashboard-square-01'></i>
					  <span class='menu-title'>Dashboard</span>
					</a>
				  </li>
				   
				   
				   <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-lecturer' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-user-group'></i>
							<span class='menu-title'>Lecturer</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-lecturer'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_lecturer.php'>Add Lecturer</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_lecturer.php'>Manage Lecturer</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				  
				  <li class='nav-item'>
					<a class='nav-link' data-toggle='collapse' href='#ui-course' aria-expanded='false' aria-controls='ui-basic'>
						<i class='menu-icon hgi-stroke hgi-file-01'></i>
							<span class='menu-title'>Course</span>
						<i class='menu-arrow'></i>
					</a>
					<div class='collapse' id='ui-course'>
						<ul class='nav flex-column sub-menu'>
							<li class='nav-item'>
								<a class='nav-link' href='add_course.php'>Add Course</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='manage_course.php'>Manage Course</a>
							</li>
						</ul>
					</div>
				   </li>
				   
				   <li class='nav-item'>
					<a class='nav-link' href='view_projection.php'>
					  <i class='menu-icon hgi-stroke hgi-projector-01'></i>
					  <span class='menu-title'>Projection</span>
					</a>
				   </li>
				   
				   
				   <li class='nav-item'>
					<a class='nav-link' href='report_for_coordinator.php'>
					  <i class='menu-icon hgi-stroke hgi-analytics-01'></i>
					  <span class='menu-title'>Report</span>
					</a>
				   </li>
					  
				  ";
			
			
		  }
		  
		 
		  ?>
         
          
        </ul>
      </nav>
	  