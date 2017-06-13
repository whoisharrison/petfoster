<?php require_once("lib/head-utils.php");?>
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header and navbar -->
		<?php require_once("lib/header.php");?>

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

							<input type="submit" name="signin" id="signin" value="Search" class="btn btn-default" />
							<input type="submit" name="signin" id="signin" value="Advanced" class="btn btn-default" />
						</div>
					</div>
				</div>
			</div>
		</main>
	</div><!--/.sfooter-content-->

	<!-- insert footer -->
	<?php require_once("lib/footer.php");?>
</body>
</html>