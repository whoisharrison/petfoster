<header>
	<nav class="navbar navbar-default">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand">
					<img src="./images/logo_small.png" alt="PetRescueABQ logo"></a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" routerLink="">Pet Rescue ABQ</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<ul class="nav navbar-nav navbar-right">
					<li><a routerLink=""><i class="fa fa-home"></i></a></li>
					<li><a routerLink="about">About</a></li>
					<li><a href="mailto:petrescueabq@gmail.com?Subject=Hello%20again">Contact</a></li>
					<li><a routerLink="messages">Messages</a></li>
					<li><a href="https://bootcamp-coders.cnm.edu/~mjordan30/dog-social/static-ui/" target="_blank">barkparkz</a></li>
					<li class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg-2" id="login">sign in</li>
					<li class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="login">sign up</li>
				</ul>

			</div><!-- /.navbar-collapse -->

			<!-- sign in & sign up -->
			<!--sign in-->
			<div class="modal fade bd-example-modal-lg-2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
				  aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<!--Begin of Form-->
							<form id="signupForm" #signupForm="ngForm" name="signupForm" (ngSubmit)="createSignin();">


								<!--name-->
								<div class="form-group">
									<h2>Sign In</h2>
									<label for="Name">E-mail <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="name" class="form-control" id="name" name="name" placeholder="E-mail">
									</div>
								</div>

								<!--User Name-->
								<div class="form-group">
									<label for="username">Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="password" class="form-control" id="password" name="password"
												 placeholder="Password">
									</div>
								</div>


								<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Sign In</button>
								<button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
								<div class="checkbox">
									<label>
										<input type="checkbox"> Remember me
									</label>
								</div>
							</form>

						</div>
					</div>
				</div>
				<!-- End of Recaptcha & Form -->
			</div>
			<!--end of sign in-->

			<!--sign up	-->
			<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
				  aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<!--Begin of Form-->
							<form id="signupForm" #signupForm="ngForm" name="signupForm" (ngSubmit)="createSignUp();">


								<!--name-->
								<div class="form-group">
									<h2>Sign Up</h2>
									<label for="Name">Name <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="name" class="form-control" id="name" name="name" placeholder="full name">
									</div>
								</div>

								<!--User Name-->
								<div class="form-group">
									<label for="username">User Name <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="username" class="form-control" id="username" name="username"
												 placeholder="User Name">
									</div>
								</div>

								<!--Email-->
								<div class="form-group">
									<label for="email">E-mail <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="email" class="form-control" id="email" name="email" placeholder="Email">
									</div>
								</div>

								<!--Password-->
								<div class="form-group">
									<label for="password">Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="password" class="form-control" id="password" name="password"
												 placeholder="Password">
									</div>
								</div>

								<!--Confirm Password-->
								<div class="form-group">
									<label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="confirmpassword" class="form-control" id="confirmpassword" name="confirmpassword"
												 placeholder="Confirm Password">
									</div>
								</div>

								<!--Organization yes or no-->
								<div class="form-group">
									<label for="orgcheck">Are you seeking a pet or an organization? <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="btn-group" data-toggle="buttons-radio">
											<label class="radio-inline"><input type="radio" data-toggle="collapse in"
																						  data-target="#orghidden" name="optradio"
																						  checked="checked">Seeking Pet</label>
											<label class="radio-inline"><input type="radio" data-toggle="collapse"
																						  data-target="#orghidden"
																						  name="optradio">Organization</label>
										</div>
									</div>
								</div>

								<!-- collapse org -->
								<div id="orghidden" class="collapse">
									<!--Organization Name-->
									<div class="form-group">
										<label for="orgname">Organization Name <span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="orgname" class="form-control" id="orgname" name="orgname"
													 placeholder="Organization Name">
										</div>
									</div>
									<!--Organization License Number-->
									<div class="form-group">
										<label for="orglicense">Adoption License <span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="orglicense" class="form-control" id="orglicense" name="orglicense"
													 placeholder="Organization License">
										</div>
									</div>
									<!--Organization Address 1-->
									<div class="form-group">
										<label for="address1">Organization Address <span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="address1" class="form-control" id="address1" name="address1"
													 placeholder="Organization Address">
										</div>
									</div>
									<!--Organization Address 2-->
									<div class="form-group">
										<label for="address1">Organization Address Continued<span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="address2" class="form-control" id="address2" name="address2"
													 placeholder="Organization Address Continued">
										</div>
									</div>
									<!--Organization City-->
									<div class="form-group">
										<label for="orgcity">Organization City<span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="orgcity" class="form-control" id="orgcity" name="orgcity" placeholder="City">
										</div>
									</div>
									<!--Organization State-->
									<!--Organization Zip-->
									<div class="form-group">
										<label for="orgzip">Zip Code<span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="orgzip" class="form-control" id="orgzip" name="orgzip" placeholder="City">
										</div>
									</div>
									<!--Organization Phone-->
									<div class="form-group">
										<label for="orgphone">Phone Number<span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="orgphone" class="form-control" id="orgphone" name="orgphone"
													 placeholder="Phone Number">
										</div>
									</div>
								</div>

								<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
								<button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
							</form>

						</div>
					</div>
				</div>
				<!-- End of Recaptcha & Form -->
			</div>
			<!--	end sign up	-->
			<!-- end of sign in sign up -->

		</div><!-- /.container-fluid -->
	</nav>
</header>