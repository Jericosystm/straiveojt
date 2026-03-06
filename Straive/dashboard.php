<?php
session_start();

// 1. SECURITY CHECK: We use 'user_verified' to match your OTP script
if (!isset($_SESSION['user_verified']) || $_SESSION['user_verified'] !== true) {
    header("Location: login.php");
    exit();
}

// Get the email for the welcome message
$user_email = isset($_SESSION['auth_email']) ? $_SESSION['auth_email'] : "User";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Straive</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; background: #fafafa; font-family: 'Inter', sans-serif; color: #1a1a1a;">

    <div style="position: absolute; width: 100%; height: 200px; background: #ff6b00; z-index: 0;"></div>

    <div style="position: relative; z-index: 1; max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; color: white;">
            <div>
                <h1 style="margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -1px;">Straive Portal</h1>
                <p style="margin: 5px 0 0; opacity: 0.8; font-size: 14px;">Welcome back, <?php echo htmlspecialchars($user_email); ?></p>
            </div>
            <a href="logout.php" style="background: rgba(255,255,255,0.2); color: white; text-decoration: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">Logout</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px;">
            <a href="mm.php" style="text-decoration: none; background: white; padding: 30px; border-radius: 24px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s transform;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="color: #ff6b00; font-size: 30px; margin-bottom: 15px;">⚙️</div>
                <div style="font-weight: 700; color: #1a1a1a; font-size: 14px;">Machine Movement</div>
            </a>
            <a href="#" style="text-decoration: none; background: white; padding: 30px; border-radius: 24px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s transform;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="color: #ff6b00; font-size: 30px; margin-bottom: 15px;">📍</div>
                <div style="font-weight: 700; color: #1a1a1a; font-size: 14px;">Production Mapping</div>
            </a>
            <a href="#" style="text-decoration: none; background: white; padding: 30px; border-radius: 24px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s transform;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="color: #ff6b00; font-size: 30px; margin-bottom: 15px;">💻</div>
                <div style="font-weight: 700; color: #1a1a1a; font-size: 14px;">Winbase</div>
            </a>
            <a href="#" style="text-decoration: none; background: white; padding: 30px; border-radius: 24px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s transform;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="color: #ff6b00; font-size: 30px; margin-bottom: 15px;">📁</div>
                <div style="font-weight: 700; color: #1a1a1a; font-size: 14px;">HDN</div>
            </a>
            <a href="#" style="text-decoration: none; background: white; padding: 30px; border-radius: 24px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s transform;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="color: #ff6b00; font-size: 30px; margin-bottom: 15px;">📚</div>
                <div style="font-weight: 700; color: #1a1a1a; font-size: 14px;">Knowledgebase</div>
            </a>
        </div>

        <p style="text-align: center; color: #999; font-size: 12px; margin-top: 60px;">&copy; 2026 Straive Intelligent Solutions</p>
    </div>

</body>
</html>