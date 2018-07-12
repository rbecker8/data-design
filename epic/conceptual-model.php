<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Entities & Attributes</title>
		<link rel="stylesheet" href="./styles/styles.css">
		<body>
		<h1 class="main-title">Conceptual Model</h1>
		<p class="main-title">Game Reviewer</p>
			<ul class="center-list">
				<li>reviewerId (Primary Key)</li>
				<li>reviewerActivationToken (For Account Verification)</li>
				<li>reviewerNickName</li>
				<li>reviewerEmail</li>
				<li>reviewerHash (For Account Password)</li>
				<li>reviewDateId</li>
			</ul>
		<p class="main-title">Game Review</p>
		<ul class="center-list">
			<li>gameId (Primary Key)</li>
			<li>gameReviewConsoleId</li>
			<li>gameReviewReleaseId</li>
			<li></li>
			<li></li>
		</ul>
		<p>Relations</p>
			<ul>
				<li>One reviewer can review multiple games (1 to n)</li>
			</ul>
		<p class="main-title"><a href="index.php">Home</a></p>
		</body>
</html>