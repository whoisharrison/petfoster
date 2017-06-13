<?php require_once("lib/head-utils.php"); ?>
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header and navbar -->
		<?php require_once("lib/header.php"); ?>

		<main class="bg p-t-nav">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-4">
						<div class="jumbotron text-right">
							<h1>Pet Rescue ABQ</h1>
							<p class="lead">Fosters Save Lives!</p>
							<!--User Name-->
							<div class="form-group">
								<label for="search">Pet Finder:<span class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-paw" aria-hidden="true"></i>
									</div>
									<input type="search" required class="form-control" id="search" name="search"
											 placeholder="search">
								</div>
							</div>
							<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Advanced
							</button>
							<div id="demo" class="collapse">
								<form class="form-horizontal" name="imageUpload" id="post" (submit)="uploadImage();">
									<div class="container">
										<div class="row">
											<!-- type -->
											<br>
											<h4>Cat or Dog?</h4>

												<fieldset id="type">
													<label class="radio-inline"><input type="radio" name="type"> Dog</label>
													<label class="radio-inline"><input type="radio" name="type"> Cat</label>
												</fieldset>

										</div>
									</div>
									<div class="container">
										<div class="row">
											<!-- gender -->

												<h4>Choose the gender</h4>
												<fieldset id=sex">
													<label class="radio-inline"><input type="radio" name="gender"> Female</label>
													<label class="radio-inline"><input type="radio" name="gender"> Male</label>
													<fieldset>

										</div>
									</div>
									<div class="container">
										<div class="row">
											<!-- breed -->
												<div class="form-group">
													<h4> Please enter the breed</h4>
													<label for="formGroupEnterBreed"></label>
													<input type="text" class="form-control" id="formGroupExampleInput"
															 placeholder="Breed Type">
												</div>

										</div>
									</div>
								</form>
							</div>
							<!--end of advanced search-->
							<input type="submit" name="signin" id="signin" value="Search" class="btn btn-default"/>

						</div>
					</div>
				</div>
			</div>
		</main>
	</div><!--/.sfooter-content-->

	<!-- insert footer -->
	<?php require_once("lib/footer.php"); ?>
</body>
</html>