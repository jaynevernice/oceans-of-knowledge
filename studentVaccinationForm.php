<?php
    include_once 'dbh.php';
    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)) {
        header('Location: studentPortal.php');    
    }

    $result = $conn->query("SELECT * FROM vaccinationrecord");

    $result = $conn->query("SELECT * FROM login WHERE login.id='$user_id' ");

    if(mysqli_num_rows($result) > 0) {
        $fetch = mysqli_fetch_assoc($result);

        $sname = $fetch['surname'];
        $gname = $fetch['givenName'];
        $mid = $fetch['mi'];
        $suf = $fetch['suffix'];
    }

    if(isset($_POST['submit'])) {
 
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $dob = $_POST['dob'];
        $sex = $_POST['sex'];
        $philhealth = $_POST['philhealth'];
        $category = $_POST['category'];
 
        $insert = "INSERT INTO vaccinationrecord (surname, givenName, mi, suffix, address, contact, dob, sex, philhealth, category, firstDoseDate, firstDoseBrand, firstVaccinator, firstBatchNo, firstLotNo, secondDoseDate, secondDoseBrand, secondVaccinator, secondBatchNo, secondLotNo, boosterDate, boosterBrand, boosterVaccinator, boosterBatchNo, boosterLotNo, facilityName, facilityContact, vaccinationCard) VALUES ('$sname', '$gname', '$mid', '$suf', '$address', '$contact', '$dob', '$sex', '$philhealth', '$category', ";
             
        if(isset($_POST['firstDoseBrand'])) {
            $firstDoseDate = $_POST['firstDoseDate'];
            $firstDoseBrand = $_POST['firstDoseBrand'];
            $firstVaccinator = $_POST['firstVaccinator'];
            $firstBatchNo = $_POST['firstBatchNo'];
            $firstLotNo = $_POST['firstLotNo'];
 
            $insert .= " '$firstDoseDate', '$firstDoseBrand', '$firstVaccinator', '$firstBatchNo', '$firstLotNo'," ;
 
        } else { $insert .= " NULL, NULL, NULL, NULL, NULL," ; }
 
        if(isset($_POST['secondDoseBrand'])) {
            $secondDoseDate = $_POST['secondDoseDate'];
            $secondDoseBrand = $_POST['secondDoseBrand'];
            $secondVaccinator = $_POST['secondVaccinator'];
            $secondBatchNo = $_POST['secondBatchNo'];
            $secondLotNo = $_POST['secondLotNo'];
 
            $insert .= " '$secondDoseDate', '$secondDoseBrand', '$secondVaccinator', '$secondBatchNo', '$secondLotNo'," ;
 
        } else { $insert .= " NULL, NULL, NULL, NULL, NULL," ; }
 
        if(isset($_POST['boosterBrand'])) {
            $boosterDate = $_POST['boosterDate'];
            $boosterBrand = $_POST['boosterBrand'];
            $boosterVaccinator = $_POST['boosterVaccinator'];
            $boosterBatchNo = $_POST['boosterBatchNo'];
            $boosterLotNo = $_POST['boosterLotNo'];
 
            $insert .= " '$boosterDate', '$boosterBrand', '$boosterVaccinator', '$boosterBatchNo', '$boosterLotNo'," ;
 
        } else { $insert .= " NULL, NULL, NULL, NULL, NULL," ; }
 
        $facilityName = $_POST['facilityName'];
        $facilityContact = $_POST['facilityContact'];
 
        $img_name = $_FILES['vaccinationCard']['name'];
        $img_size = $_FILES['vaccinationCard']['size'];
        $tmp_name = $_FILES['vaccinationCard']['tmp_name'];
 
        $error = $_FILES['vaccinationCard']['error'];
 
        if ($error === 0) {
            if ($img_size > 10000000) {
                
                $_SESSION['status'] = "The file you are trying to upload is too large, please try another.";
                $_SESSION['status_code'] = "error";

            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
 
                $allowed_exs = array("jpg", "jpeg", "png");
 
                if(in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("VAX-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'uploads/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
 
                    $insert .= " '$facilityName', '$facilityContact', '$new_img_name')" ;
                    mysqli_query($conn, $insert);

                    $_SESSION['status'] = "You have successfuly uploaded your vaccination status.";
                    $_SESSION['status_code'] = "success";

                } else {

                    $_SESSION['status'] = "Invalid file type, please ensure that file type is a JPEG/PNG.";
                    $_SESSION['status_code'] = "error";

                } 
            }
        } else { echo "Error"; }
    }


    if (isset($_POST['update'])) {
        
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $dob = $_POST['dob'];
        $sex = $_POST['sex'];
        $philhealth = $_POST['philhealth'];
        $category = $_POST['category'];

        if(isset($_POST['firstDoseBrand'])) {
            $firstDoseDate = $_POST['firstDoseDate'];
            $firstDoseBrand = $_POST['firstDoseBrand'];
            $firstVaccinator = $_POST['firstVaccinator'];
            $firstBatchNo = $_POST['firstBatchNo'];
            $firstLotNo = $_POST['firstLotNo'];
        } else {
            $firstDoseDate = NULL;
            $firstDoseBrand = NULL;
            $firstVaccinator = NULL;
            $firstBatchNo = NULL;
            $firstLotNo = NULL;
        }

        if(isset($_POST['secondDoseBrand'])) {
            $secondDoseDate = $_POST['secondDoseDate'];
            $secondDoseBrand = $_POST['secondDoseBrand'];
            $secondVaccinator = $_POST['secondVaccinator'];
            $secondBatchNo = $_POST['secondBatchNo'];
            $secondLotNo = $_POST['secondLotNo'];
        } else {
            $secondDoseDate = NULL;
            $secondDoseBrand = NULL;
            $secondVaccinator = NULL;
            $secondBatchNo = NULL;
            $secondLotNo = NULL;
        }

        if(isset($_POST['boosterBrand'])) {
            $boosterDate = $_POST['boosterDate'];
            $boosterBrand = $_POST['boosterBrand'];
            $boosterVaccinator = $_POST['boosterVaccinator'];
            $boosterBatchNo = $_POST['boosterBatchNo'];
            $boosterLotNo = $_POST['boosterLotNo'];
        } else {
            $boosterDate = NULL;
            $boosterBrand = NULL;
            $boosterVaccinator = NULL;
            $boosterBatchNo = NULL;
            $boosterLotNo = NULL;
        }
        
        $facilityName = $_POST['facilityName'];
        $facilityContact = $_POST['facilityContact'];
        
        $result = $conn->query("UPDATE vaccinationrecord INNER JOIN login ON login.givenName=vaccinationrecord.givenName SET vaccinationrecord.surname='$sname', vaccinationrecord.givenName='$gname', vaccinationrecord.mi='$mid', vaccinationrecord.suffix='$suf', address='$address', contact='$contact', dob='$dob', sex='$sex', philhealth='$philhealth', category='$category', firstDoseDate='$firstDoseDate', firstDoseBrand='$firstDoseBrand', firstVaccinator='$firstVaccinator', firstBatchNo='$firstBatchNo', firstLotNo='$firstLotNo', secondDoseDate='$secondDoseDate', secondDoseBrand='$secondDoseBrand', secondVaccinator='$secondVaccinator', secondBatchNo='$secondBatchNo', secondLotNo='$secondLotNo', boosterDate='$boosterDate', boosterBrand='$boosterBrand', boosterVaccinator='$boosterVaccinator', boosterBatchNo='$boosterBatchNo', boosterLotNo='$boosterLotNo', facilityName='$facilityName', facilityContact='$facilityContact' WHERE login.id='$user_id' ; ");
        $_SESSION['status'] = "You have successfuly updated your vaccination status.";
        $_SESSION['status_code'] = "success";

        $img_name = $_FILES['vaccinationCard']['name'];
        $img_size = $_FILES['vaccinationCard']['size'];
        $tmp_name = $_FILES['vaccinationCard']['tmp_name'];

        $error = $_FILES['vaccinationCard']['error'];

        if ($error === 0) {
            if ($img_size > 10000000) {
                
                $_SESSION['status'] = "The file you are trying to upload is too large, please try another.";
                $_SESSION['status_code'] = "error";

            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if(in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("VAX-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'uploads/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $conn->query("UPDATE vaccinationrecord INNER JOIN login ON login.givenName=vaccinationrecord.givenName SET vaccinationCard='$new_img_name' WHERE login.id='$user_id' ");
                    $_SESSION['status'] = "You have successfuly updated your vaccination status.";
                    $_SESSION['status_code'] = "success";

                } else {
                    
                    $_SESSION['status'] = "Invalid file type, please ensure that file type is a JPEG/PNG.";
                    $_SESSION['status_code'] = "error";
                }
            }
        } else { echo "Error"; }        
    }  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student | Vaccination Form</title>

    <!-- Boxicon CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="homepage.css">

    <!-- Website Logo -->
    <link rel="icon" href="assets/logo.png">

    <style>

        .container {
            background-color: white;
            width: 1050px;
            margin: auto;
            padding: 20px 80px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        }

        .imageUpload {
            width: 600px;
            margin: auto;
            margin-top: 10px;
            padding: 15px 30px;
            box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset;
            text-align: center;
        }

        .imageUpload img {
            height: 300px;
            padding: 20px 20px;
        }

        .imageUpload input {
            width: 300px;
            margin: auto;
            padding-bottom: 10px; 
        }

        .table td, .table th {
            min-width: 90px;
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
                        <a href="studentDashboard.php">
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
                        <a href="studentVaccinationForm.php"  class="active">
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
        <div class="text">Student Vaccination Form</div>

        <?php
            $result = $conn->query("SELECT * FROM vaccinationrecord INNER JOIN login ON vaccinationrecord.givenName=login.givenName WHERE login.id='$user_id' ");

            if(mysqli_num_rows($result) > 0) {
                $student = mysqli_fetch_assoc($result);
            
        ?>

        <div class="container">

            <form class="form" method="POST" enctype="multipart/form-data">

                <div class="row mx-3 p-4">
                    <h5 class="text-center">Please enter all the prompted information regarding your vaccination status</h5>
                </div>

                <!-- Name -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <input disabled name="surname" type="text" class="form-control" value="<?php echo $student['surname']; ?>" disabled>
                    </div>
                    <div class="col-md-4 mb-4">
                        <input disabled name="givenName" type="text" class="form-control" value="<?php echo $student['givenName']; ?>" disabled>
                    </div>
                    <div class="col-md-2 mb-4">
                        <input disabled name="mi" type="text" class="form-control" value="<?php echo $student['mi']?>" disabled>
                    </div>
                    <div class="col-md-2 mb-4">
                        <input name="suffix" type="text" class="form-control" value="<?php echo $student['suffix']?>" disabled>
                    </div>
                </div>

                <!-- Address and Contact No -->
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input name="address" type="text" class="form-control" placeholder="Address" required value="<?php echo $student['address']?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <input name="contact" type="text" class="form-control" placeholder="Contact No." required value="<?php echo $student['contact']?>">
                    </div>
                </div>

                <!-- Date of Birth, Sex, PhilHealth No., and Category -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input name="dob" type="date" class="form-control" placeholder="Date of Birth" required value="<?php echo $student['dob']?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="sex" class="form-select">
                            <option selected disabled value="">Sex</option>
                            <option value="Female" <?php if($student['sex']=="Female") echo 'selected="selected"'; ?> >Female</option>
                            <option value="Male" <?php if($student['sex']=="Male") echo 'selected="selected"'; ?> >Male</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input name="philhealth" type="text" class="form-control" placeholder="PhilHealth No." value="<?php echo $student['philhealth']?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="category" class="form-select">
                            <option selected disabled value="">Category</option>
                            <option disabled value="">-------Group A-------</option>
                            <option value="A1" <?php if($student['category']=="A1") echo 'selected="selected"'; ?> >A1</option>
                            <option value="A2" <?php if($student['category']=="A2") echo 'selected="selected"'; ?> >A2</option>
                            <option value="A3" <?php if($student['category']=="A3") echo 'selected="selected"'; ?> >A3</option>
                            <option value="A4" <?php if($student['category']=="A4") echo 'selected="selected"'; ?> >A4</option>
                            <option value="A5" <?php if($student['category']=="A5") echo 'selected="selected"'; ?> >A5</option>
                            <option disabled value="">-------Group B-------</option>
                            <option value="B1" <?php if($student['category']=="B1") echo 'selected="selected"'; ?> >B1</option>
                            <option value="B2" <?php if($student['category']=="B2") echo 'selected="selected"'; ?> >B2</option>
                            <option value="B3" <?php if($student['category']=="B3") echo 'selected="selected"'; ?> >B3</option>
                            <option value="B4" <?php if($student['category']=="B4") echo 'selected="selected"'; ?> >B4</option>
                            <option value="B5" <?php if($student['category']=="B5") echo 'selected="selected"'; ?> >B5</option>
                            <option value="B6" <?php if($student['category']=="B6") echo 'selected="selected"'; ?> >B6</option>
                            <option disabled>-------Group C-------</option>
                            <option value="C" <?php if($student['category']=="C") echo 'selected="selected"'; ?> >C</option>
                        </select>
                    </div>
                </div>

                <div class="row my-3">
                    <table class="table table-sm">
                        
                        <!-- Row Title -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Dosage</th>
                                <th scope="col">Date</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Vaccinator</th>
                                <th scope="col">Batch No.</th>
                                <th scope="col">Lot No.</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        
                        <!-- First Dose Row -->
                        <tr>
                            <th scope="row">First</th>
                                <td>
                                    <input class="form-control" name="firstDoseDate" type="date" value="<?php echo $student['firstDoseDate']?>">
                                </td>
                                <td>
                                    <select name="firstDoseBrand" class="form-select">
                                        <option selected disabled>Select</option>
                                        <option value="Pfizer" <?php if($student['firstDoseBrand']=="Pfizer") echo 'selected="selected"'; ?> >Pfizer</option>
                                        <option value="Moderna" <?php if($student['firstDoseBrand']=="Moderna") echo 'selected="selected"'; ?> >Moderna</option>
                                        <option value="Astrazeneca" <?php if($student['firstDoseBrand']=="Astrazeneca") echo 'selected="selected"'; ?> >Astrazeneca</option>
                                        <option value="Johnson & Johnsons Janssen" <?php if($student['firstDoseBrand']=="Johnson & Johnsons Janssen") echo 'selected="selected"'; ?> >Johnson & Johnsons Janssen</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="firstVaccinator" value="<?php echo $student['firstVaccinator']?>">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="firstBatchNo" value="<?php echo $student['firstBatchNo']?>">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="firstLotNo" value="<?php echo $student['firstLotNo']?>">
                                </td>
                            </tr>

                        <!-- Second Dose -->
                        <tr>
                            <th scope="row">Second</th>
                            <td>
                                <input class="form-control" name="secondDoseDate" type="date" value="<?php echo $student['secondDoseDate']?>">
                            </td>
                            <td>
                                <select name="secondDoseBrand" class="form-select">
                                    <option selected disabled>Select</option>
                                    <option value="Pfizer" <?php if($student['secondDoseBrand']=="Pfizer") echo 'selected="selected"'; ?> >Pfizer</option>
                                    <option value="Moderna" <?php if($student['secondDoseBrand']=="Moderna") echo 'selected="selected"'; ?> >Moderna</option>
                                    <option value="Astrazeneca" <?php if($student['secondDoseBrand']=="Astrazeneca") echo 'selected="selected"'; ?> >Astrazeneca</option>
                                    <option value="Johnson & Johnsons Janssen" <?php if($student['secondDoseBrand']=="Johnson & Johnsons Janssen") echo 'selected="selected"'; ?> >Johnson & Johnsons Janssen</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="secondVaccinator" value="<?php echo $student['secondVaccinator']?>">
                            </td>
                            <td>
                                <input class="form-control" type="text" name="secondBatchNo" value="<?php echo $student['secondBatchNo']?>">
                            </td>
                            <td>
                                <input  class="form-control" type="text" name="secondLotNo" value="<?php echo $student['secondLotNo']?>">
                            </td>
                        </tr>
                                
                        <!-- Booster Dose -->
                        <tr>
                            <th scope="row">Booster</th>
                                <td>
                                    <input class="form-control" name="boosterDate" type="date" value="<?php echo $student['boosterDate']?>">
                                </td>
                                <td>
                                    <select name="boosterBrand" class="form-select">
                                        <option selected disabled value="">Select</option>
                                        <option value="Pfizer" <?php if($student['boosterBrand']=="Pfizer") echo 'selected="selected"'; ?> >Pfizer</option>
                                        <option value="Moderna" <?php if($student['boosterBrand']=="Moderna") echo 'selected="selected"'; ?> >Moderna</option>
                                        <option value="Astrazeneca" <?php if($student['boosterBrand']=="Astrazeneca") echo 'selected="selected"'; ?> >Astrazeneca</option>
                                        <option value="Johnson & Johnsons Janssen" <?php if($student['boosterBrand']=="Johnson & Johnsons Janssen") echo 'selected="selected"'; ?> >Johnson & Johnsons Janssen</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="boosterVaccinator" value="<?php echo $student['boosterVaccinator']?>">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="boosterBatchNo" value="<?php echo $student['boosterBatchNo']?>">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="boosterLotNo" value="<?php echo $student['boosterLotNo']?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input name="facilityName" type="text" class="form-control" placeholder="Health Facility Name" value="<?php echo $student['facilityName']?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input name="facilityContact" type="text" class="form-control" placeholder="Health Facility Contact No" value="<?php echo $student['facilityContact']?>">
                    </div>
                </div>

                <div class="imageUpload">
                    <h6>Please upload a scan of your COVID-19 Vaccination Card</h6>
                    <a target="_blank" href="uploads/<?=$student['vaccinationCard']?>">
                        <?php
                        if($student['vaccinationCard'] == '') {
                            echo '<div></div>';
                        } else {
                            echo '<img src="uploads/'.$student['vaccinationCard'].' " >';
                        }
                        ?>
                    </a>
                    <input class="form-control" type="file" name="vaccinationCard">

                </div>

                <div class="text-center">
                    <button name="update" class="btn btn-primary m-4" type="submit">Update</button>
                </div>

        <!-- Else table is empty -->

        <?php } else { ?>
        <div class="container">
            <form class="form" method="POST" enctype="multipart/form-data">

                <div class="row mx-3 p-4">
                    <h5 class="text-center">Please enter all the prompted information regarding your vaccination status</h5>
                </div>

                <!-- Name -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <input name="surname" type="text" class="form-control" value="<?php echo $sname; ?>" disabled>
                    </div>
                    <div class="col-md-4 mb-4">
                        <input name="givenName" type="text" class="form-control" value="<?php echo $gname; ?>" disabled>
                    </div>
                    <div class="col-md-2 mb-4">
                        <input name="mi" type="text" class="form-control" value="<?php echo $mid; ?>" disabled>
                    </div>
                    <div class="col-md-2 mb-4">
                        <input name="suffix" type="text" class="form-control" value="<?php echo $suf; ?>" disabled>
                    </div>
                </div>
                
                <!-- Address and Contact No -->
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input name="address" type="text" class="form-control" placeholder="Address" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input name="contact" type="text" class="form-control" placeholder="Contact No." required>
                    </div>
                </div>

                <!-- Date of Birth, Sex, PhilHealth No., and Category -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input name="dob" type="date" class="form-control" placeholder="Date of Birth" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select required name="sex" class="form-select">
                            <option selected disabled value="">Sex</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input name="philhealth" type="text" class="form-control" placeholder="PhilHealth No.">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select required name="category" class="form-select">
                            <option selected disabled value="">Category</option>
                            <option disabled value="">-------Group A-------</option>
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="A3">A3</option>
                            <option value="A4">A4</option>
                            <option value="A5">A5</option>
                            <option disabled value="">-------Group B-------</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="B3">B3</option>
                            <option value="B4">B4</option>
                            <option value="B5">B5</option>
                            <option value="B6">B6</option>
                            <option disabled>-------Group C-------</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                </div>

                <div class="row my-3">
                    <table class="table table-sm">
                        
                        <!-- Row Title -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Dosage</th>
                                <th scope="col">Date</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Vaccinator</th>
                                <th scope="col">Batch No.</th>
                                <th scope="col">Lot No.</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        
                        <!-- First Dose Row -->
                        <tr>
                            <th scope="row">First</th>
                                <td>
                                    <input class="form-control" name="firstDoseDate" type="date">
                                </td>
                                <td>
                                    <select name="firstDoseBrand" class="form-select">
                                        <option selected disabled value="">Select</option>
                                        <option value="Pfizer">Pfizer</option>
                                        <option value="Moderna">Moderna</option>
                                        <option value="Astrazeneca">Astrazeneca</option>
                                        <option value="Johnson & Johnsons Janssen">Johnson & Johnsons Janssen</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="firstVaccinator">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="firstBatchNo">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="firstLotNo">
                                </td>
                            </tr>

                        <!-- Second Dose -->
                        <tr>
                            <th scope="row">Second</th>
                            <td>
                                <input class="form-control" name="secondDoseDate" type="date">
                            </td>
                            <td>
                                <select name="secondDoseBrand" class="form-select">
                                    <option selected disabled value="">Select</option>
                                    <option value="Pfizer">Pfizer</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Astrazeneca">Astrazeneca</option>
                                    <option value="Johnson & Johnsons Janssen">Johnson & Johnsons Janssen</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="secondVaccinator">
                            </td>
                            <td>
                                <input class="form-control" type="text" name="secondBatchNo">
                            </td>
                            <td>
                                <input  class="form-control" type="text" name="secondLotNo">
                            </td>
                        </tr>
                                
                        <!-- Booster Dose -->
                        <tr>
                            <th scope="row">Booster</th>
                                <td>
                                    <input class="form-control" name="boosterDate" type="date">
                                </td>
                                <td>
                                    <select name="boosterBrand" class="form-select">
                                        <option selected disabled value="">Select</option>
                                        <option value="Pfizer">Pfizer</option>
                                        <option value="Moderna">Moderna</option>
                                        <option value="Astrazeneca">Astrazeneca</option>
                                        <option value="Johnson & Johnsons Janssen">Johnson & Johnsons Janssen</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="boosterVaccinator">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="boosterBatchNo">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="boosterLotNo">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input required name="facilityName" type="text" class="form-control" placeholder="Health Facility Name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input required name="facilityContact" type="text" class="form-control" placeholder="Health Facility Contact No">
                    </div>
                </div>

                <div class="imageUpload">
                    <h6>Please upload a scan of your COVID-19 Vaccination Card</h6>
                    <input required class="form-control" type="file" name="vaccinationCard">
                </div>

                <div class="text-center">
                    <button name="submit" class="btn btn-primary m-4" type="submit">Upload</button>
                </div>

                <?php } ?>
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