<!-- working? -->
<?php 
    include_once 'dbh.php';
    session_start();

    $id = $_GET['id'];

    $select = "SELECT * FROM vaccinationrecord WHERE id='$id' ";
    $result = mysqli_query($conn, $select);

    if($result) {
        while($row=mysqli_fetch_assoc($result)){
            $surname = $row['surname'];
            $givenName = $row['givenName'];
            $mi = $row['mi'];
            $suffix = $row['suffix'];
            $address = $row['address'];
            $contact = $row['contact'];
            $dob = $row['dob'];
            $sex = $row['sex'];
            $philhealth = $row['philhealth'];
            $category = $row['category'];
            $firstDoseDate = $row['firstDoseDate'];
            $firstDoseBrand = $row['firstDoseBrand'];
            $firstVaccinator = $row['firstVaccinator'];
            $firstBatchNo = $row['firstBatchNo'];
            $firstLotNo = $row['firstLotNo'];
            $secondDoseDate = $row['secondDoseDate'];
            $secondDoseBrand = $row['secondDoseBrand'];
            $secondVaccinator = $row['secondVaccinator'];
            $secondBatchNo = $row['secondBatchNo'];
            $secondLotNo = $row['secondLotNo'];
            $boosterDate = $row['boosterDate'];
            $boosterBrand = $row['boosterBrand'];
            $boosterVaccinator = $row['boosterVaccinator'];
            $boosterBatchNo = $row['boosterBatchNo'];
            $boosterLotNo = $row['boosterLotNo'];
            $facilityName = $row['facilityName'];
            $facilityContact = $row['facilityContact'];
            $vaccinationCard = $row['vaccinationCard'];

        }

        $insert = "INSERT INTO archive (surname, givenName, mi, suffix, address, contact, dob, sex, philhealth, category, firstDoseDate, firstDoseBrand, firstVaccinator, firstBatchNo, firstLotNo, secondDoseDate, secondDoseBrand, secondVaccinator, secondBatchNo, secondLotNo, boosterDate, boosterBrand, boosterVaccinator, boosterBatchNo, boosterLotNo, facilityName, facilityContact, vaccinationCard) VALUES ('$surname', '$givenName', '$mi', '$suffix', '$address', '$contact', '$dob', '$sex', '$philhealth', '$category', '$firstDoseDate', '$firstDoseBrand', '$firstVaccinator', '$firstBatchNo', '$firstLotNo', '$secondDoseDate', '$secondDoseBrand', '$secondVaccinator', '$secondBatchNo', '$secondLotNo', '$boosterDate', '$boosterBrand', '$boosterVaccinator', '$boosterBatchNo', '$boosterLotNo', '$facilityName', '$facilityContact', '$vaccinationCard')";
        mysqli_query($conn, $insert);

        $sql = "DELETE FROM vaccinationrecord WHERE id='$id' ";
        mysqli_query($conn,$sql);

        header('Location: adminViewArchive.php');
    }
?>