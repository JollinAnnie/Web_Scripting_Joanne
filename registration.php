<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; 
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $hobbies = isset($_POST['hobbies']) ? $_POST['hobbies'] : [];
    $country = htmlspecialchars($_POST['country']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<p style='color:red;'>Invalid email format. <a href='registration.php'>Go back</a></p>");
    }

    if ($password !== $confirm_password) {
        die("<p style='color:red;'>Passwords do not match. <a href='registration.php'>Go back</a></p>");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $dataFile = "users.json";
    $newUser = [
        "fullname" => $fullname,
        "email" => $email,
        "username" => $username,
        "password" => $hashedPassword,
        "gender" => $gender,
        "hobbies" => $hobbies,
        "country" => $country,
        "timestamp" => date("Y-m-d H:i:s")
    ];

    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $arr = json_decode($json, true);
    } else {
        $arr = [];
    }

    $arr[] = $newUser;
    file_put_contents($dataFile, json_encode($arr, JSON_PRETTY_PRINT));

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <section class="wrapper">
        <div class="form login">
            <header>Register</header>
            <form action="registration.php" method="post">
                <label>Full Name </label>
                <input type="text" name="fullname" placeholder="Enter Full Name" required/>

                <label>Email </label>
                <input type="email" name="email" placeholder="Enter Email Address" required/>

                <label>Username </label>
                <input type="text" name="username" placeholder="Enter Username" required/>

                <label>Password </label>
                <input type="password" name="password" placeholder="Enter Password" required/>

                <label>Confirm Password </label>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required/>

                <div>
                    <label>Gender: </label>
                    <label><input type="radio" name="gender" value="Male" required> Male</label>
                    <label><input type="radio" name="gender" value="Female"> Female</label>
                </div>

                <div>
                    <label>Hobbies: </label>
                    <label><input type="checkbox" name="hobbies[]" value="Dancing"> Dancing</label>
                    <label><input type="checkbox" name="hobbies[]" value="Singing"> Singing</label>
                </div>

                <label for="country">Country:</label>
                <select name="country" id="country" required>
                    <option value="">--Select--</option>
                    <option value="Philippines">Philippines</option>
                    <option value="South Korea">South Korea</option>
                    <option value="Japan">Japan</option>
                    <option value="USA">USA</option>
                </select>

                <a href="login.php">Already have an account?</a>
                <input type="submit" value="Register"/>
            </form>
        </div>
    </section>
</body>
</html>
