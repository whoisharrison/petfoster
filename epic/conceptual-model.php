<!DOCTYPE html>
<head>
	<title>Conceptual-Model</title>
</head>
<body>
	<main>
		<h2>Entities and Attributes</h2>

		<p><strong>Profile</strong></p>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileActivationToken (for account verification)</li>
			<li>profileAtHandle</li>
			<li>profileEmail</li>
			<li>profileHash (for account password)</li>
			<li>profileName</li>
			<li>profileSalt (for account password)</li>
		</ul>

		<p><strong>Organization</strong></p>
		<ul>
			<li>organizationId (primary key)</li>
			<li>organizationProfileId (foreign key)</li>
			<li>organizationActivationToken (for account verification)</li>
			<li>organizationAddress1</li>
			<li>organizationAddress2</li>
			<li>organizationCity</li>
			<li>organizationEmail</li>
			<li>organizationLicense</li>
			<li>organizationName</li>
			<li>organizationPhone</li>
			<li>organizationState</li>
			<li>organizationZip</li>
		</ul>

		<p><strong>Post</strong></p>
		<ul>
			<li>postId (primary key)</li>
			<li>postOrganizationId (foreign key)</li>
			<li>postBreed</li>
			<li>postDescription</li>
			<li>postSex</li>
			<li>postType</li>
		</ul>

		<p><strong>Message</strong></p>
		<ul>
			<li>messageId (primary key)</li>
			<li>messageOrganizationId (foreign key)</li>
			<li>messageProfileId (foreign key)</li>
			<li>messageContent</li>
			<li>messageDateTime</li>
			<li>messageSubject</li>
		</ul>

		<p><strong>Image</strong></p>
		<ul>
			<li>imageId (primary key)</li>
			<li>imagePostId (foreign key)</li>
			<li>imageCloudinaryId (public key)</li>
		</ul>

		<p><strong>Relations</strong></p>
		<ul>

			<li>one <strong>organization</strong> to many <strong>posts</strong></li>
			<li>many <strong>organizations/profiles</strong> to many <strong>messages</strong></li>
			<li>one <strong>post</strong> to many <strong>images</strong></li>

		</ul><br>
		<h2>ERD Model:</h2>
		<img src="https://bootcamp-coders.cnm.edu/~mharrison13/petfoster/public_html/images/erd-pet.svg">
		<br>
	</main>
</body>