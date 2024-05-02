<!-- create_task.php -->
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

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Get the form data
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$due_date = $_POST['due_date'];
$status = $_POST['status'];

// Insert the new task into the database
$sql = "INSERT INTO tasks (user_id, title, description, priority, due_date, status) VALUES ('$user_id', '$title', '$description', '$priority', '$due_date', '$status')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "<div class='task' data-id='$last_id'>";
    echo "<h3>$title</h3>";
    echo "<p>Description: $description</p>";
    echo "<p>Priority: $priority</p>";
    echo "<p>Due Date: $due_date</p>";
    echo "<p>Status: $status</p>";
    echo "<button class='complete-btn'>Mark as Complete</button>";
    echo "<button class='edit-btn'>Edit</button>";
    echo "<button class='delete-btn'>Delete</button>";
    echo "</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>