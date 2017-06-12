<?php require_once("lib/head-utils.php");?>
</head>
<body>
	<form id="post">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1>Post</h1>
					<h4>Choose pet type</h4>
					<fieldset id="type">
						<label class="radio-inline"><input type="radio" name="type"> Dog</label>
						<label class="radio-inline"><input type="radio" name="type"> Cat</label>
					</fieldset>
				</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h4>Choose the gender</h4>
					<fieldset id=sex">
						<label class="radio-inline"><input type="radio" name="gender"> Female</label>
						<label class="radio-inline"><input type="radio" name="gender"> Male</label>
						<fieldset>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<h4> Please enter the breed</h4>
						<label for="formGroupEnterBreed"></label>
						<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Breed Type">
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<h4>Please enter pet description</h4>
						<label for="exampleTextarea"></label>
						<textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="postImage" class="modal-labels">Upload an image</label>
						<input type="file" id="postImage" ng2FileSelect [uploader]="uploader" />
					</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<button type="submit" class="btn-link fa fa-paw fa-2x"> submit</button>
					</div>
				</div>
			</div>
		</div>
			</form>
</body>
</html>