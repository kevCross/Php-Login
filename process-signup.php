<?php

if (empty($_POST["name"])) {
	die("Name is required");
}
if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
	die("Valid E-Mail is required");
}

if (strlen($_POST["password"]) < 8) {
	die("Password must be at least 8 characters");
}

if (! preg_match("/[a-z]/i", $_POST["password"])) {
	die("Password must have at least one letter");
}

if (! preg_match("/[0-9]/i", $_POST["password"])) {
	die("Password must have at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]){
	die("Passwords must match");
}

$mysqli = require __DIR__. "/database.php";

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "INSERT INTO user (name, email, password_hash)
		VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if(! $stmt->prepare($sql)){
	die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
					$_POST["name"],
					$_POST["email"],
					$password_hash);

if($stmt->execute()) {
	
	header("Location: signup-success.html");
	exit;

} else {
	if ($mysqli->errno === 1062) {
		die("email already taken");
	} else {
		die($mysqli->error . "" . $mysqli->errno);
	}
}

?>