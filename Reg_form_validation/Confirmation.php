<?php
session_start();

if (isset($_POST['cancel'])) {
    header("Location: validation.html");
    exit();
}

if (isset($_POST['confirm'])) {
    // cookie set for color
    if (isset($_SESSION['color'])) {
        setcookie("bgColor", $_SESSION['color'], time() + (86400 * 30), "/");
    }

    // Database connection
    $conn = new mysqli("localhost", "root", "", "aqi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fullname = $conn->real_escape_string($_SESSION['fullname']);
    $email = $conn->real_escape_string($_SESSION['email']);
    $password = $conn->real_escape_string($_SESSION['password']);
    $dob = $conn->real_escape_string($_SESSION['dob']);
    $country = $conn->real_escape_string($_SESSION['country']);
    $gender = $conn->real_escape_string($_SESSION['gender']);
    $description = $conn->real_escape_string($_SESSION['description']);

    
    $sql = "INSERT INTO users (fullname, email, password, dob, country, gender, description)
            VALUES ('$fullname', '$email', '$password', '$dob', '$country', '$gender', '$description')";

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <title>Registration Confirmed</title>
      <style>
        body {
          background-color: #e0ffe0;
          font-family: Arial, sans-serif;
          text-align: center;
          padding-top: 100px;
        }
        h2 {
          color: green;
        }
        a {
          display: inline-block;
          margin-top: 20px;
          text-decoration: none;
          color: #333;
          padding: 10px 20px;
          border: 1px solid #333;
          border-radius: 5px;
        }
        a:hover {
          background-color: #c8e6c9;
        }
      </style>
    </head>
    <body>";

    if ($conn->query($sql) === TRUE) {
        echo "<h2>Registration Confirmed Successfully!</h2>";
        echo "<p>Thank you for registering, " . htmlspecialchars($fullname) . ".</p>";
        echo "<a href='validation.html'>Return to Login</a>";
    } else {
        echo "<h2 style='color: red;'>❌ Registration Failed</h2>";
        echo "<p>Error: " . $conn->error . "</p>";
        echo "<a href='validation.html'>Try Again</a>";
    }

    echo "</body></html>";

    $conn->close();
}
?>
