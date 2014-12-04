<!DOCTYPE html>
<?php 
// Cechi Shi
// CSE 154 Section AN
// Student #: 1238390
// 05/12/2014

// This is the result page of search all movies

// Import contents from common.php
include("common.php");
top();
$firstname = $_GET["firstname"];
$lastname = $_GET["lastname"];
// Retrieve the database
$db = sql();
// Find the ID of user's input
$id = findID($db, $firstname, $lastname);
if ($id->rowCount() == 0) {
	// Display "Not found" if there's no such actor
	notFound($firstname, $lastname);
}
else {
	// Fetch the only row's ID for further use
	$actor_id = $id->fetch()["id"];
	// Glue movies and actors by roles and select all movies that
	// the actor has participated
	$rows = $db->query("SELECT name, year FROM movies m 
						JOIN roles r ON r.movie_id = m.id 
						JOIN actors a ON a.id = r.actor_id 
						WHERE a.id = '{$actor_id}' 
						ORDER BY m.year DESC, m.name ASC");
	// List results that matches the actor
	listResult($rows, $firstname, $lastname, FALSE);
}
bottom();
?>