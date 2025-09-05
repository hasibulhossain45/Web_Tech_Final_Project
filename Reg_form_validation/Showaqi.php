<?php
session_start();

// User login check
if (!isset($_SESSION['email'])) {
    header("Location: validation.html");
    exit();
}

// Cookie for background color
$bgColor = isset($_COOKIE['bgColor']) ? $_COOKIE['bgColor'] : "#f4f7f9";


$email = $_SESSION['email'];
$conn = new mysqli("localhost", "root", "", "aqi");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$emailEsc = $conn->real_escape_string($email);
$sqlName = "SELECT fullname FROM users WHERE email='$emailEsc' LIMIT 1";
$resName = $conn->query($sqlName);
$fullname = $email;
if ($resName && $resName->num_rows === 1) {
    $rowName = $resName->fetch_assoc();
    $fullname = $rowName['fullname'];
}

// City selection process
if (!isset($_POST['cities']) || !is_array($_POST['cities'])) {
    echo "<p>No cities selected. <a href='Request.php'>Go back</a></p>";
    exit();
}
$cities = $_POST['cities'];
$count = count($cities);
if ($count < 1 || $count > 10) {
    echo "<p>Invalid number of cities selected. <a href='Request.php'>Go back</a></p>";
    exit();
}

// sanitize & in cloz
$escaped = array_map([$conn, 'real_escape_string'], $cities);
$in = "'" . implode("','", $escaped) . "'";
$query = "SELECT city, country, aqi FROM info WHERE city IN ($in)";
$data = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your AQI Results</title>
  <link rel="stylesheet" href="AQI.css">
  <style>
    body {
      background-color: <?php echo htmlspecialchars($bgColor); ?>;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, sans-serif;
    }
    .container {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #4caf50;
      color: #fff;
      padding: 10px 20px;
      border-radius: 4px;
    }
    .header p {
      margin: 0;
      font-size: 18px;
      font-weight: 600;
    }
    .header a {
      text-decoration: none;
      color: #fff;
      background-color: #f44336;
      padding: 8px 12px;
      border-radius: 4px;
      transition: background-color 0.3s;
    }
    .header a:hover {
      background-color: #d32f2f;
    }
    h2 {
      text-align: center;
      color: #4caf50;
      margin-top: 20px;
    }
    #aqiTable {
      margin: 20px auto;
    }
    .btn-back {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      background: #4caf50;
      color: #fff;
      padding: 10px 16px;
      border-radius: 4px;
      transition: background 0.3s;
    }
    .btn-back:hover {
      background: #45a049;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <p>Welcome, <?php echo htmlspecialchars($fullname); ?></p>
      <a href="logout.php">Logout</a>
    </div>

    <h2>Your Selected Cities AQI</h2>

    <?php if ($data && $data->num_rows > 0): ?>
      <table id="aqiTable">
        <thead>
          <tr>
            <th>City</th>
            <th>Country</th>
            <th>AQI</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $data->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['city']); ?></td>
              <td><?php echo htmlspecialchars($row['country']); ?></td>
              <td><?php echo htmlspecialchars($row['aqi']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No AQI data found for selected cities.</p>
    <?php endif; ?>

    <a href="Request.php" class="btn-back">Choose Again</a>
  </div>
</body>
</html>
<?php
$conn->close();
?>
