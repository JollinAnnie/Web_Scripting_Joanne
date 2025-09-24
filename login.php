<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<p style='color:red;'>Invalid email format. Please go back and try again.</p>");
    }

    $dataFile = "users.json";
    $newData = [
        "email" => $email,
        "password" => $password,
        "timestamp" => date("Y-m-d H:i:s")
    ];

    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $arr = json_decode($json, true);
    } else {
        $arr = [];
    }

    $arr[] = $newData;
    file_put_contents($dataFile, json_encode($arr, JSON_PRETTY_PRINT));


    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
  <section class="wrapper">
    <div class="form login">
      <header id="loginHeader">Login</header>
      <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Enter Email Address" required/>
        <input type="password" name="password" placeholder="Enter Password" required/>
        <a href="#">Forgot Password?</a>
        <a href="registration.php">Register</a>
        <input type="submit" value="Login"/>
      </form>
    </div>
  </section>
</body>
</html>
