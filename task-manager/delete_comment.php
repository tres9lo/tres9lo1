<!-- delete_comment.php -->
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
$id = $_GET['id'];

// Delete the task from the database
$sql = "DELETE FROM comments WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo '<div style="text-align: center;">
  <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;">
    Comment deleted successfully!
  </div>  
</div>';


header("Refresh:1; url=index.php");



} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
