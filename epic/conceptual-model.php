<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Entities & Attributes</title>
		<link rel="stylesheet" href="./styles/styles.css">
		<body>
		<h1 class="main-title">Conceptual Model</h1>
		<p class="main-title">Game</p>
			<ul class="center-list">
				<li>gameId (Primary Key)</li>
				<li>gameConsoleId</li>
				<li>gameReleaseId</li>
			</ul>
		<p class="main-title">Game Reviewer</p>
			<ul class="center-list">
				<li>reviewerId (Primary Key)</li>
				<li>reviewDateId</li>
			</ul>
		<p>Relations</p>
			<ul>
				<li>One reviewer can review multiple games (1 to n)</li>
				<li>One game is reviewed by one reviewer (1 to 1)</li>
			</ul>
		<p class="main-title"><a href="index.php">Home</a></p>
		</body>
</html>