<?php
session_start();

// 1. SECURITY CHECK
if (!isset($_SESSION['user_verified']) || $_SESSION['user_verified'] !== true) {
    header("Location: login.php");
    exit();
}

// 2. DATABASE CONNECTION
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "straivefl"; // CHANGE THIS to your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. HANDLE ADD/EDIT DATA (CRUD)
if (isset($_POST['save_data'])) {
    $cubicle = $_POST['cubicle_number'];
    $host = $_POST['hostname'];
    $dept = $_POST['department'];

    // Prepared statement to prevent the "Unknown column" error and SQL injection
    $stmt = $conn->prepare("INSERT INTO prod_mapping (cubicle_number, hostname, department) 
                            VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE hostname = ?, department = ?");
    $stmt->bind_param("sssss", $cubicle, $host, $dept, $host, $dept);
    
    if ($stmt->execute()) {
        header("Location: prodmap.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// 4. FETCH DATA FOR LIST AND MAP
$map_array = [];
$result = $conn->query("SELECT * FROM prod_mapping");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $map_array[$row['cubicle_number']] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Mapping | Straive</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        /* UI Styling matching your dashboard */
        body { margin: 0; background: #fafafa; font-family: 'Inter', sans-serif; }
        .header-bg { position: absolute; width: 100%; height: 200px; background: #ff6b00; z-index: 0; }
        .container { position: relative; z-index: 1; max-width: 1100px; margin: 0 auto; padding: 40px 20px; }
        
        /* Tabs */
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .tab-btn { padding: 12px 24px; border-radius: 12px; border: none; cursor: pointer; font-weight: 600; background: rgba(255,255,255,0.2); color: white; transition: 0.3s; }
        .tab-btn.active { background: white; color: #ff6b00; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        .white-card { background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-height: 400px; }

        /* BLUEPRINT GRID */
        .blueprint { 
            display: grid; 
            grid-template-columns: repeat(6, 1fr); 
            gap: 15px; 
            background: #fdfdfd; 
            border: 2px solid #ddd; 
            padding: 40px; 
            border-radius: 15px;
            position: relative;
            margin-top: 20px;
        }
        .cubicle { 
            border: 2px solid #eee; padding: 15px; border-radius: 10px; text-align: center;
            background: #fff; transition: 0.3s; min-height: 80px; display: flex; flex-direction: column; justify-content: center;
        }
        .cubicle.occupied { border-color: #ff6b00; background: #fffcf9; box-shadow: 0 4px 10px rgba(255, 107, 0, 0.1); }
        .cubicle-num { font-size: 10px; font-weight: 800; color: #999; display: block; margin-bottom: 4px; }
        .host-display { font-size: 13px; font-weight: 700; color: #1a1a1a; margin: 2px 0; overflow: hidden; text-overflow: ellipsis; }
        .dept-display { font-size: 11px; color: #ff6b00; font-weight: 600; }

        /* Furniture Icons */
        .door { width: 80px; height: 8px; background: #8d6e63; position: absolute; top: -4px; left: 50px; border-radius: 4px; }
        .tv-wall { width: 150px; height: 10px; background: #333; position: absolute; bottom: -5px; right: 100px; border-radius: 5px; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; color: #999; font-size: 12px; padding: 15px; border-bottom: 2px solid #fafafa; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #fafafa; font-size: 14px; }
        
        /* Form Inputs */
        .form-group { display: flex; gap: 10px; margin-bottom: 25px; background: #fdfdfd; padding: 20px; border-radius: 15px; border: 1px solid #eee; }
        input[type="text"] { flex: 1; padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-family: 'Inter', sans-serif; }
        .btn-save { background: #ff6b00; color: white; border: none; padding: 0 25px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-save:hover { background: #e65a00; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="header-bg"></div>

<div class="container">
    <div style="color: white; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="margin: 0; font-weight: 800; letter-spacing: -1px;">Production Floor Manager</h1>
            <p style="margin: 5px 0 0; opacity: 0.8;">Map your office hardware to physical locations</p>
        </div>
        <a href="dashboard.php" style="color: white; text-decoration: none; font-size: 13px; font-weight: 600; background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 8px;">Back to Home</a>
    </div>

    <div class="tabs">
        <button id="btn-port" class="tab-btn active" onclick="showTab('port')">Port Mapping (List)</button>
        <button id="btn-prod" class="tab-btn" onclick="showTab('prod')">Production Map (Visual)</button>
    </div>

    <div id="port-tab" class="white-card">
        <h3 style="margin-top: 0;">Seat Assignments</h3>
        
        <form method="POST" class="form-group">
            <input type="text" name="cubicle_number" placeholder="Cubicle # (e.g. C1)" required>
            <input type="text" name="hostname" placeholder="Hostname" required>
            <input type="text" name="department" placeholder="Department" required>
            <button type="submit" name="save_data" class="btn-save">Update Map</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Cubicle #</th>
                    <th>Hostname</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($map_array)): ?>
                    <tr><td colspan="3" style="text-align:center; color:#999; padding:40px;">No data assigned yet. Use the form above to add your first seat.</td></tr>
                <?php else: ?>
                    <?php foreach($map_array as $row): ?>
                    <tr>
                        <td><b><?php echo htmlspecialchars($row['cubicle_number']); ?></b></td>
                        <td><?php echo htmlspecialchars($row['hostname']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="prod-tab" class="white-card" style="display:none;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0;">Floor Plan Blueprint</h3>
        <span style="font-size: 12px; color: #666; font-weight: 600;">
            <span style="color: #ff6b00; margin-right: 5px;">●</span> Occupied Cubicle
        </span>
    </div>
    
    <div class="blueprint">
        <div class="door"></div> 
        
        <?php 
        if (empty($map_array)) {
            echo "<p style='grid-column: span 6; text-align: center; padding: 50px; color: #999;'>No cubicles mapped yet. Go to Port Mapping to add one.</p>";
        } else {
            // This loop now looks at EVERYTHING in your database
            foreach($map_array as $cubicle_id => $data): 
            ?>
                <div class="cubicle occupied">
                    <span class="cubicle-num"><?php echo htmlspecialchars($cubicle_id); ?></span>
                    <div class="host-display">
                        <?php echo htmlspecialchars($data['hostname']); ?>
                    </div>
                    <div class="dept-display">
                        <?php echo htmlspecialchars($data['department']); ?>
                    </div>
                </div>
            <?php 
            endforeach; 
        }
        ?>
        
        <div class="tv-wall"></div> 
    </div>
</div>
</div>

<script>
function showTab(type) {
    const portTab = document.getElementById('port-tab');
    const prodTab = document.getElementById('prod-tab');
    const btnPort = document.getElementById('btn-port');
    const btnProd = document.getElementById('btn-prod');

    if (type === 'port') {
        portTab.style.display = 'block';
        prodTab.style.display = 'none';
        btnPort.classList.add('active');
        btnProd.classList.remove('active');
    } else {
        portTab.style.display = 'none';
        prodTab.style.display = 'block';
        btnPort.classList.remove('active');
        btnProd.classList.add('active');
    }
}
</script>

</body>
</html>