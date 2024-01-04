<?php
    include_once 'dbh.php';
    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)) {
        header('Location: studentPortal.php');    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student | Dashboard</title>

    <!-- Boxicon CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" href="homepage.css">

    <!-- Website Logo -->
    <link rel="icon" href="assets/logo.png">

    <style>

        .container {
            /* box-shadow: 10px 10px 5px #aaaaaa; */
            width: 1040px;
            margin: auto;
            overflow: hidden;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        }

        .profile {
            width: 50%;
            margin-top: 30px;
            margin-bottom: 30px;
            float: left;
        }

        .profileInfo {
            height: 95vh;
            width: 300px;
            margin-left: 15px;
            margin-right: 20px;
            text-align: center;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
        }

        .profileInfo input {
            width: 200px;
            margin: auto;
        }

        .profileInfo img {
            height: 200px;
            width: 200px;
            margin: 25px auto;
            border-radius: 50%;
        }

        .vaccineInfo {
            height: auto;
            width: 670px;
            padding: 20px 30px;
        }

        .vaccineInfo img {
            width: 500px;
            margin: 20px auto;
            border: solid 1px black;
        }

        .table td, .table th {
            text-align: center;
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
                    <li class="nav-links" class="active">
                        <a href="studentDashboard.php"  class="active">
                            <i class='bx bx-grid-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Student Profile -->
                    <li class="nav-links">
                        <a href="studentProfile.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Student Profile</span>
                        </a>
                    </li>

                    <!-- Vaccination Form -->
                    <li class="nav-links">
                        <a href="studentVaccinationForm.php">
                            <i class='bx bx-injection icon'></i>
                            <span class="text nav-text">Vaccination Form</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
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
        <div class="text">Student Dashboard</div>

        <div class="container">
            
            <!-- Display Profile Information -->
            <div class="profileInfo profile">

                <?php

                    $result = $conn->query("SELECT * FROM login WHERE id='$user_id' ");

                    if(mysqli_num_rows($result) > 0) {
                        $profile = mysqli_fetch_assoc($result);
                    }

                    if($profile['profilePic'] == '') {
                        echo '<img src="assets/user.png" >';
                    } else {
                        echo '<img src="profile/'.$profile['profilePic'].' " >';
                    }

                ?>

                <input class="form-control text-center my-3" type="text" placeholder="STUDENT" disabled readonly>
                <h5 class="text-center my-4">Name: <?php echo $profile['givenName'];?>  <?php echo $profile['mi']; ?> <?php echo $profile['surname'];?> <?php echo $profile['suffix']; ?></h5>
                <h5 class="text-center my-4">Email: <?php echo $profile['email']; ?></h5>
                <h5 class="text-center my-4">Grade: <?php echo $profile['gradeLevel']; ?></h5>
                <h5 class="text-center my-4">Section: <?php echo $profile['section']; ?></h5>
                <a href="studentProfile.php" class="btn btn-primary">Update Profile</a> 
            </div>

            <?php $name=$profile['givenName']; ?>

            <!-- Display Vaccination Information -->
            <div class="vaccineInfo profile">

                <h3 class="text-center my-3">Your Information</h3>

                <?php
                    $result = $conn->query("SELECT * FROM login INNER JOIN vaccinationrecord ON vaccinationrecord.givenName=login.givenName WHERE vaccinationrecord.givenName='$name' ");

                    if(mysqli_num_rows($result) > 0) {
                        $student = mysqli_fetch_assoc($result);
                                            
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <p class="my-2">Name: <?php echo $student['surname']; ?>, <?php echo $student['givenName']; ?> <?php echo $student['mi']; ?>. <?php echo $student['suffix']; ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="my-2">Address: <?php echo $student['address']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="my-2">Contact No: <?php echo $student['contact']; ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="my-2">Date of Birth: <?php echo $student['dob']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="my-2">Sex: <?php echo $student['sex']; ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <p class="my-2">Philhealth: <?php echo $student['philhealth']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="my-2">Category: <?php echo $student['category']; ?></p>
                    </div>
                </div>

                <table class="table table-striped table-hover align-middle table-sm my-4">
                    <thead class="table-dark">
                        <tr>
                            <th>Dosage</th>
                            <th>Information</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr>
                            <th scope="row">First</th>
                            <?php if ($student['firstDoseBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $student['firstDoseDate']?></p>
                                    <p>Brand: <?php echo $student['firstDoseBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $student['firstVaccinator']?></p>
                                    <p>Batch No: <?php echo $student['firstBatchNo']?></p>
                                    <p>Lot No: <?php echo $student['firstLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>
                        </tr>
                        <tr>
                            <th scope="row">Second</th>
                            <?php if ($student['secondDoseBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $student['secondDoseDate']?></p>
                                    <p>Brand: <?php echo $student['secondDoseBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $student['secondVaccinator']?></p>
                                    <p>Batch No: <?php echo $student['secondBatchNo']?></p>
                                    <p>Lot No: <?php echo $student['secondLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>
                        </tr>
                        <tr>
                            <th scope="row">Booster</th>
                            <?php if ($student['boosterBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $student['boosterDate']?></6>
                                    <p>Brand: <?php echo $student['boosterBrand']?></6>
                                    <p>Vaccinator Name: <?php echo $student['boosterVaccinator']?></6>
                                    <p>Batch No: <?php echo $student['boosterBatchNo']?></6>
                                    <p>Lot No: <?php echo $student['boosterLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>
                        </tr>
                    </tbody>
                </table>

                <div class="row" style="text-align: center;">
                    
                    <a target="_blank" href="uploads/<?=$student['vaccinationCard']?>">
                    <?php
                        if($student['vaccinationCard'] == '') {
                            echo '<div></div>';
                        } else {
                            echo '<img src="uploads/'.$student['vaccinationCard'].' " >';
                        }
                    ?>
                    </a>
                    
                </div>

                <?php } else echo "<p class='text-center my-2' >Please fill-up your vaccination form.</p>" ; ?>

                <div class="row" style="width: 170px; margin: auto;">
                    <a href="studentVaccinationForm.php" class="btn btn-primary">Update Status</a> 
                </div>
            </div>
        </div>

    </section>

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