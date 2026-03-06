<?php
// 1. IMPORT PHPMAILER AT THE VERY TOP
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

session_start();

// 2. DATABASE CONNECTION
$host = "localhost";
$user = "root"; 
$pass = ""; 
$dbname = "straivefl";

$conn = mysqli_connect($host, $user, $pass, $dbname);
$error_msg = "";

// 3. LOG IN LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // CHECK IF PASSWORD IS CORRECT (Secure way + Plain text fallback)
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            
            // --- LOGIN SUCCESS: GENERATE & SEND OTP ---
            $otp_code = rand(1000, 9999);
            $_SESSION['generated_otp'] = $otp_code;
            $_SESSION['auth_email'] = $email;

            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'jerico.amata09@gmail.com';     // YOUR GMAIL
                $mail->Password   = 'hnzy kjmu uwjh ukdw';      // YOUR 16-CHAR APP PASSWORD
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('your-gmail@gmail.com', 'Straive Security');
                $mail->addAddress($email); 

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Verification Code';
                $mail->Body    = "
                    <div style='font-family: sans-serif; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
                        <h2 style='color: #ff6b00;'>Security Verification</h2>
                        <p>Your login code for Straive is:</p>
                        <div style='font-size: 32px; font-weight: bold; color: #ff6b00; letter-spacing: 5px;'>$otp_code</div>
                        <p style='color: #666; font-size: 12px; margin-top: 20px;'>If you did not request this, please ignore this email.</p>
                    </div>";

                $mail->send();
                
                header("Location: otp.php");
                exit();
                
            } catch (Exception $e) {
                $error_msg = "Email error: {$mail->ErrorInfo}";
            }
        } else {
            $error_msg = "Incorrect password.";
        }
    } else {
        $error_msg = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In | Straive</title>
</head>
<body style="margin: 0; height: 100vh; display: flex; align-items: center; justify-content: center; background: #ffffff; font-family: 'Inter', sans-serif;">
    
    <div style="position: absolute; width: 100%; height: 100%; background-image: radial-gradient(#ff6b00 0.5px, transparent 0.5px); background-size: 24px 24px; opacity: 0.05; z-index: 0;"></div>

    <div style="width: 100%; max-width: 400px; padding: 48px; background: #ffffff; border: 1px solid #f0f0f0; border-radius: 32px; box-shadow: 0 20px 40px rgba(255, 107, 0, 0.08); position: relative; z-index: 1;">
        <h1 style="color: #ff6b00; margin-bottom: 20px; font-weight: 800;">Log In</h1>
        
        <?php if ($error_msg): ?>
            <div style="color: #ff6b00; background: #fff5ed; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; text-align: center; font-weight: 600; border: 1px solid #ff6b00;">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">Email Address</label>
            <input type="email" name="email" placeholder="name@company.com" required style="width: 100%; padding: 14px; margin-bottom: 20px; border-radius: 12px; border: 2px solid #f0f0f0; outline: none; box-sizing: border-box;">
            
            <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">Password</label>
            <input type="password" name="password" placeholder="••••••••" required style="width: 100%; padding: 14px; margin-bottom: 30px; border-radius: 12px; border: 2px solid #f0f0f0; outline: none; box-sizing: border-box;">
            
            <button type="submit" style="width: 100%; padding: 16px; background: #ff6b00; color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                Log In
            </button>
        </form>
    </div>
</body>
</html>