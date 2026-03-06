<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['n1'] . $_POST['n2'] . $_POST['n3'] . $_POST['n4'];

    if (isset($_SESSION['generated_otp']) && $user_otp == $_SESSION['generated_otp']) {
        
        // THIS MUST MATCH THE DASHBOARD CHECK EXACTLY
        $_SESSION['user_verified'] = true; 
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error_msg = "Invalid code.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<body style="margin: 0; height: 100vh; display: flex; align-items: center; justify-content: center; background: #ffffff; font-family: 'Inter', sans-serif; color: #1a1a1a;">

    <div style="position: absolute; width: 100%; height: 100%; background-image: radial-gradient(#ff6b00 0.5px, transparent 0.5px); background-size: 24px 24px; opacity: 0.05; z-index: 0;"></div>

    <div style="position: relative; z-index: 1; width: 100%; max-width: 400px; padding: 48px; background: #ffffff; border: 1px solid #f0f0f0; border-radius: 32px; box-shadow: 0 20px 40px rgba(255, 107, 0, 0.08);">
        
        <div style="width: 56px; height: 56px; background: #fff5ed; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff6b00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>

        <h1 style="font-size: 32px; font-weight: 800; margin: 0; letter-spacing: -1px;">Verify</h1>
        <p style="font-size: 15px; color: #666; margin-top: 10px; margin-bottom: 32px;">Please enter the 4-digit code sent to your device.</p>

        <form action="" method="POST">
            <div style="display: flex; gap: 12px; justify-content: center; margin-bottom: 32px;">
                <input type="text" name="n1" maxlength="1" oninput="if(this.value.length==1) this.nextElementSibling.focus()" required style="width: 60px; height: 60px; text-align: center; font-size: 24px; font-weight: 700; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; background: #fafafa;" onfocus="this.style.borderColor='#ff6b00'">
                <input type="text" name="n2" maxlength="1" oninput="if(this.value.length==1) this.nextElementSibling.focus()" required style="width: 60px; height: 60px; text-align: center; font-size: 24px; font-weight: 700; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; background: #fafafa;" onfocus="this.style.borderColor='#ff6b00'">
                <input type="text" name="n3" maxlength="1" oninput="if(this.value.length==1) this.nextElementSibling.focus()" required style="width: 60px; height: 60px; text-align: center; font-size: 24px; font-weight: 700; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; background: #fafafa;" onfocus="this.style.borderColor='#ff6b00'">
                <input type="text" name="n4" maxlength="1" required style="width: 60px; height: 60px; text-align: center; font-size: 24px; font-weight: 700; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; background: #fafafa;" onfocus="this.style.borderColor='#ff6b00'">
            </div>

            <button type="submit" 
                onmouseover="this.style.background='#e66000'; this.style.boxShadow='0 8px 20px rgba(255, 107, 0, 0.2)';" 
                onmouseout="this.style.background='#ff6b00'; this.style.boxShadow='none';"
                style="width: 100%; padding: 16px; background: #ff6b00; color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">
                Verify Code
            </button>
        </form>

        <p style="text-align: center; margin-top: 25px; font-size: 13px; color: #999;">
            Didn't receive it? <a href="login.php" style="color: #ff6b00; text-decoration: none; font-weight: 600;">Try again</a>
        </p>
    </div>
</body>
</html>