<?php require_once("lib/head-utils.php"); ?>
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header and navbar -->
		<?php require_once("lib/header.php"); ?>

		<!-- Large modal -->
		<!-- Large modal -->
		<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!--Begin of Form-->
					<!--name-->
					<div class="container">
						<div class="form-group">
							<label for="Email">Email:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-paw" aria-hidden="true"></i>
								</div>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email">
							</div>
						</div>
						<!--User Name-->
						<div class="form-group">
							<label for="password">Password:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-paw" aria-hidden="true"></i>
								</div>
								<input type="password" class="form-control" id="password" name="password"
										 placeholder="User Name">
							</div>
						</div>

						<input type="submit" name="signin" id="signin" value="Sign In" class="btn btn-default" />

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

<!--<!-- Trigger/Open The Modal -->
<!--<button id="myBtn">Hey! Sign In!</button>-->
<!---->
<!--<!-- The Modal -->
<!--<div id="myModal" class="modal">-->
<!---->
<!--	<!-- Modal content -->
<!--	<div class="modal-content">-->
<!--		<div class="modal-header">-->
<!--			<span class="close">&times;</span>-->
<!--			<h2>Pet Resecue ABQ Header</h2>-->
<!--		</div>-->
<!--		<div class="modal-body">-->
<!---->
<!---->
<!--			<div class="container">-->
<!--				<h2 align="center">Authentication</h2>-->
<!--				<div class="center">-->
<!--					<form method="post" action="/signin" class="form-horizontal" role="form" align="center">-->
<!--						<div class="form-group" align="center">-->
<!--							<label class="control-label col-sm-2" for="username">Username:<em>*</em></label>-->
<!--							<div class="col-sm-6">-->
<!--								<input type="text" name="username" id="username" placeholder="username" required="true" class="form-control" />-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							<label class="control-label col-sm-2" for="password">Password:<em>*</em></label>-->
<!--							<div class="col-sm-6">-->
<!--								<input type="password" name="password" id="password" required="true" class="form-control" />-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							<div class="col-sm-offset-2 col-sm-8">-->
<!--								<input type="submit" name="signin" id="signin" value="Sign In" class="btn btn-default" />-->
<!--							</div>-->
<!--						</div>-->
<!--					</form>-->
<!--				</div>-->
<!--			</div>-->
<!---->
<!---->
<!---->
<!--		</div>-->
<!--		<div class="modal-footer">-->
<!--			<h3>Footer</h3>-->
<!--		</div>-->
<!--	</div>-->
<!---->
<!--</div>-->