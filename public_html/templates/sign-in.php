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

		<form #signInForm="ngForm" name="signInForm" id="signInForm"
				(ngSubmit)="signIn();">

			<div class="modal-body">
				<div class="container">
					<h2 align="center">Authentication</h2>
					<div class="center">
						<form method="post" action="/signin" class="form-horizontal" role="form" align="center">
							<div class="form-group" align="center">
								<label class="control-label col-sm-2" for="email">Email:<em>*</em></label>
								<div class="col-sm-6">

									<!--										how do I add org into here??-->
									<input type="text" name="email" id="email" placeholder="email" required [(ngModel)]="signIn.profileEmail" #profileEmail="ngModel" class="form-control" />

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="password">Password:<em>*</em></label>
								<div class="col-sm-6">

									<input type="password" name="password" id="password" required [(ngModel)]="signIn.profilePassword" #profilePassword="ngModel" class="form-control" />

								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-8">
									<input type="submit" name="signin" id="signin" [disabled]="signInForm.invalid" value="Sign In" class="btn btn-default" />
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





<!-- Large modal -->
<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">


			<form method="post" action="/signin" class="form-horizontal" role="form" align="center">
				<div class="form-group" align="center">
					<label class="control-label col-sm-2" for="email">Email:<em>*</em></label>
					<div class="col-sm-6">

						<!--										how do I add org into here??-->
						<input type="text" name="email" id="email" placeholder="email" required [(ngModel)]="signIn.profileEmail" #profileEmail="ngModel" class="form-control" />

					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="password">Password:<em>*</em></label>
					<div class="col-sm-6">

						<input type="password" name="password" id="password" required [(ngModel)]="signIn.profilePassword" #profilePassword="ngModel" class="form-control" />

					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
						<input type="submit" name="signin" id="signin" [disabled]="signInForm.invalid" value="Sign In" class="btn btn-default" />
					</div>
				</div>
			</form>








		</div>
	</div>
</div>