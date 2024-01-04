<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oceans of Knowledge Vaccination Managament System</title>

    <!-- CSS only -->
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

        .bg {
            background-color: #06283D;
        }

        .form-group a {
            width: 50%;
            padding: 10px 24px;
            margin: auto;
            cursor: pointer;
            display: block;
        }

        .login {
            position: absolute;
            right: 10%;
            bottom: 15%;
            background: white;
            opacity: 80%;
            width: 400px;
            height: min-content;
            padding: 20px;
            margin: auto;
            border-radius: 15px;
            align-items: center;
            justify-content: center;
        }

        .login form {
            font-size: 20px;
        }

        .login h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .login p {
            color: #36454F;
        }

        .navbar {
            padding: 1px;
        }

        .navbar a {
            font-weight: 500;
        }

        .navbar img {
            height: 50px;
            width: auto;
            margin: 0 2px;
            padding-right: 4px;
        }

        .navbar .nav-item {
            margin-right: 135px;
            text-transform: uppercase;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        body {
            background-image: url('./assets/mat-napo-pIJ34ZrZEEw-unsplash.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }

        nav .nav-item a:hover {
            color: #47B5FF !important;
        }

        @media(max-width: 767px) {
            .ul-bg {
                background-color: #256D85;
            }   

            .login {
                position: absolute;
                bottom: 10%;
            }

            .navbar img {
                display: none;
            }
        }

    </style>

    <!-- Boxicons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md bg">
        <a href="index.php" class="navbar-brand fs-4 ms-2 text-white"><img src="assets/logo.png">Oceans of Knowledge High School</a>
    
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class='bx bx-menu bx-md'></i>
        </button>
        <div class="collapse navbar-collapse ul-bg" id="btn">
            <!-- <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="about.php" class="nav-link mx-3 text-white fs-6">About</a>
                </li>
                <li class="nav-item">
                    <a href="privacy.php" class="nav-link mx-3 text-white fs-6">Data Privacy</a>
                </li>
            </ul> -->
        </div>
    </nav>

    <!-- Redirect Buttons -->
    <div class="login">
        <h1 class="text-center">LOGIN</h1>
        <form>

            <p class="text-center">Are you a ... ?<p>
            
            <div class="form-group">
                <a class="btn btn-primary btn-lg mb-4" href="studentPortal.php" role="button">Student</a>
                <a class="btn btn-primary btn-lg mb-4" href="facultyPortal.php" role="button">Faculty</a>
                <a class="btn btn-primary btn-lg mb-4" href="adminPortal.php" role="button">Principal</a>
            </div>
            
            <p class="text-center">Don't have an account? <a style="text-decoration: none;" href="register.php">Register</a></p>

        </form>
    </div>
    
    <!-- Custom JS -->
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>