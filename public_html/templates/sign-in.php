
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header and navbar -->


		<!-- Large modal -->
		<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Sign In</button>

		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
			  aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!--Begin of Form-->
					<!--name-->



					<div class="container">

						<form #signInForm="ngForm" name="signInForm" id="signInForm"
								(ngSubmit)="signIn();">

							<div class="form-group">


								<label for="Email">Email:<span class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-paw" aria-hidden="true"></i>
									</div>
									<input type="email" required [(ngModel)]="signIn.profileEmail" #profileEmail="ngModel" class="form-control" 							id="email" name="email" placeholder="Email">
								</div>
							</div>
							<!--User Name-->
							<div class="form-group">
								<label for="password">Password:<span class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-paw" aria-hidden="true"></i>
									</div>
									<input type="password" required [(ngModel)]="signIn.profilePassword" #profilePassword="ngModel" class="form-control" 										id="password" name="password" placeholder="Password">
								</div>
							</div>

						<input type="submit" name="signin" id="signin" [disabled]="signInForm.invalid" value="Sign In" class="btn btn-default" />
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;    </button>



						<!--empty area for form error/success output-->

					</div>
				</div>
				<!-- End of Recaptcha & Form -->
			</div>
		</div>
	</div>


</body>

