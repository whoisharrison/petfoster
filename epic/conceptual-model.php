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
			<li>profileAtHandle</li>
			<li>profileAuthToken</li>
			<li>profileEmail</li>
			<li>profileHash</li>
			<li>profileName</li>
			<li>profileSalt</li>
		</ul>

		<p><strong>Organization Profile</strong></p>
		<ul>
			<li>organizationId</li>
			<li>organizationAuthToken</li>
			<li>organizationEmail</li>
			<li>organizationLicence</li>
			<li>organizationName</li>
			<li>organizationPhone</li>
			<li>organizationProfileId</li>
		</ul>

		<p><strong>Post</strong></p>
		<ul>
			<li>postId</li>
			<li>OrganizationId</li>
			<li>postBreed</li>
			<li>postDescription</li>
			<li>postSex</li>
			<li>postType</li>
		</ul>

		<p><strong>Message</strong></p>
		<ul>
			<li>messageId</li>
			<li>messageDateTime</li>
			<li>messageOrganizationId</li>
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