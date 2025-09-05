<?php
session_start();

// If user not login -->> validation.html
if (!isset($_SESSION['email'])) {
    header("Location: validation.html");
    exit();
}

// Take user full name from database
$email = $_SESSION['email'];
$conn = new mysqli("localhost", "root", "", "aqi");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$emailEsc = $conn->real_escape_string($email);
$sql = "SELECT fullname FROM users WHERE email='$emailEsc' LIMIT 1";
$result = $conn->query($sql);
$fullname = $email;
if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $fullname = $row['fullname'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Select Cities</title>
  <link rel="stylesheet" href="AQI.css" />
  <style>
    /* Global Styles */
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: #f4f7f9;
      color: #333;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Header */
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

    /* Form */
    h2 {
      text-align: center;
      color: #4caf50;
      margin-top: 20px;
    }
    .city-select {
      margin-top: 20px;
    }
    .city-select label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
    }
    .city-select select {
      width: 100%;
      height: 240px;
      padding: 10px;
      border: 2px solid #4caf50;
      border-radius: 4px;
      background: #f9f9f9;
      font-size: 16px;
      box-sizing: border-box;
    }
    .city-select button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background: #4caf50;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
      transition: background 0.3s;
    }
    .city-select button:hover {
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

    <h2>Select Cities to View AQI (1-10)</h2>

    <form method="POST" action="showaqi.php" class="city-select" onsubmit="return validateSelection();">
      <label for="cities">Choose cities:</label>
      <select name="cities[]" id="cities" multiple required>
        <option value="Dhaka">Dhaka</option>
        <option value="Delhi">Delhi</option>
        <option value="Tokyo">Tokyo</option>
        <option value="New York">New York</option>
        <option value="Paris">Paris</option>
        <option value="Beijing">Beijing</option>
        <option value="London">London</option>
        <option value="Karachi">Karachi</option>
        <option value="Sydney">Sydney</option>
        <option value="Sao Paulo">Sao Paulo</option>
        <option value="Istanbul">Istanbul</option>
        <option value="Moscow">Moscow</option>
        <option value="Toronto">Toronto</option>
        <option value="Cairo">Cairo</option>
        <option value="Bangkok">Bangkok</option>
        <option value="Berlin">Berlin</option>
        <option value="Madrid">Madrid</option>
        <option value="Seoul">Seoul</option>
        <option value="Rome">Rome</option>
        <option value="Dubai">Dubai</option>
      </select>
      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    function validateSelection() {
      const select = document.getElementById('cities');
      const count = Array.from(select.selectedOptions).length;
      if (count < 1) {
        alert('Please select at least one city.');
        return false;
      }
      if (count > 10) {
        alert('Please select no more than 10 cities.');
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
