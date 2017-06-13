<?php require_once("lib/head-utils.php"); ?>

<div class="sfooter-content">

	<!-- insert header and navbar -->
	<?php require_once("lib/header.php"); ?>

	<div class="container">
	<div class="row">
			<div class="col-md-4">
				<h1 id="profilepage">Pet Rescue Abq</h1>

			</div>

			<div class="col-md-8">
				<h1 id="profileinfo">Post a pet</h1>

				<!-- Begin Post Item -->
				<form class="form-horizontal" name="imageUpload" id="post" (submit)="uploadImage();">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="h4">Pet details</em>
								<small></small>
							</div>
						</div>

							<h1>Post</h1>
							<div class="form-group">
								<h4>Choose pet type</h4>
								<label class="radio-inline"><input type="radio" name="type"> Dog</label>
								<label class="radio-inline"><input type="radio" name="type"> Cat</label>
							</div>
							<div class="form-group">
								<h4>Choose the gender</h4>
								<label class="radio-inline"><input type="radio" name="gender"> Female</label>
								<label class="radio-inline"><input type="radio" name="gender"> Male</label>
							</div>
							<div class="form-group">
								<h4> Please enter the breed</h4>
								<label for="formGroupEnterBreed"></label>
								<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Breed Type">
							</div>
							<div class="form-group">
								<h4>Please enter pet description</h4>
								<label for="exampleTextarea"></label>
								<textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
							</div>
							<div>
								<label for="postImage" class="modal-labels">Upload an image</label>
								<input type="file" name="dog" id="dog" ng2FileSelect [uploader]="uploader"/>
							</div>
							<div class="form-group">
								<button type="submit" class="btn-link fa fa-paw fa-2x"><i class="fa fa-file-image-o" aria-hidden="true"></i>Submit</button>
							</div>
						</form>
						<p>Cloudinary Public Id: {{ cloudinaryPublicId }}</p>


					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- insert footer -->
	<?php require_once("lib/footer.php"); ?>
