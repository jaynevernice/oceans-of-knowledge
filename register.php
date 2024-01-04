<?php
    include_once 'dbh.php';
    session_start();
 
    if(isset($_POST['submit'])) {
 
        $givenName = $_POST['givenName'];
        $mi = $_POST['mi'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $confPass = md5($_POST['confPass']);
        $role = $_POST['role'];
        $gradeLevel = $_POST['gradeLevel'];
        $section = $_POST['section'];
 
        $select = "SELECT * FROM login WHERE email = '$email' AND password = '$password' ";
        $result = mysqli_query($conn, $select);
 
        if(mysqli_num_rows($result) > 0){

            $_SESSION['status'] = "This user already exists! Please try another one.";
            $_SESSION['status_code'] = "warning";
 
        } else {
 
            if($password != $confPass) {

                $_SESSION['status'] = "The passwords you have entered did not match. Please try again.";
                $_SESSION['status_code'] = "error";

            } else {

                $insert = "INSERT INTO login (givenName, mi, surname, email, password, role, gradeLevel, section, suffix) values('$givenName','$mi','$surname','$email','$password','$role','$gradeLevel', '$section', ";

                if(isset($_POST['suffix'])){

                    $suffix = $_POST['suffix'];
                    $insert .= "'$suffix')";

                } else { $insert .= "NULL)" ; }

                mysqli_query($conn, $insert);

                $_SESSION['status'] = "You have registered successfully.";
                $_SESSION['status_code'] = "success";
                
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Font Awesome CDN Links -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' rel='stylesheet'>

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
        }

        .container img {
            height: 70px;
            width: auto;
            display: block;
            margin: auto;
            filter: drop-shadow(2px 2px 2px black);
        }

        .form {
            margin: 6% auto;
            padding: 15px 30px;
        }

        .form h3 {
            text-align: center;
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .form button {
            width: 50%;
            margin: auto;
        }

    </style>    
</head>
<body>
    <div class="container">

        <form class="form" method="POST">
            <div class="row">
                <a href="index.php">
                    <img src="assets/logo.png" alt="">
                </a>
            </div>

            <div class="row">
                <h3>USER | REGISTRATION</h3>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <input name="givenName" type="text" class="form-control" placeholder="Given Name" required>
                </div>
                <div class="col mb-3">
                    <input name="mi" type="text" class="form-control" placeholder="M.I" required>
                </div>
                <div class="col-md-4 mb-3">
                    <input name="surname" type="text" class="form-control" placeholder="Surname" required>
                </div>
                <div class="col mb-3">
                    <input name="suffix" type="text" class="form-control" placeholder="Suffix">
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3">
                    <input name="email" type="email" class="form-control" placeholder="Enter Email">
                </div>
            </div>

            <!-- Password -->
            <div class="row">
                <div class="form-group mb-3">
                    <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password">
                </div>
            </div>
            <!-- Confirm Password -->
            <div class="row">
                <div class="form-group mb-3">
                    <input id="confPass" name="confPass" type="password" class="form-control" placeholder="Confirm Password">
                </div>
            </div>

            <div class="row">

                <!-- Role -->
                <div class="form-group col-md-3">
                    <select required name="role" id="role" class="form-select">
                        <option value="" selected disabled>Role</option>
                        <option value="Student">Student</option>
                        <option value="Faculty">Faculty</option>
                    </select>
                </div>

                <!-- Dropdown -->
                <div class="form-group col-md-4">
                    <select name="gradeLevel" id="gradeLevel" class="form-select">
                        <option selected disabled>Grade Level</option>
                        <option value="Grade 07">Grade 07</option>
                        <option value="Grade 08">Grade 08</option>
                        <option value="Grade 09">Grade 09</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <select name="section" id="section" class="form-select">
                        <option selected disabled>Section</option>
                        <option value="Section 1">Section 1</option>
                        <option value="Section 2">Section 2</option>
                    </select>
                </div> 

                <!-- Terms and Condition -->
                <div class="form-group my-3 d-flex justify-content-center">
                    <div class="form-check text-center">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">Agree to terms and conditions</label>
                    </div>
                </div>
                <button name="submit" class="btn btn-primary" type="submit">REGISTER</button>
                <div class="text-center p-2">
                    Already have an account? <a href="index.php">Login</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] != '' ) { ?>
        <script>
            swal({
                title: "<?php echo $_SESSION['status']; ?>",
                icon: "<?php echo $_SESSION['status_code'];?>",
                button: "Okay",
            });
        </script>
    <?php unset($_SESSION['status']); } ?>
    

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</body>
</html>