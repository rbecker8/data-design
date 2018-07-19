<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Entities & Attributes</title>
		<link rel="stylesheet" href="./styles/styles.css">
		<body>
		<h1 class="main-title">Conceptual Model</h1>
		<p class="main-title">Reviewer</p>
			<ul class="center-list">
				<li>reviewerId (Primary Key)</li>
				<li>reviewerActivationToken (For Account Verification)</li>
				<li>reviewerNickName</li>
				<li>reviewerEmail</li>
				<li>reviewerHash (For Account Password)</li>
			</ul>
		<p class="main-title">Review</p>
		<ul class="center-list">
			<li>reviewId (Primary Key)</li>
			<li>reviewReviewerId (Foreign Key)</li>
			<li>reviewConsole</li>
			<li>reviewReleaseDate</li>
			<li>reviewRating</li>
			<li>reviewContent</li>
		</ul>
		<p>Relations</p>
			<ul>
				<li>One reviewer can review multiple games (1 to n)</li>
			</ul>
		<p>ERD</p>
		<p><img src="./ignerd.jpg" alt="image of ign erd" style="width:580px;height:280px;"> </p>
		<p class="main-title"><a href="index.php">Home</a></p>
		</body>
</html>