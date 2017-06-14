<main class="bg">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1 id="profilepage">Profile Information <button class="btn btn-info pull-right" role="button" data-toggle="collapse" href="#updateProfile" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>&nbsp;Update Profile</button></h1>
				<hr>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-6">
				<div class="well">
					<table class="table table-condensed">
						<tr>
							<td>
								<strong class="text-info">User Name</strong>
							</td>
							<td>username here</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">Email</strong>
							</td>
							<td>email here</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">@handle</strong>
							</td>
							<td>@handle here</td>
						</tr>
					</table>
				</div><!--/.well-->

				<div class="well">
					<table class="table table-condensed">
						<tr>
							<td>
								<strong class="text-info">Organiztion Name</strong>
							</td>
							<td>org here</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">Org Email</strong>
							</td>
							<td>org email here</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">Address 1</strong>
							</td>
							<td>address 1</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">Address 2</strong>
							</td>
							<td>address 2</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">City</strong>
							</td>
							<td>org city here</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">State</strong>
							</td>
							<td>org state</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">Zip</strong>
							</td>
							<td>org zip</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">Phone</strong>
							</td>
							<td>org phone</td>
						</tr>
						<tr>
							<td>
								<strong class="text-info">License</strong>
							</td>
							<td>org license no</td>
						</tr>
					</table>
				</div>
			</div><!--/.col-sm-6-->
			<div class="col-sm-6">
				<div class="collapse" id="updateProfile">
					<div class="panel panel-default">
						<div class="panel-body">
							<form #profileForm="ngForm" name="profileForm" id="profileForm"
									(ngSubmit)="putProfile();" novalidate>
								<div class="form-group">
									<label for="name" class=" control-label">Name</label>
									<input type="text" class="form-control" id="profileName"
											 placeholder="profileName" [(ngModel)]="profile.profileName"
											 #profileName="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class=" control-label">Handle</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="profileAtHandle" [(ngModel)]="profile.profileAtHandle"
											 #profileAtHandle="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp3" class=" control-label">Email</label>
									<input type="email" class="form-control" id="SignUp3"
											 placeholder="profileEmail" [(ngModel)]="profile.Email"
											 #profileEmail="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class="control-label">Organization</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="organizationName" [(ngModel)]="organization.organizationName"
											 #profileType="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class="control-label">State</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="organizationPhone" [(ngModel)]="organization.organizationPhone"
											 #organizationPhone="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class="control-label">Address</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="organizationAddress1" [(ngModel)]="organization.organizationAddress1"
											 #organizationAddress="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class="control-label">Address</label>
									<input type="text" class="form-control" id=""
											 placeholder="organizationAddress2" [(ngModel)]="organization.organizationAddress2"
											 #organizationAddress2="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class=" control-label">City</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="organizationCity" [(ngModel)]="organization.organizationCity"
											 #organizationCity="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class=" control-label">State</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="organizationState" [(ngModel)]="organization.organizationState"
											 #organizationState="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp" class=" control-label">Zip</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="organizationZip" [(ngModel)]="organization.organizationZip"
											 #organizationZip="ngModel">
								</div>

								<div class="form-group">
									<label for="inputPassword" class=" control-label">Password</label>
									<input type="password" class="form-control" id="profilePasswordConfirm"
											 placeholder="Password" [(ngModel)]="organization.organizationPassword"
											 #password="ngModel">
								</div>

								<div class="form-group">
									<label for="inputPassword" class=" control-label">Confirm Password</label>
									<input type="password" class="form-control" id="profilePassword" placeholder="Password"
											 [(ngModel)]="organization.organizationPassword"
											 #password="ngModel">
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-info">Update info</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div><!--/.col-sm-6-->
		</div><!--/.row-->
	</div><!--/.container-->
</main>