<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fullname'])) {
    // Store user data in session for later
    $_SESSION['fullname'] = $_POST['fullname'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['country'] = $_POST['country'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['color'] = $_POST['color'];
    $_SESSION['description'] = $_POST['description'];
    $_SESSION['terms'] = isset($_POST['terms']) ? 'Yes' : 'No';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Confirm Your Information</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .container {
      background: white;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 90%;
      text-align: center;
    }
    h2 {
      color: #333;
      margin-bottom: 25px;
    }
    ul {
      list-style-type: none;
      padding: 0;
      margin: 0 0 30px 0;
      text-align: left;
      color: #555;
    }
    ul li {
      padding: 10px 0;
      border-bottom: 1px solid #eee;
      font-size: 16px;
    }
    ul li:last-child {
      border-bottom: none;
    }
    .btn-group {
      display: flex;
      justify-content: space-around;
      gap: 20px;
    }
    button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 12px 28px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      flex: 1;
    }
    button:hover {
      background-color: #45a049;
    }
    button.cancel {
      background-color: #f44336;
    }
    button.cancel:hover {
      background-color: #d9362e;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Confirm Your Information</h2>
    <ul>
      <li><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['fullname']); ?></li>
      <li><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></li>
      <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($_SESSION['dob']); ?></li>
      <li><strong>Country:</strong> <?php echo htmlspecialchars($_SESSION['country']); ?></li>
      <li><strong>Gender:</strong> <?php echo htmlspecialchars($_SESSION['gender']); ?></li>
      <li><strong>Favorite Color:</strong> <span style="display:inline-block; width:20px; height:20px; background:<?php echo htmlspecialchars($_SESSION['color']); ?>; border-radius:50%; vertical-align:middle; margin-left:5px;"></span></li>
      <li><strong>Description:</strong><br /><?php echo nl2br(htmlspecialchars($_SESSION['description'])); ?></li>
    </ul>

    <form method="post" action="confirmation.php" class="btn-group">
      <button type="submit" name="confirm">Confirm</button>
      <button type="submit" name="cancel" class="cancel">Cancel</button>
    </form>
  </div>
</body>
</html>
