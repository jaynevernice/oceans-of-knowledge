<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

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
            margin-top: 15%;
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
        <div class="row mx-4 mt-4 p-3">
            <a href="index.php">
                <img src="assets/logo.png" alt="">
            </a>
        </div>

        <div class="row mx-4 mt-1 text-center">
            <h3>USER | PASSWORD RESET</h3>
        </div>

        <form action="forgotPassProcess.php" method="post">
            <div class="row mx-4 mt-2 p-3 justify-content-md-center">
                <div class="col-md-7">
                    <input type="email" name="email" placeholder="Email address" class="form-control">
                </div>
                <div class="col-auto mb-4">
                    <button type="submit" class="btn btn-primary" name="reset">Reset</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>