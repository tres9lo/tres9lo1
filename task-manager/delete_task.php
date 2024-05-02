<!-- delete_task.php -->
<?php
session_start();

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

// Get the task ID
$task_id = $_GET['id'];

// Delete the task from the database
$sql = "DELETE FROM tasks WHERE id = $task_id";

if ($conn->query($sql) === TRUE) {
    echo '<div style="text-align: center;">
    <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #fff; background-color: tomato; border-color: #d6e9c6;">
      Task deleted successfully!
    </div>  
  </div>';
  header("Refresh:1; url=index.php");
  exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
