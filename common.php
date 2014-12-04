<?php 
// Cechi Shi
// CSE 154 Section AN
// Student #: 1238390
// 05/12/2014

// This is the page that stores all the contents that different pages share

// Sets the attributes of web pages of the website
// Including title, favicon, CSS file etc.
function attributes() {
?>
	<title>My Movie Database (MyMDb)</title>
	<meta charset="utf-8" />
	<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

	<!-- Link to your CSS file that you should edit -->
	<link href="bacon.css" type="text/css" rel="stylesheet" />
<?php 
}
// Displays a banner on the top of any pages
function banner() {
?>
	<div id="banner">
		<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
		My Movie Database
	</div>
<?php 
}
// Displays the search boxes of the web pages
function searchboxes() {
?>
	<!-- form to search for every movie by a given actor -->
	<form action="search-all.php" method="get">
		<fieldset>
			<legend>All movies</legend>
			<div>
				<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
				<input name="lastname" type="text" size="12" placeholder="last name" /> 
				<input type="submit" value="go" />
			</div>
		</fieldset>
	</form>

	<!-- form to search for movies where a given actor was with Kevin Bacon -->
	<form action="search-kevin.php" method="get">
		<fieldset>
			<legend>Movies with Kevin Bacon</legend>
			<div>
				<input name="firstname" type="text" size="12" placeholder="first name" /> 
				<input name="lastname" type="text" size="12" placeholder="last name" /> 
				<input type="submit" value="go" />
			</div>
		</fieldset>
	</form>
<?php 
}
// Displays the validators of web pages
function validators() {
?>
	<div id="w3c">
		<a href="https://webster.cs.washington.edu/validate-html.php">
			<img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" />
		</a>
		<a href="https://webster.cs.washington.edu/validate-css.php">
			<img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" />
		</a>
	</div>
<?php 
}
// The whole upper part of the web pages
function top() {
	?>
	<html>
		<head>
			<?php attributes(); ?>
		</head>
		<body>
			<div id="frame">
				<?php banner();
?>
				<div id="main">
<?php
}
// The whole bottom part of the web pages
function bottom() {
?>
				<?php searchboxes(); ?>
			</div> <!-- end of #main div -->
			<?php validators();	?>
		</div> <!-- end of #frame div -->
	</body>
</html>
<?php 
}
// Creates a database and returns it
function sql() {
	$db = new PDO("mysql:dbname=imdb", "cechishi", "JC4UtOONOq");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}
// Creates a query that finds the actor ID in the database and returns
// the query. The query should be size 1.
function findID($db, $firstname, $lastname) {
	$id = $db->query("SELECT id FROM actors 
				  WHERE (last_name = '{$lastname}') AND (first_name LIKE '{$firstname}%') 
				  ORDER BY film_count DESC, id ASC 
				  LIMIT 1");
	return $id;
}
// Accepts the first name and last name of the user input
// Displays a message saying the actor is not found in the database.
function notFound($firstname, $lastname) {
?>
	<p>Actor <?= "$firstname $lastname" ?> not found.</p>
<?php
}
// Accepts a query of rows, the first name and last name of user input,
// and whether the request page is search-kevin.php as parameters.
// Displays all movies in the query in a table.
function listResult($rows, $firstname, $lastname, $isKevin) {
?>
	<h1>Results for <?= "$firstname $lastname" ?></h1>
	<table>
	<?php 
	// Caption changes on different requesting page
	if ($isKevin) {
	?>
		<caption>Films with <?= "$firstname $lastname" ?> and Kevin Bacon</caption>
	<?php 
	}
	else {
	?>
		<caption>All Films</caption>
	<?php
	}
	?>
		<tr><th>#</th><th>Title</th><th>Year</th></tr>
<?php
	// Set up a counter for # column
	$count = 1;
	foreach ($rows as $row) {
		// Set the row with attribute "stripe" if the number is even (for CSS use)
		if ($count % 2 != 0) {
?>
			<tr class="stripe"><td><?= $count ?></td><td id="title"><?= $row["name"] ?></td><td><?= $row["year"] ?></td></tr>
<?php
		}
		else {
?>
			<tr><td><?= $count ?></td><td class="title"><?= $row["name"] ?></td><td><?= $row["year"] ?></td></tr>
<?php
		}
		$count++;
	}
?>
	</table>
<?php
}
?>
