<?php

session_start();

if(isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user
            WHERE id= {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>	Welcome HOME</title>
	<meta charset = "UTF-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

	<h1> Home </h1>

    <?php if(isset($user)) {

        echo "Hello " . htmlspecialchars($user["name"]);


       echo ("<p>You are logged in.</p>
            <p><a href='logout.php'>Logout</a></p>");

       

    }

 else {

       echo ("<p><a href='login.php'>Login Page</a> or <a href='signup.html'>Signup Page</a></p>");
    }
    ?>

</body>
</html>