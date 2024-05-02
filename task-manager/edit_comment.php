<!-- update_task.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
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

// Get comment ID
$comment_id = $_GET['id'];


// HTML form
echo '<form method="post" style="width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
  echo '<div style="margin-bottom: 10px; text-align: center;">';
    echo '<label for="comment" style="display:block; font-weight: bold; font-size: 18px;">Comment</label>';
    echo '<textarea name="comment" style="width: 100%; height: 200px; padding: 10px; font-size: 16px;"></textarea>';
  echo '</div>';
  
  echo '<div style="display: flex; justify-content: center;">';
    echo '<button type="submit" style="padding: 10px 20px; background-color: #24292e; color: #fff; border: none; border-radius: 5px; margin-right: 10px; font-size: 16px;">Update</button>';
    echo '<a href="index.php" style="padding: 10px 20px; background-color: tomato; color: #000; border: none; border-radius: 5px; margin-left: 10px; font-size: 16px;text-decoration:none;">Cancel</a>';
  echo '</div>';
echo '</form>';

if(isset($_POST['comment'])) {

// Get comment data
$comment = $_POST['comment'];

// Database update query
$query = "UPDATE comments SET comment='$comment' WHERE id=$comment_id";

if ($conn->query($query) === TRUE) {
  echo '<div style="text-align: center;">
  <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;">
    Comment Edited  successfully!
  </div>  
</div>';
header("Refresh:1; url=index.php");
} else {
  echo "Error updating comment: " . $conn->error;
}
}


