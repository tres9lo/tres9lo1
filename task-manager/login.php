<!-- login.php -->
<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

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


    $sql = "SELECT id, email, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];


        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row["id"];
            echo "<div style='text-align: center;'>
            <div style='padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;'
                <p><b>Welcome, 
    {$_POST['email']}</b>. Redirecting to home page...</p>
            </div>  
          </div>";

            header('refresh:1,url=index.php');
            exit();
        } else {
            echo '<div style="text-align: center;">
            <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: red; background-color: #ffdad4; border-color: #d6e9c6;">
             Invalid email or password.
            </div>  
          </div>';
          header('refresh:1,url=login.php');
        }
    } else {
        echo '<div style="text-align: center;">
        <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: red; background-color: #ffdad4; border-color: #d6e9c6;">
Invalid email or password.
        </div>  
      </div>';
      header('refresh:1,url=login.php');
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TASK | MANAGER</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<style>
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background:#333;
            box-shadow:0 0.1rem 0.5rem #24292e;
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
            font-size:1rem;
        }
    </style>

    <div class="container">
        <h1 style="margin-left:560px; font-family: times new roman;color:#24292e;">LOGIN</h1>


        <?php if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p style="margin-left: 510px; font-size: 14px; font-weight: bold;">Don't have an account? <a href="register.php" style="text-decoration: none;color:gray;transition:2s ease-in-out;">Register</a></p>
</div>
    <footer style="width:600px;margin-left:330px;">
    <p align="center" style="background:grey;color:#ffffff;font-weight:bolder;margin-top:150px;padding:15px;"> &copy; 99 DEVELOPER.Inc</p>
</footer>
</body>
</html>