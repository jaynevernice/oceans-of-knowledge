<?php
    include_once 'dbh.php';
    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)) {
        header('Location: adminPortal.php');    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal | Dashboard</title>

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
            margin: auto;
            padding: 20px 50px;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        }

        .tableContainer {
            margin: 20px auto;
            padding: 4px;
            width: 900px;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
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
                        <a href="adminDashboard.php">
                            <i class='bx bx-grid-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <!-- Principal Profile -->
                    <li class="nav-links">
                        <a href="adminProfile.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Principal Profile</span>
                        </a>
                    </li>

                    <!-- Vaccination Form -->
                    <li class="nav-links">
                        <a href="adminVaccinationForm.php">
                            <i class='bx bx-injection icon'></i>
                            <span class="text nav-text">Vaccination Form</span>
                        </a>
                    </li>

                    <!-- Vaccination Record -->
                    <li class="nav-links">
                        <a href="adminVaccinationRecord.php">
                            <i class='bx bx-book-add icon'></i>
                            <span class="text nav-text">Vaccination Record</span>
                        </a>
                    </li>

                    <!-- Vaccination Archive -->
                    <li class="nav-links">
                        <a href="adminViewArchive.php" class="active">
                            <i class='bx bx-archive icon'></i>
                            <span class="text nav-text">Archive</span>
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
        <div class="text">Archive</div>

        <div class="container">

            <h5 class="text-center m-3">A Backup For All Vaccination Record in the System</p>
            
            <div class="tableContainer">
                <table class="table table-striped table-hover align-middle table-sm" id="tableRecord" style="font-size: small;">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Surname</th>
                            <th>Given Name</th>
                            <th>Middle Initial</th>
                            <th>Suffix</th>
                            <th>Role</th>
                            <th>Grade</th>
                            <th>Section</th>
                            <th>Address</th>
                            <th>Contact No.</th>
                            <th>Date of Birth</th>
                            <th>Sex</th>
                            <th>PhilHealth No.</th>
                            <th>Category</th>
                            <th>First Dose</th>
                            <th>Second Dose</th>
                            <th>Booster</th>
                            <th>Health Facility Name</th>
                            <th>Health Facility Contact No.</th>
                            <th>Vaccination Card</th>
                            <th>Unarchive</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $select = "SELECT * FROM archive INNER JOIN login ON archive.givenName=login.givenName";
                            $result = mysqli_query($conn, $select);
                            while($archive = mysqli_fetch_assoc($result)): {
                        ?>
                        <tr>
                            <td><?php echo $archive["id"] ?></td>
                            <td><?php echo $archive['surname'] ?></td>
                            <td><?php echo $archive['givenName'] ?></td>
                            <td><?php echo $archive['mi'] ?></td>
                            <td><?php echo $archive['suffix'] ?></td>
                            <td><?php echo $archive['role'] ?></td>
                            <td><?php echo $archive['gradeLevel'] ?></td>
                            <td><?php echo $archive['section'] ?></td>
                            <td><?php echo $archive['address'] ?></td>
                            <td><?php echo $archive['contact'] ?></td>
                            <td><?php echo $archive['dob'] ?></td>
                            <td><?php echo $archive['sex'] ?></td>
                            <td><?php echo $archive['philhealth'] ?></td>
                            <td><?php echo $archive['category'] ?></td>

                            <?php if ($archive['firstDoseBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $archive['firstDoseDate']?></p>
                                    <p>Brand: <?php echo $archive['firstDoseBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $archive['firstVaccinator']?></p>
                                    <p>Batch No: <?php echo $archive['firstBatchNo']?></p>
                                    <p>Lot No: <?php echo $archive['firstLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>

                            <?php if ($archive['secondDoseBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $archive['secondDoseDate']?></p>
                                    <p>Brand: <?php echo $archive['secondDoseBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $archive['secondVaccinator']?></p>
                                    <p>Batch No: <?php echo $archive['secondBatchNo']?></p>
                                    <p>Lot No: <?php echo $archive['secondLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>

                            <?php if ($archive['boosterBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $archive['boosterDate']?></p>
                                    <p>Brand: <?php echo $archive['boosterBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $archive['boosterVaccinator']?></p>
                                    <p>Batch No: <?php echo $archive['boosterBatchNo']?></p>
                                    <p>Lot No: <?php echo $archive['boosterLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>

                            <td><?php echo $archive['facilityName'] ?></td>
                            <td><?php echo $archive['facilityContact'] ?></td>

                            <td>
                                <a target="_blank" href="uploads/<?=$archive['vaccinationCard']?>">
                                    <img height="100px" width="auto" src="uploads/<?=$archive['vaccinationCard']?>">
                                </a>
                            </td>

                            <td>
                                <a href="unarchive.php?id=<?php echo $archive['id'] ?>" type="submit" class="btn btn-danger btn-lg"><i class='bx bx-archive-out'></i></a>
                            </td>

                        </tr>
                        <?php } endwhile; ?>
                    </tbody>
                </table>
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