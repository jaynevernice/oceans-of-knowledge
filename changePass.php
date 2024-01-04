<?php 
    include_once 'changePassProcess.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- Website Logo -->
    <link rel="icon" href="assets/logo.png">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'IBM Plex Sans', sans-serif;
        }

        body {
            background-color: #06283D;
        }

        .container {
            background-color: white;
            width: 50%;
            margin: auto;
            margin-top: 10%;
        }

        .container img {
            height: 70px;
            width: auto;
            display: block;
            margin: auto;
            filter: drop-shadow(2px 2px 2px black);
        }

        .container h3 {
            font-weight: 600;
        }

    </style>  

</head>
<body>
    <div class="container">
        <div class="row mx-4 p-3">
            <a href="index.php">
                <img src="assets/logo.png" alt="">
            </a>
        </div>
        <h1 class="text-center mx-2 p-3">CHANGE PASSWORD</h1>
        <form action="" method="post">
            <div class="row mb-4 justify-content-md-center">
                <label for="inputEmail" class="col-4 col-form-label">Email</label>
                <div class="col-lg-auto">
                    <input type="email" name="email" id="inputEmail" class="form-control" required>
                </div>
            </div>
            <div class="row mb-4 justify-content-md-center">
                <label for="inputPassword" class="col-4 col-form-label">New Password</label>
                <div class="col-lg-auto">
                    <input type="password" name="new_password" id="inputPassword" class="form-control" required>
                </div>
            </div>
            <div class="row mb-4 justify-content-md-center text-center">
                <div class="col-8 mb-4">
                    <button type="submit" class="btn btn-primary" name="change">Change</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>