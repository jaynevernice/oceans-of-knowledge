<?php
    include_once 'dbh.php';
    session_start();

    if(isset($_POST['action'])){

        $query = "SELECT * FROM login INNER JOIN vaccinationrecord ON vaccinationrecord.givenName=login.givenName WHERE vaccinationrecord.givenName IS NOT NULL";
        

        if(isset($_POST['role'])){

            $role = $_POST['role'];
            $query .= " AND login.role = '$role'"; 

        }

        if(isset($_POST['grade'])){

            $grade = $_POST['grade'];
            $query .= " AND gradeLevel = '$grade'"; 

        }

        if(isset($_POST['section'])){

            $section = $_POST['section'];
            $query .= " AND section = '$section'"; 

        }

        if(isset($_POST['gender'])){

            $gender = $_POST['gender'];
            $query .= " AND sex = '$gender'"; 

        }

        if(isset($_POST['dose'])){
            $stdose = $_POST['dose'];
            
            if ($stdose == "First Dose"){

                $query .= " AND firstDoseBrand IS NOT NULL";

            } else if ($stdose == "Second Dose"){

                $query .= " AND firstDoseBrand IS NOT NULL AND secondDoseBrand !=''";

            } else if ($stdose == "Booster"){

                $query .= " AND firstDosebrand IS NOT NULL AND secondDoseBrand IS NOT NULL AND boosterBrand !='' ";
            
            }
        }

        if(isset($_POST['manufacturer'])){

            $manufacturer = $_POST['manufacturer'];
            $query .= " AND firstDoseBrand = '$manufacturer' OR secondDoseBrand = '$manufacturer' OR boosterBrand = '$manufacturer'"; 
        
        }

        $result = mysqli_query($conn,$query);
        $count = mysqli_num_rows($result);
    
?>

<table class="table table-striped table-hover align-middle" id="tableRecord">
    <?php if($result){ ?>
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

        <?php } else{ echo "Sorry! No Records"; } ?>
        
    </thead>

    <tbody class="table-group-divider">
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row["id"] ?></td>
            <td><?php echo $row['surname'] ?></td>
            <td><?php echo $row['givenName'] ?></td>
            <td><?php echo $row['mi'] ?></td>
            <td><?php echo $row['suffix'] ?></td>
            <td><?php echo $row['role'] ?></td>
            <td><?php echo $row['gradeLevel'] ?></td>
            <td><?php echo $row['section'] ?></td>
            <td><?php echo $row['address'] ?></td>
            <td><?php echo $row['contact'] ?></td>
            <td><?php echo $row['dob'] ?></td>
            <td><?php echo $row['sex'] ?></td>
            <td><?php echo $row['philhealth'] ?></td>
            <td><?php echo $row['category'] ?></td>

            <?php if ($row['firstDoseBrand'] != NULL) { ?>
            <td>
                <p>Date: <?php echo $row['firstDoseDate']?></p>
                <p>Brand: <?php echo $row['firstDoseBrand']?></p>
                <p>Vaccinator Name: <?php echo $row['firstVaccinator']?></p>
                <p>Batch No: <?php echo $row['firstBatchNo']?></p>
                <p>Lot No: <?php echo $row['firstLotNo']?></p>
            </td>
            <?php } else { echo '<td></td>'; } ?>

            <?php if ($row['secondDoseBrand'] != NULL) { ?>
                <td>
                    <p>Date: <?php echo $row['secondDoseDate']?></p>
                    <p>Brand: <?php echo $row['secondDoseBrand']?></p>
                    <p>Vaccinator Name: <?php echo $row['secondVaccinator']?></p>
                    <p>Batch No: <?php echo $row['secondBatchNo']?></p>
                    <p>Lot No: <?php echo $row['secondLotNo']?></p>
                </td>
            <?php } else { echo '<td></td>'; } ?>

            <?php if ($row['boosterBrand'] != NULL) { ?>
                <td>
                    <p>Date: <?php echo $row['boosterDate']?></p>
                    <p>Brand: <?php echo $row['boosterBrand']?></p>
                    <p>Vaccinator Name: <?php echo $row['boosterVaccinator']?></p>
                    <p>Batch No: <?php echo $row['boosterBatchNo']?></p>
                    <p>Lot No: <?php echo $row['boosterLotNo']?></p>
                </td>
            <?php } else { echo '<td></td>'; } ?>

            <td><?php echo $row['facilityName'] ?></td>
            <td><?php echo $row['facilityContact'] ?></td>

            <td>
                <a target="_blank" href="uploads/<?=$row['vaccinationCard']?>">
                    <img height="100px" width="auto" src="uploads/<?=$row['vaccinationCard']?>">
                </a>
            </td>

            <td>
                <a href="archive.php?id=<?php echo $row['id'] ?>" type="submit" class="btn btn-danger btn-lg"><i class='bx bx-archive-in'></i></a>
            </td>

        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>

            