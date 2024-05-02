<!-- register.php -->
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "task_manager";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

    $email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email='$email'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div style="text-align: center;">
  <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: red; background-color: #ffdad4; border-color: #ffffff;font-weight:bolder;">
    Email already exists!
  </div>  
</div>';
header('refresh:1,url=index.php');
} else {

  $sql = "INSERT INTO users (password, email)
  VALUES ('{$_POST['password']}', '{$_POST['email']}')";

  if ($conn->query($sql) === TRUE) {
    echo "<div style='padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;'>Registration successful to<b style='color:green;text-align:center;'> {$_POST['email']}</b>. Redirecting to Login page...</p></div>";

    header('refresh:2,url=login.php');
    exit();
  } else {
    $error_message = "Error: " . $sql . "<br>" . $conn->error;
  }

}
}


$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TASK | MANAGER</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow:0 0.1rem 0.5rem #24292e;
            background:#333;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        button[type="submit"] {
            width: 100%;
            background-color: gray;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #24092e;
        }
        a:hover{
            color:#24292e;
            font-size:1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="margin-left:530px;font-family:robotto;color:#24292e;">REGISTER</h1>

        <?php if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p style="margin-left: 510px; font-size: 14px; font-weight: bold;">Already have an account? <a href="login.php"  style="color: blue; text-decoration: underline;text-decoration: none;color:gray;transition:2s ease-in-out;">Login</a></p>

    </div>
    <footer style="width:600px;margin-left:330px;">
    <p align="center" style="background:grey;color:#ffffff;font-weight:bolder;margin-top:150px;padding:15px;"> &copy;  99 DEVELOPER.Inc</p>
</footer>
</body>
</html>
