<main>
	<div class="container" id="profilebkg">
		<div class="row">
			<div class="col-md-4">
				<h1 id="profilepage">Pet Rescue Abq</h1>

			</div>

			<div class="col-md-8">
				<h1 id="profileinfo">User Profile</h1>

				<!-- Begin Post Item -->
				<form class="form-horizontal">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="h4">Welcome <em>User</em>
								<small></small>
							</div>
						</div>

						<!--Name-->
						<div class="panel-body">
							<div class="form-group">
								<label for="inputName" class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="name" class="form-control" id="inputName" placeholder="Name" required [(ngModel)]="profile.profileName" #profileName="ngModel">
								</div>
							</div>
						</div>


						<!--At Handle-->
						<div class="panel-body">
							<div class="form-group">
								<label for="inputAtHandle" class="col-sm-2 control-label">User Name</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="profileAtHandle" placeholder="User Name" required [(ngModel)]="profile.profileAtHandle" #profileAtHandle="ngModel">
								</div>
							</div>
						</div>

						<!--email-->
						<div class="panel-body">
							<div class="form-group">
								<label for="profileEmail" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="profileEmail" placeholder="Email" required [(ngModel)]="profile.profileEmail" #profileEmail="ngModel">
								</div>
							</div>
						</div>

						<!--organization-->
						<div class="panel-body">
							<div class="form-group">
								<label for="organizationName" class="col-sm-2 control-label">Organization Name</label>
								<div class="col-sm-10">
									<input type="organizationName" class="form-control" id="organizationName" placeholder="Organization Name" required [(ngModel)]="organization.organizationName" #organizationName="ngModel">
								</div>
							</div>
						</div>

						<!--Phone-->
						<div class="panel-body">
							<div class="form-group">
								<label for="organizationPhone" class="col-sm-2 control-label">Phone</label>
								<div class="col-sm-10">
									<input type="phone" class="form-control" id="organizationPhone" placeholder="Phone" required [(ngModel)]="organization.organizationPhone" #organizationPhone="ngModel">
								</div>
							</div>
						</div>

						<!--Address1-->
						<div class="panel-body">
							<div class="form-group">
								<label for="organizationAddress1" class="col-sm-2 control-label">Address</label>
								<div class="col-sm-10">
									<input type="organizationAddress1" class="form-control" id="organizationAddress1" placeholder="Organization Address" required [(ngModel)]="organization.organizationAddress1" #organizationAddress1="ngModel">
								</div>
							</div>
						</div>

						<!--Address2-->
						<div class="panel-body">
							<div class="form-group">
								<label for="organizationAddress2" class="col-sm-2 control-label">Address</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="organizationAddress2" placeholder="Organization Address" required [(ngModel)]="organizationAddress2" #organizationAddress2="ngModel">
								</div>
							</div>
						</div>

						<!--City-->
						<div class="panel-body">
							<div class="form-group">
								<label for="organizationCity" class="col-sm-2 control-label">City</label>
								<div class="col-sm-10">
									<input type="Organization City" class="form-control" id="organizationCity" placeholder="City" required [(ngModel)]="organization.organizationCity" #organizationCity="ngModel">
								</div>
							</div>
						</div>

						<!--State-->
						<div class="panel-body">
							<div class="form-group">
								<label for="organizationState" class="col-sm-2 control-label">State</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="organizationState" placeholder="State" required [(ngModel)]="organization.organizationState" #ogranizationState="ngModel">
								</div>
							</div>
						</div>

						<!--Zip-->
						<div class="panel-body">
							<div class="form-group">
								<label for="organizationZip" class="col-sm-2 control-label">Zip</label>
								<div class="col-sm-10">
									<input type="organizationZip" class="form-control" id="organizationZip"
											 placeholder="Zip" required [(ngModel)]="organization.organizationZip" #organizationZip="ngModel">
								</div>
							</div>
						</div>

						<!--password update-->
						<div class="panel-body">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="inputPassword"
											 placeholder="Password" required [(ngModel)]="profile.profilePassword" #profilePassword="ngModel">
								</div>
							</div>
						</div>

						<!--confirm password update-->
						<div class="panel-body">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="inputPassword"
											 placeholder="Zip" required [(ngModel)]="profile.profilePasswordConfirm" #profilePasswordConfirm="ngModel">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" [disabled]="profileForm.invalid"class="btn btn-info">Update info</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>