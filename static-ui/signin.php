<h2>Pet Rescue ABQ Sign In</h2>

<!-- Trigger/Open The Modal -->
<button id="myBtn">Hey! Sign In!</button>

<!-- The Modal -->
<div id="myModal" class="modal">

	<!-- Modal content -->
	<div class="modal-content">
		<div class="modal-header">
			<span class="close">&times;</span>
			<h2>Pet Resecue ABQ Header</h2>
		</div>
		<div class="modal-body">


			<div class="container">
				<h2 align="center">Authentication</h2>
				<div class="center">
					<form method="post" action="/signin" class="form-horizontal" role="form" align="center">
						<div class="form-group" align="center">
							<label class="control-label col-sm-2" for="username">Username:<em>*</em></label>
							<div class="col-sm-6">
								<input type="text" name="username" id="username" placeholder="username" required="true" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="password">Password:<em>*</em></label>
							<div class="col-sm-6">
								<input type="password" name="password" id="password" required="true" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-8">
								<input type="submit" name="signin" id="signin" value="Sign In" class="btn btn-default" />
							</div>
						</div>
					</form>
				</div>
			</div>



		</div>
		<div class="modal-footer">
			<h3>Footer</h3>
		</div>
	</div>

</div>