<?php require_once("lib/head-utils.php"); ?>
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header and navbar -->
		<?php require_once("lib/header.php"); ?>

		<!-- Large modal -->
		<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
			  aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!--Begin of Form-->
					<!--name-->
					<div class="container">
						<div class="form-group">
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

						<!--End of Sign-up form-->
						<!-- reCAPTCHA -->
						<div class="g-recaptcha" data-sitekey="--YOUR RECAPTCHA SITE KEY--"></div>

						<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Send</button>
						<button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
						</form>

						<!--empty area for form error/success output-->
						<div class="row">
							<div class="col-xs-12">
								<div id="output-area"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Recaptcha & Form -->
			</div>
		</div>
	</div>

	<?php require_once("lib/footer.php"); ?>
	</body>
	</html>








