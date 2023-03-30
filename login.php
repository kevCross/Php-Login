<?php
    $is_invalid = false;

    if($_SERVER["REQUEST_METHOD"] === "POST") {

        $mysqli = require __DIR__ . "/database.php";

        $sql = sprintf("SELECT * FROM user
                        WHERE email = '%s' ",
                        $mysqli-> real_escape_string($_POST["email"]));

        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        if($user) {

            if(password_verify($_POST["password"], $user["password_hash"])) {

                session_start();

                session_regenerate_id();

                $_SESSION["user_id"] = $user["id"];

                header("Location: index.php");
                exit;
            }
        }
        $is_invalid = true;
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>	Log in Page</title>
	<meta charset = "UTF-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

	<h1> Log in </h1>

    <?php if ($is_invalid) : ?>

            <p><em>Invalid Login</em></p>

    <?php endif; ?>

    

    <form method = "post">
        <label for = "email">E-MAIL</label>
        <input type = "email" name = "email" id = "email" placeholder="youremail@example.com">
        <label for = "password">PASSWORD</label>
        <input type ="password" name = "password" id = "password" placeholder="********">

        <button>Log in</button>
    </form>

    <style rel = "stylesheet">
        em {
            color:#FE5A36;
            font-weight:900;
           


        }

        h1 {
            text-transform: capitalize;

        }
    </style>
</body>
</html>