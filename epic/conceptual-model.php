<!DOCTYPE html>
<head>
	<title>Conceptual-Model</title>
</head>
<body>
	<main>
		<h2>Entities and Attributes</h2>

		<p><strong>Profile</strong></p>
		<ul>
			<li>ProfileId</li>
			<li>ProfileAuthToken</li>
			<li>ProfileName</li>
			<li>ProfileEmail</li>
			<li>ProfileAtHandle</li>
			<li>ProfileSalt</li>
			<li>ProfileHash</li>
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

		<p><strong>post</strong></p>
		<ul>
			<li>organizationPostId</li>
			<li>postId</li>
			<li>postType</li>
			<li>postSex</li>
			<li>postBreed</li>
			<li>postDescription</li>
		</ul>

		<p><strong>message</strong></p>
		<ul>
			<li>messageId</li>
			<li>messageDate</li>
			<li>messageOrgId</li>
			<li>messageUserId</li>
			<li>messageContent</li>
			<li>messageSubject</li>
		</ul>

		<p><strong>image</strong></p>
		<ul>
			<li>imageId</li>
			<li>imagePostId</li>
			<li>imageType</li>
			<li>imageCloudinaryrId</li>
		</ul>

		<p><strong>Relations</strong></p>
		<ul>
			<li>Many <strong>orgProfile </strong>to many posts (m to n)</li>
			<li>Many <strong>orgProfile </strong>to many messages (m to n)</li>
			<li>Many <strong>usersProfile </strong>message many orgProfile - (m to n)</li>
			<li>One <strong>post </strong>to many Images - (1 to n)</li>
		</ul><br>
		<h2>ERD Model:</h2>
		<img src="https://bootcamp-coders.cnm.edu/~mharrison13/petfoster/public_html/images/erd-pet.svg">
		<br>
	</main>
</body>