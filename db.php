<?php
// this file connects you to the database. like the router of your CRUD universe.
$host = 'localhost';
$user = 'root';
$pass = ''; // XAMPP default. don’t leave this empty on production tho.
$dbname = 'cruddy_notes';

// create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// check connection — if this fails, nothing works, so let’s scream a little.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
