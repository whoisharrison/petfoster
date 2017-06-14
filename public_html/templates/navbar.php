<header>
	<nav class="navbar navbar-default">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand">
					<img src="./images/logo_small.png" alt="PetRescueABQ logo"></a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
						  data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
					<li><a routerLink="message">Messages</a></li>
					<li><a href="https://bootcamp-coders.cnm.edu/~mjordan30/dog-social/static-ui/"
							 target="_blank">barkparkz</a></li>
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
							<form id="signInForm" #signInForm="ngForm" name="signInForm" (ngSubmit)="createSignIn();">
								<!--name-->
								<div class="form-group"
									  [ngClass]="{ 'has-error': profileEmail.touched && profileEmail.invalid }">
									<h2>Sign In</h2>
									<label for="Name">E-mail <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="email" class="form-control" id="email" required
												 [(ngModel)]="signInData.profileEmail" #profileEmail="ngModel" name="name"
												 placeholder="E-mail">
									</div>

									<div [hidden]="profileEmail.valid || profileEmail.pristine" class="alert alert-danger"
										  role="alert">
										<p *ngIf="profileEmail.errors?.maxlength">Please enter a valid email.</p>
										<p *ngIf="profileEmail.errors?.required">Email is required.</p>
									</div>

								</div>

								<!--Password-->
								<div class="form-group"
									  [ngClass]="{ 'has-error': profilePassword.touched && profilePassword.invalid }">
									<label for="username">Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="password" class="form-control" id="password" name="password" required
												 [(ngModel)]="signInData.profilePassword" #profilePassword="ngModel"
												 placeholder="Password">
									</div>

									<div [hidden]="profilePassword.valid || profilePassword.pristine" class="alert alert-danger"
										  role="alert">
										<p *ngIf="profilePassword.errors?.maxlength">Please enter a vaild password.</p>
										<p *ngIf="profilePassword.errors?.required">Password is required.</p>
									</div>

								</div>


								<button class="btn btn-success" type="submit" [disabled]="signInForm.invalid"><i
										class="fa fa-paper-plane"></i> Sign In
								</button>
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
							<form id="signUpForm" #signUpForm="ngForm" name="signUpForm" (ngSubmit)="createSignUp();">


								<!--name-->
								<div class="form-group">
									<h2>Sign Up</h2>
									<label for="Name">Name <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="text" class="form-control" id="name" name="name" placeholder="full name"
												 required [(ngModel)]="signUp.profileName" #signUpName="ngModel">
									</div>
								</div>

								<!--User Name-->
								<div class="form-group">
									<label for="username">User Name <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="text" class="form-control" id="username" name="username"
												 placeholder="User Name" required [(ngModel)]="signUp.profileAtHandle"
												 #signUpAtHandle="ngModel">
									</div>
								</div>

								<!--Email-->
								<div class="form-group">
									<label for="email">E-mail <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="email" class="form-control" id="email" name="email" placeholder="Email"
												 required [(ngModel)]="signUp.profileEmail" #signUpEmail="ngModel">
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
												 placeholder="Password" required [(ngModel)]="signUp.profilePassword"
												 #signUpPassword="ngModel">
									</div>
								</div>

								<!--Confirm Password-->
								<div class="form-group">
									<label for="passwordConfirm">Confirm Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-paw" aria-hidden="true"></i>
										</div>
										<input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm"
												 placeholder="Confirm Password" required [(ngModel)]="signUp.profilePasswordConfirm"
												 #signUpPasswordConfirm="ngModel">
									</div>
								</div>

								<!--Organization yes or no-->
								<div class="form-group">
									<label for="orgcheck">Are you registering an organization? <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="btn-group" data-toggle="buttons-radio">

											<label class="radio-inline"><input type="radio" data-toggle="collapse"
																						  data-target="#orghidden" value="O"
																						  name="profileFlag" [(ngModel)]="signUp.profileFlag">Register
												an Organization</label>
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
											<input type="text" class="form-control" id="orgname" name="orgname"
													 placeholder="Organization Name" required [(ngModel)]="signUp.organizationName"
													 #signUpOrganizationName="ngModel">
										</div>
									</div>
									<!--Organization License Number-->
									<div class="form-group">
										<label for="orglicense">Adoption License <span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="text" class="form-control" id="orglicense" name="orglicense"
													 placeholder="Organization License" required
													 [(ngModel)]="signUp.organizationLicense" #signUpOrganizationLicense="ngModel">
										</div>
									</div>
									<!--Organization Address 1-->
									<div class="form-group">
										<label for="address1">Organization Address <span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="text" class="form-control" id="address1" name="address1"
													 placeholder="Organization Address" required
													 [(ngModel)]="signUp.organizationAddress1" #signUpOrganizationAddress1="ngModel">
										</div>
									</div>
									<!--Organization Address 2-->
									<div class="form-group">
										<label for="address1">Organization Address Continued<span
												class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="text" class="form-control" id="address2" name="address2"
													 placeholder="Organization Address Continued" required
													 [(ngModel)]="signUp.organizationAddress2" #signUpOrganizationAddress2="ngModel">
										</div>
									</div>
									<!--Organization City-->
									<div class="form-group">
										<label for="orgcity">Organization City<span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="text" class="form-control" id="orgcity" name="orgcity" placeholder="City"
													 required [(ngModel)]="signUp.organizationCity"
													 #signUpOrganizationCity="ngModel">
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
											<input type="text" class="form-control" id="orgzip" name="orgzip" placeholder="City"
													 required [(ngModel)]="signUp.organizationZip"
													 #signUpOrganizationZip="ngModel">
										</div>
									</div>
									<!--Organization Phone-->
									<div class="form-group">
										<label for="orgphone">Phone Number<span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-paw" aria-hidden="true"></i>
											</div>
											<input type="text" class="form-control" id="orgphone" name="orgphone"
													 placeholder="Phone Number" required [(ngModel)]="signUp.organizationPhone"
													 #signUpOrganizationPhone="ngModel">
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