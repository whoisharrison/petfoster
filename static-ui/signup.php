<?php require_once("lib/head-utils.php");?>
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header and navbar -->
		<?php require_once("lib/header.php");?>

		<main class="bg p-t-nav">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-4">
						<!--Begin of Form-->
						<!--name-->
						<div class="form-group">
							<label for="Name">Name <span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</div>
								<input type="name" class="form-control" id="name" name="name" placeholder="full name">
							</div>
						</div>
						<!--User Name-->
						<!--Email-->
						<!--Password-->
						<!--Confirm Password-->
						<!--Organization yes or no-->
						<!--Organization Name-->
						<!--Organization License Number-->
						<!--Organization Address 1-->
						<!--Organization Address 2-->
						<!--Organization City-->
						<!--Organization State-->
						<!--Organization Zip-->
						<!--Organizaion Phone-->
						<!--End of Sign-up form-->

					</div>
				</div>
			</div>
		</main>
	</div><!--/.sfooter-content-->

	<!-- insert footer -->
	<?php require_once("lib/footer.php");?>
</body>
</html>