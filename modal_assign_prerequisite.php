<!-- add stock modal -->
					  <div class="modal fade" id="prereq<?php echo $row['course_code'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title"><i class="mdi mdi-plus-circle"></i> Assign Pre-requisite Course</h5>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								  </div>
								  <form method="post" action="assignPreq.php">
								  <input type="hidden" class="form-control" name="course_code" value="<?php echo $row['course_code']; ?>" readonly />
									  <div class="modal-body">
								
												<div class="row">
												  <div class="col-md-12">
													<div class="form-group">
														<label>Course</label>
														<select class="form-control" name="prerequisite" required>
															<option value="">- choose course -</option>
															<?php
																$sqlPreq = mysqli_query($conn, "SELECT * FROM course WHERE course_code != '$row[course_code]'");
																while($rowPreq = mysqli_fetch_array($sqlPreq))
																{
																	if($rowPreq['course_code'] == $row['prerequisite'])
																		echo "<option value='$rowPreq[course_code]' selected>$rowPreq[course]</option>";
																	else
																		echo "<option value='$rowPreq[course_code]'>$rowPreq[course]</option>";
																}
															?>
														</select>
													</div>
												  </div>
												</div>
												
											  
									  </div>
									  <div class="modal-footer">
										<button data-dismiss="modal" type="button" class="btn btn-secondary">Cancel</button>
										<button type="submit" name="submit" class="btn btn-primary mr-2"><i class="mdi mdi-check" style="font-size:14px;"></i> Assign</button>
									  </div>
								  </form>
								</div>
							  </div>
					  </div>
					  <!-- modal end -->