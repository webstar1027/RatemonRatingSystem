	<div class="container" id="wrapper">

	</div>
	
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">	   
                       <h3><i class="fa fa-cog fa-fw"></i> Profile</h3>
                    </div>		
                </div>		
            </div>
                <div class="row">
					<div class="col-md-12">
							<div class="panel panel-primary">
							  <div class="panel-heading"><strong> Account Profile</strong></div>
							  <div class="panel-body">

									<div id="update-error" class="alert alert-danger hidden">
											<button type="button" class="close dismissable">&times;</button>
											<span></span>
									</div>
									<div id="update-success" class="alert alert-success hidden">
											<button type="button" class="close dismissable">&times;</button>
											<span></span>
									</div>
								  
									<div class="col-md-8 col-md-offset-2">
										<form id="update-name">
											<h4><i class="fa fa-user"></i> Your Full Name</h4><br>
											<div class="form-group">
													<label class="control-label" for="full-name">Full Name</label>
													<input class="form-control" type="text" id="full-name" name="full_name" placeholder="Your Name" value="<?php echo $profile->full_name; ?>">
											</div>
											<button type="submit" class="btn btn-primary update-name">Update Your Name</button>
											<br>
										</form>
										<br>
										<hr>
										<form id="update-email">
											<h4><i class="fa fa-envelope"></i> Your Email</h4><br>
											<div class="form-group">
													<label class="control-label" for="email">Your Email</label>
													<input class="form-control" type="text" id="email" name="email" placeholder="Your Email" value="<?php echo $profile->email; ?>">
											</div>
											<button type="submit" class="btn btn-primary update-email">Update Your Email</button>
											<br>
										</form>
										<br>
										<hr>
										<form id="update-password">
											<h4><i class="fa fa-lock"></i> Update Password</h4><br>
											<div class="form-group">
													<label class="control-label" for="password">Password</label>
													<input class="form-control" type="password" id="password" name="password" placeholder="Password">
											</div>
											<div class="form-group">
													<label class="control-label" for="retype_password">Password Confirmation</label>
													<input class="form-control" type="password" id="retype_password" name="retype_password" placeholder="Retype Password">
											</div>
											<button type="submit" class="btn btn-primary update-password">Update Password</button>
										</form>
										 <br><br>
									</div>
							  </div>
							</div>
					</div>
                </div>
        </div>