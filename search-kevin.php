<!DOCTYPE html>
<?php 
// Cechi Shi
// CSE 154 Section AN
// Student #: 1238390
// 05/12/2014

// This is the result page of search collaboration movies with Kevin Bacon

// Import contents from common.php
include("common.php");
top();
$firstname = $_GET["firstname"];
$lastname = $_GET["lastname"];
$db = sql();
// Find user input's ID
$id = findID($db, $firstname, $lastname);
if ($id->rowCount() == 0) {
	// Display "Not found" if no such actor
	notFound($firstname, $lastname);
}
else {
	// Find Kevin Bacon's ID
	$kevin = findID($db, "Kevin", "Bacon");
	// Retrieve Kevin Bacon's ID
	$kevin_id = $kevin->fetch()["id"];
	// Retrieve target actor's ID
	$actor_id = $id->fetch()["id"];
	// Make comparison by joining two actors, two roles.
	// Find out shared rows (movies that Kevin Bacon and target actor collaborated)
	$rows = $db->query("SELECT name, year FROM movies m
						JOIN roles r1 ON r1.movie_id = m.id 
						JOIN roles r2 ON r2.movie_id = m.id
						JOIN actors kevin ON kevin.id = r1.actor_id 
						JOIN actors target ON target.id = r2.actor_id
						WHERE kevin.id = '{$kevin_id}'
						AND target.id = '{$actor_id}'
						AND r1.movie_id = r2.movie_id
						ORDER BY m.year DESC, m.name ASC");
	if ($rows->rowCount() == 0) {
		// Display "No match" if they have not collaborated
		noMatch($firstname, $lastname);
	}
	else {
		listResult($rows, $firstname, $lastname, TRUE);
	}
}
bottom();

// Accepts first name and last name of user input as parameters
// Prints out a message that the target user has not collaborated with Kevin Bacon
function noMatch($firstname, $lastname) {
?>
	<p><?= "$firstname $lastname" ?> wasn't in any films with Kevin Bacon.</p>
<?php
}
?>