<!DOCTYPE html>
<head>
	<title>Conceptual-Model</title>
</head>
<body>
	<main>
		<h2>Entities and Attributes</h2>

		<p><strong>Profile</strong></p>
		<ul>
			<li>profileId</li>
			<li>profileAuthToken</li>
			<li>profileName</li>
			<li>profileEmail</li>
			<li>profileAtHandle</li>
			<li>profileSalt</li>
			<li>profileHash</li>
		</ul>

		<p><strong>Organization Profile</strong></p>
		<ul>
			<li>organizationId</li>
			<li>organizationAuthToken</li>
			<li>organizationName</li>
			<li>organizationEmail</li>
			<li>organizationPhone</li>
			<li>organizationLicence</li>
			<li>organizationProfileId</li>
		</ul>

		<p><strong>Post</strong></p>
		<ul>
			<li>postOrganizationId</li>
			<li>postId</li>
			<li>postType</li>
			<li>postSex</li>
			<li>postBreed</li>
			<li>postDescription</li>
		</ul>

		<p><strong>Message</strong></p>
		<ul>
			<li>messageId</li>
			<li>messageDateTime</li>
			<li>messageOrgId</li>
			<li>messageProfileId</li>
			<li>messageContent</li>
			<li>messageSubject</li>
		</ul>

		<p><strong>Image</strong></p>
		<ul>
			<li>imageId</li>
			<li>imagePostId</li>
			<li>imageType</li>
			<li>imageCloudinaryrId</li>
		</ul>

		<p><strong>Relations</strong></p>
		<ul>

			<li>one organization to many posts</li>
			<li>many organizations/messages to many messages</li>
			<li>one post to many images</li>

		</ul><br>
		<h2>ERD Model:</h2>
		<img src="https://bootcamp-coders.cnm.edu/~mharrison13/petfoster/public_html/images/erd-pet.svg">
		<br>
	</main>

</body>