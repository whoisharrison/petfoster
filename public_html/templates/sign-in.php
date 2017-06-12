<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Sign In</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	  aria-hidden="true">
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
						<input type="email" required class="form-control" id="email" name="email" placeholder="Email">
					</div>
				</div>
				<!--User Name-->
				<div class="form-group">
					<label for="password">Password:<span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-paw" aria-hidden="true"></i>
						</div>
						<input type="password" required class="form-control" id="password" name="password"
								 placeholder="Password">
					</div>
				</div>

				<input type="submit" name="signin" id="signin" value="Sign In" class="btn btn-default" />



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

