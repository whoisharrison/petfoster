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
			<li>profileEmail</li>
			<li>profilePhone</li>
		</ul>
		<p><strong>Pet Profile</strong></p>
		<ul>
			<li>petId</li>
			<li>petProfileId</li>
			<li>petDescription</li>
			<li>petType</li>
			<li>petBreed</li>
			<li>PetLocation</li>
		</ul>

		<p><strong>images</strong></p>
		<ul>
			<li>petProfileImage</li>
		</ul>
		<p><strong>Relations</strong></p>
		<ul>
			<li>One <strong>Profile </strong>favorites products - (m to n)</li>
		</ul>
		<br>
		<img src="https://bootcamp-coders.cnm.edu/~mharrison13/data-design/public_html/images/erd-data-design.svg">
	</main>
</body>