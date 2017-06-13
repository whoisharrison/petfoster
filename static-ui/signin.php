<?php require_once("lib/head-utils.php"); ?>
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header and navbar -->
		<?php require_once("lib/header.php"); ?>

		<!-- Large modal -->
		<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg-2">Large modal</button>

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


							<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
							<button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
						</form>

					</div>
				</div>
			</div>
			<!-- End of Recaptcha & Form -->
		</div>
	</div>

	<?php require_once("lib/footer.php"); ?>
</body>
</html>








