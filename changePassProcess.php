<?php
    if(isset($_GET['code'])) {
        $code = $_GET['code'];

        $conn = new mySqli('localhost', 'root', '', 'oceansofknowledge');
        if($conn->connect_error) {
            die('Could not connect to the database');
        }

        $verifyQuery = $conn->query("SELECT * FROM login WHERE code = '$code'");

        if($verifyQuery->num_rows == 0) {
            header("Location: index.php");
            exit();
        }

        if(isset($_POST['change'])) {
            $email = $_POST['email'];
            $new_password = md5($_POST['new_password']);

            $changeQuery = $conn->query("UPDATE login SET password = '$new_password' WHERE email = '$email' and code = '$code'");

            if($changeQuery) {
                header("Location: success.php");
            }
        }
        $conn->close();
    }
    else {
        header("Location: index.php");
        exit();
    }
?>