<?php

	include_once 'dbh.php';
    session_start();

	$result = $conn->query("SELECT * FROM login");

	if(isset($_POST['submit'])) {

		$email = $_POST['email'];
		$password = md5($_POST['password']);

		$result = $conn->query("SELECT * FROM login WHERE email='$email' AND password='$password'");

		$row=mysqli_fetch_array($result);

		if ($row["role"]=="Principal") {
			
            $_SESSION['user_id'] = $row['id'];

			header("Location: adminDashboard.php");

		} else {
			header("Location: index.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Portal</title>

    <!-- Style -->
    <link rel="stylesheet" href="style.css">

    <style>
        .pass a{
            text-decoration: none;
        }
    </style>

    <!-- Website Logo -->
    <link rel="icon" href="assets/logo.png">

</head>
<body>

    <div>
        <!-- Logo -->
        <div class="logo">
            <a href="index.php"><img src="assets\logo.png" alt=""></a>
        </div>

        <div class="portal">
            <h1>PRINCIPAL | PORTAL</h1>
            <form method="POST">
                <!-- Prompt user to enter Email -->
                <div class="field">
                    <input id="email" name="email" type="email" required>
                    <span></span>
                    <label>Email</label>
                </div>
                <!-- Prompt user to enter Password -->
                <div class="field">
                    <input id="password" name="password" type="password" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <!-- Forgot Password & Login -->
                <div class="pass">
                    <a href="forgotPass.php">Forgot Password?</a>
                </div>
                <input name="submit" type="submit" value="LOGIN">
                <div class="register"></div>
            </form>
        </div>
    </div>
</body>
</html>