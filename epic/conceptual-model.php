<!DOCTYPE html>
<head>
	<title>Conceptual-Model</title>
</head>
<body>
	<main>
		<h2>Entities and Attributes</h2>

		<p><strong>Org Profile</strong></p>
		<ul>
			<li>orgId</li>
			<li>orgAuthToken</li>
			<li>orgName</li>
			<li>orgEmail</li>
			<li>orgPhone</li>
			<li>orgLicence</li>
			<li>orgOwnerProfileId</li>
		</ul>

		<p><strong>User Profile</strong></p>
		<ul>
			<li>userId</li>
			<li>userAuthToken</li>
			<li>userName</li>
			<li>userEmail</li>
			<li>userAtHandle</li>
			<li>userSalt</li>
			<li>userHash</li>
		</ul>

		<p><strong>post</strong></p>
		<ul>
			<li>orgPostId</li>
			<li>postId</li>
			<li>postType</li>
			<li>postSex</li>
			<li>postBreed</li>
			<li>postDescription</li>
		</ul>

		<p><strong>image</strong></p>
		<ul>
			<li>messageId</li>
			<li>messageDate</li>
			<li>messageOrgId</li>
			<li>messageUserId</li>
			<li>messageContent</li>
			<li>messageSubject</li>
		</ul>

		<p><strong>message</strong></p>
		<ul>
			<li>imageId</li>
			<li>imagePostId</li>
			<li>imageType</li>
		</ul>

		<p><strong>Relations</strong></p>
		<ul>
			<li>Many <strong>orgProfile </strong>to many posts (m to n)</li>
			<li>Many <strong>orgProfile </strong>to many messages (m to n)</li>
			<li>Many <strong>usersProfile </strong>message many orgProfile - (m to n)</li>
			<li>One <strong>post </strong>to many Images - (1 to n)</li>
		</ul>
		<img src="https://bootcamp-coders.cnm.edu/~mharrison13/petfoster/public_html/images/erd-pet.svg">
		<br>
	</main>
</body>