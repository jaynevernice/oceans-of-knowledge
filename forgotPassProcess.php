<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'></link>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <title></title>
</head>
<body>
    
    <?php
        if(isset($_POST['reset'])) {
            $email = $_POST['email'];
        }
        else {
            exit();
        }

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        require 'mail/Exception.php';
        require 'mail/PHPMailer.php';
        require 'mail/SMTP.php';
        
        // Instantiation and passing `true` enables exceptions
        //$password = "Bon_99Bon";
        $mail = new PHPMailer(true);
        //global $password;
        
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            //$mail->Host = 'localhost';
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->SMTPSecure = "tls";
            $mail->Username   = 'bonbbon00@gmail.com';                     // SMTP username
            $mail->Password   = 'oikmwnxsnmmbntpq';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;
            //$mail->SMTPDebug = 1;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,                        // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );                                     
        
            //Recipients
            $mail->setFrom('bonbbon@gmail.com', 'Oceans of Knowledge Admin');
            $mail->addAddress($email);     // Add a recipient

            $code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'),0,10);
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password Reset';
            $mail->Body    = 'To reset your password click <a href="http://localhost/oceansofknowledge/changePass.php?code='.$code.'">here.</a>.';

            $conn = new mySqli('localhost', 'root', '', 'oceansofknowledge');

            if($conn->connect_error) {
                die('Could not connect to the database.');
            }

            $verifyQuery = $conn->query("SELECT * FROM login WHERE email = '$email'");

            if($verifyQuery->num_rows) {
                $codeQuery = $conn->query("UPDATE login SET code = '$code' WHERE email = '$email'");
                    
                $mail->send();
            
                //echo '<h1>Message has been sent, check your email</h1>';?>
                <script>
                    swal({
                        title:"Success!",
                        text:"Message has been sent! Check your Email.",
                        type:"success"
                    }).then(function() {
                        window.location = "index.php";
                    });
                </script>
            <?php } $conn->close();
        
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; ?>
            <script>
                swal({
                    title:"Error!",
                    text:"Message could not be sent! Mailer Error!",
                    type:"error"
                }).then(function() {
                    window.location = "forgotPass.php";
                });
            </script>
        <?php } ?>
</body>
</html>