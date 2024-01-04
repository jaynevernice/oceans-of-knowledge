<?php
    include_once 'dbh.php';
    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)) {
        header('Location: facultyPortal.php');    
    }

    if (isset($_POST['update'])) {

        $givenName = $_POST['givenName'];
        $mi = $_POST['mi'];
        $surname = $_POST['surname'];
        $suffix = $_POST['suffix'];
        $email = $_POST['email'];
        $grade = $_POST['gradeLevel'];
        $section = $_POST['section'];
        
        $conn->query("UPDATE login SET givenName='$givenName', mi='$mi', surname='$surname', suffix='$suffix', email='$email', gradeLevel='$grade', section='$section' WHERE id='$user_id' ");
        $_SESSION['status'] = "You updated your profile successfully.";
        $_SESSION['status_code'] = "success";

        $oldPass = $_POST['oldPass'];
        $updatePass = md5($_POST['updatePass']);
        $newPass = md5($_POST['newPass']);
        $confPass = md5($_POST['confPass']);

        if(!empty($updatePass) || !empty($newPass) || !empty($confPass)) {
            if($updatePass != $oldPass) {

                $_SESSION['status'] = "The old password you have entered is incorrect.";
                $_SESSION['status_code'] = "error";

            } elseif ($newPass != $confPass) {

                $_SESSION['status'] = "Unable to confirm password, please ensure that passwords match.";
                $_SESSION['status_code'] = "error";

            } else {

                $conn->query("UPDATE login SET password='$confPass' WHERE id='$user_id' ");
                $_SESSION['status'] = "You have successfully updated your password.";
                $_SESSION['status_code'] = "success";

            }
        }

        $img_name = $_FILES['profilePic']['name'];
        $img_size = $_FILES['profilePic']['size'];
        $tmp_name = $_FILES['profilePic']['tmp_name'];

        $error = $_FILES['profilePic']['error'];

        if ($error === 0) {
            if ($img_size > 10000000) {

                $_SESSION['status'] = "The file you are trying to upload is too large, please try another.";
                $_SESSION['status_code'] = "error";

            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if(in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("PRF-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'profile/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $conn->query("UPDATE login SET profilePic='$new_img_name' WHERE id='$user_id' ");
                    $_SESSION['status'] = "You have successfuly updated your profile.";
                    $_SESSION['status_code'] = "success";

                } else {
                    
                    $_SESSION['status'] = "Invalid file type, please ensure that file type is a JPEG/PNG.";
                    $_SESSION['status_code'] = "error";
                    
                }
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
    <title>Faculty | Profile</title>

    <!-- Boxicon CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" href="homepage.css">

    <!-- Website Logo -->
    <link rel="icon" href="assets/logo.png">

    <style>   

        .container {
            width: 1050px;
            height: 80vh;
            margin-top: 10px;
            padding: 20px 40px;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        }

        .profile {
            width: 50%;
            margin-top: 20px;
            float: left;
        }

        .profilePicture {
            height: 65vh;
            width: 300px;
            margin-left: 15px;
            margin-right: 20px;
            text-align: center;
        }

        .profileInfo {
            height: 65vh;
            width: 600px;
            padding: 20px 30px;
            margin-left: 20px;
            background-color: #F8F6F0;
            box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset;
        }

        .profile img {
            height: 200px;
            width: auto;
            margin-top: 20px;
        }

        
    </style>

</head>
<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="assets/logo.png" alt="logo">
                </span>

                <div class="text header-text">
                    <span class="name">Oceans of Knowledge</span>
                    <span class="profession">VMS</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">

                    <!-- Dashboard -->
                    <li class="nav-links">
                        <a href="facultyDashboard.php">
                            <i class='bx bx-grid-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- Faculty Profile -->
                    <li class="nav-links">
                        <a href="facultyProfile.php" class="active">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Faculty Profile</span>
                        </a>
                    </li>

                    <!-- Vaccination Form -->
                    <li class="nav-links">
                        <a href="facultyVaccinationForm.php">
                            <i class='bx bx-injection icon'></i>
                            <span class="text nav-text">Vaccination Form</span>
                        </a>
                    </li>
                    
                </ul>
            </div>

            <div class="bottom-content">
                <li>
                    <a href="logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>

                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <section class="home">
        <div class="text">Faculty Profile</div>

        <?php
            $result = $conn->query("SELECT * FROM login WHERE id='$user_id' ");

            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            }
        ?>

        <div class="container">
            <form class="form" method="POST" enctype="multipart/form-data">
                
                <!-- Image Upload -->
                <div class="profilePicture profile">
                    <?php

                        if($row['profilePic'] == '') {
                            echo '<img src="assets/user.png" >';
                        } else {
                            echo '<img src="profile/'.$row['profilePic'].' " >';
                        }
                        
                    ?>
                    <input class="form-control my-3 text-center" type="text" placeholder="FACULTY" disabled readonly style="width: 180px; margin: auto;"> 
                    <h6 class="p-3">Upload a profile picture</h6>
                    <input class="form-control" type="file" name="profilePic">
                </div>

                <!-- Info Upload -->
                <div class="profileInfo profile">

                    <div>
                        <h4 class="text-center p-3">Setup Your Profile</h4>
                    </div>

                    <!-- Name -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input name="givenName" type="text" class="form-control" placeholder="Given Name" required value="<?php echo $row['givenName']; ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <input name="mi" type="text" class="form-control" placeholder="M.I" required value="<?php echo $row['mi']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input name="surname" type="text" class="form-control" placeholder="Surname" required value="<?php echo $row['surname']; ?>"> 
                        </div>
                        <div class="col-md-2 mb-3">
                            <input name="suffix" type="text" class="form-control" placeholder="Suffix" value="<?php echo $row['suffix']; ?>">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $row['email']; ?>">
                        </div>
                    </div>

                    <!-- Grade and Section -->
                    <div class="row">
                        <div class="col-md-6 my-2">
                            <select name="gradeLevel" id="gradeLevel" class="form-select">
                                <option selected disabled>Grade Level</option>
                                <option value="Grade 07" <?php if($row['gradeLevel']=="Grade 07") echo 'selected="selected"'; ?> >Grade 07</option>
                                <option value="Grade 08" <?php if($row['gradeLevel']=="Grade 08") echo 'selected="selected"'; ?> >Grade 08</option>
                                <option value="Grade 09" <?php if($row['gradeLevel']=="Grade 09") echo 'selected="selected"'; ?> >Grade 09</option>
                                <option value="Grade 10" <?php if($row['gradeLevel']=="Grade 10") echo 'selected="selected"'; ?> >Grade 10</option>
                                <option value="Grade 11" <?php if($row['gradeLevel']=="Grade 11") echo 'selected="selected"'; ?> >Grade 11</option>
                                <option value="Grade 12" <?php if($row['gradeLevel']=="Grade 12") echo 'selected="selected"'; ?> >Grade 12</option>
                            </select>
                        </div>
                        <div class="col-md-6 my-2">
                            <select name="section" id="section" class="form-select">
                                <option selected disabled>Section</option>
                                <option value="Section 1" <?php if($row['section']=="Section 1") echo 'selected="selected"'; ?> >Section 1</option>
                                <option value="Section 2" <?php if($row['section']=="Section 2") echo 'selected="selected"'; ?> >Section 2</option>
                            </select>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" name="oldPass" class="form-control" value="<?php echo $row['password']; ?>">
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="password" name="updatePass" class="form-control" placeholder="Enter Previous Password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="password" name="newPass" class="form-control" placeholder="Enter New Password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="password" name="confPass" class="form-control" placeholder="Confirm New Password">
                        </div>
                    </div>

                    <div class="text-center">
                        <button name="update" class="btn btn-primary m-2" type="submit">Update</button>
                    </div>

                </div>
            </form> 
        </div>
    </section>
   
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

    <!-- Sidebar JS -->
    <script>
        const body = document.querySelector("body"),
            sidebar = body.querySelector(".sidebar"),
            toggle = body.querySelector(".toggle"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");

            toggle.addEventListener("click", ()=> {
                sidebar.classList.toggle("close");
            });

            modeSwitch.addEventListener("click", ()=> {
                body.classList.toggle("dark");

                if(body.classList.contains("dark")) {
                modeText.innerText = "Light Mode";
                } else {
                modeText.innerText = "Dark Mode";
                }
            });
    </script>
</body>
</html>