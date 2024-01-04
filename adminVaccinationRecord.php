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
    <title>Principal | Profile</title>

    <!-- Boxicon CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    <!-- <link href="admin.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="homepage.css">

    <!-- Website Logo -->
    <link rel="icon" href="assets/logo.png">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

    <style>

        .container {
            background-color: white;
            width: 1050px;
            margin: auto;
            padding: 20px 80px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        }

        .tableContainer {
            margin: 8px auto;
            padding: 4px;
            width: 900px;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
        }

        .filters div {
            margin: 20px auto;
            display: inline-block;
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
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="search" placeholder="Search..." id="search" onkeyup="tableSearch()">
                </li>
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
                        <a href="adminVaccinationRecord.php" class="active">
                            <i class='bx bx-book-add icon'></i>
                            <span class="text nav-text">Vaccination Record</span>
                        </a>
                    </li>

                    <!-- Vaccination Archive -->
                    <li class="nav-links">
                        <a href="adminViewArchive.php">
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
        <div class="text">Vaccination Record</div>

        <div class="container">
            <div class="report">
                <div class="btnGroup" class="">
                    <button id="report" class="generateReport btn btn-primary mx-2 my-2 float-end">Generate Report</botton>
                </div>
            </div>

            <div class="filters">
                <h3 class="py-2 my-2">CHOOSE FILTERS</h3>

                <!-- Filter Role -->
                <div class="roleFilter">
                    <span>Role</span>
                    <select class="form-select col-md-2" id="fetchRole">
                        <option value="Default">Default</option>
                        <option value="Student">Student</option>    
                        <option value="Faculty">Faculty</option>    
                    </select>
                </div>

                <!-- Filter Grade Level -->
                <div class="gradeFilter col-md-2">
                    <span>Grade</span>
                    <select class="form-select col-md-2" id="fetchGrade">
                        <option value="Default">Default</option>
                        <option value="Grade 07">Grade 7</option>
                        <option value="Grade 08">Grade 8</option>
                        <option value="Grade 09">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>

                <!-- Select Section -->
                <div class="sectionFilter col-md-2">
                    <span>Section</span>
                    <select class="form-select" id="fetchSection">
                        <option value="Default">Default</option>
                        <option value="Section 1">Section 1</option>
                        <option value="Section 2">Section 2</option>
                    </select>
                </div>

                <!-- Select Sex -->
                <div class="sexFilter col-md-2">
                    <span>Sex</span>
                    <select class="form-select" id="fetchSex">
                        <option value="Default">Default</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <!-- Select Dosage Sequence -->
                <div class="dosageFilter col-md-2">
                    <span>Dosage Seq</span>
                    <select class="form-select" id="fetchDose">
                        <option value="Default">Default</option>
                        <option value="First Dose">First Dose</option>    
                        <option value="Second Dose">Second Dose</option>    
                        <option value="Booster">Booster</option>    
                    </select>
                </div>

                <!-- Select Vaccine Brand -->
                <div class="brandFilter col-md-2">
                    <span>Vaccine Brand</span>
                    <select class="form-select" id="fetchBrand">
                        <option value="Default">Default</option>
                        <option value="Pfizer">Pfizer</option>
                        <option value="Moderna">Moderna</option>
                        <option value="Astrazeneca">Astrazeneca</option>
                        <option value="Johnson & Johnsons Janssen">Johnson & Johnsons Janssen</option>
                    </select>
                </div>

                
            </div>

            <div class="tableContainer">
                <table class="table table-striped table-hover align-middle" id="tableRecord" style="font-size: small;">
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
                            <th>Archive</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $select = "SELECT * FROM login INNER JOIN vaccinationrecord ON vaccinationrecord.givenName=login.givenName";
                            $result = mysqli_query($conn, $select);
                            while($record = mysqli_fetch_assoc($result)): {
                        ?>
                        <tr>
                            <td><?php echo $record["id"] ?></td>
                            <td><?php echo $record['surname'] ?></td>
                            <td><?php echo $record['givenName'] ?></td>
                            <td><?php echo $record['mi'] ?></td>
                            <td><?php echo $record['suffix'] ?></td>
                            <td><?php echo $record['role'] ?></td>
                            <td><?php echo $record['gradeLevel'] ?></td>
                            <td><?php echo $record['section'] ?></td>
                            <td><?php echo $record['address'] ?></td>
                            <td><?php echo $record['contact'] ?></td>
                            <td><?php echo $record['dob'] ?></td>
                            <td><?php echo $record['sex'] ?></td>
                            <td><?php echo $record['philhealth'] ?></td>
                            <td><?php echo $record['category'] ?></td>

                            <?php if ($record['firstDoseBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $record['firstDoseDate']?></p>
                                    <p>Brand: <?php echo $record['firstDoseBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $record['firstVaccinator']?></p>
                                    <p>Batch No: <?php echo $record['firstBatchNo']?></p>
                                    <p>Lot No: <?php echo $record['firstLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>

                            <?php if ($record['secondDoseBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $record['secondDoseDate']?></p>
                                    <p>Brand: <?php echo $record['secondDoseBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $record['secondVaccinator']?></p>
                                    <p>Batch No: <?php echo $record['secondBatchNo']?></p>
                                    <p>Lot No: <?php echo $record['secondLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>

                            <?php if ($record['boosterBrand'] != NULL) { ?>
                                <td>
                                    <p>Date: <?php echo $record['boosterDate']?></p>
                                    <p>Brand: <?php echo $record['boosterBrand']?></p>
                                    <p>Vaccinator Name: <?php echo $record['boosterVaccinator']?></p>
                                    <p>Batch No: <?php echo $record['boosterBatchNo']?></p>
                                    <p>Lot No: <?php echo $record['boosterLotNo']?></p>
                                </td>
                            <?php } else { echo '<td></td>'; } ?>

                            <td><?php echo $record['facilityName'] ?></td>
                            <td><?php echo $record['facilityContact'] ?></td>

                            <td>
                                <a target="_blank" href="uploads/<?=$record['vaccinationCard']?>">
                                    <img height="100px" width="auto" src="uploads/<?=$record['vaccinationCard']?>">
                                </a>
                            </td>

                            <td>
                                <a href="archive.php?id=<?php echo $record['id'] ?>" type="submit" class="btn btn-danger btn-lg"><i class='bx bx-archive-in'></i></a>
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

    <!-- Fetch -->
    <script type="text/javascript">
        $(document).ready(function(){

            var role;
            var grade;
            var section;
            var gender;
            var dose;
            var manufacturer;
            var action = "data";

            $(".generateReport").click(function(){
                var count = $("#tableRecord tr").length - 1;
                var src = "generatepdf.php?count="+count+"&role="+role+"&grade="+grade+"&section="+section+"&gender="+gender+"&manufacturer="+manufacturer+"&status="+dose;
                window.open(src, "_blank");
            });


            $("#fetchRole").on('change',function(){
                var value = $(this).val();
                if (value == "Default"){
                    role = undefined;
                }else{
                    role = value;
                }
                
                $.post("fetch.php", {
                    action : action,
                    role: role,
                    gender : gender,
                    grade: grade, 
                    section : section,
                    dose : dose,
                    manufacturer : manufacturer
                }, function(data, status){
                    $(".table").html(data);
                });
            });

            $("#fetchGrade").on('change',function(){
                var value = $(this).val();
                if (value == "Default"){
                    grade = undefined;
                }else{
                    grade = value;
                }
                
                $.post("fetch.php", {
                    action : action,
                    role: role,
                    gender : gender,
                    grade: grade, 
                    section : section,
                    dose : dose,
                    manufacturer : manufacturer
                }, function(data, status){
                    $(".table").html(data);
                });
            });

            $("#fetchSection").on('change',function(){
                var value = $(this).val();
                if (value == "Default") {
                    section = undefined;
                }else {
                
                section = value;
                }

                $.post("fetch.php", {
                    action : action,
                    role: role,
                    gender : gender,
                    grade: grade, 
                    section : section,
                    dose : dose,
                    manufacturer : manufacturer
                }, function(data, status){
                    $(".table").html(data);
                });
            });

            $("#fetchSex").on('change',function(){
                var value = $(this).val();
                if (value == "Default") {
                    gender = undefined;
                }else{
                    gender = value;
                }
                
                
                $.post("fetch.php", {
                    action : action,
                    role: role,
                    gender : gender,
                    grade: grade, 
                    section : section,
                    dose : dose,
                    manufacturer : manufacturer
                }, function(data, status){
                    $(".table").html(data);
                });
            });

            $("#fetchDose").on('change',function(){
                var value = $(this).val();
                if (value == "Default") {
                    dose = undefined;
                }else {

                    dose = value;
                }


                $.post("fetch.php" , {
                    action : action,
                    role: role,
                    gender : gender,
                    grade: grade, 
                    section : section,
                    dose : dose,
                    manufacturer : manufacturer
                }, function(data, status){
                    $(".table").html(data);
                });
            });

            $("#fetchBrand").on('change',function(){
                var value = $(this).val();
                if (value == "Default") {
                    manufacturer = undefined;
                }else{

                    manufacturer = value;
                }
                

                $.post("fetch.php", {
                    action : action,
                    role: role,
                    gender : gender,
                    grade: grade, 
                    section : section,
                    dose : dose,
                    manufacturer : manufacturer
                }, function(data, status){
                    $(".table").html(data);
                });
            });
            
        });

    </script>

    <!-- Search Function -->
    <script>
        function tableSearch() {
            let input, filter, table, tr, td, txtValue;

            input = document.getElementById("search");
            
            
            filter = input.value.toUpperCase();
            table = document.getElementById("tableRecord");
            tr = table.getElementsByTagName("tr");

            for(let i = 0; i < tr.length; i ++) {
                td = tr[i].getElementsByTagName("td")[1];

                if(td){
                    txtValue = td.textContent || td.innerText;
                    if(txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }
                    else{
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>
</html>