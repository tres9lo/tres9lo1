<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the update button was clicked
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the task data
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
                echo "<form method='post' style='display: flex; flex-direction: column; align-items: center; padding: 20px; border: 1px solid #ccc; border-radius: 5px;'>";
echo "<input type='hidden' name='id' value='$id'>";

echo "<label style='color: gray; font-weight: bold;'>Task:</label>";
echo "<input style='width: 400px; background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 8px; margin-bottom: 15px;' type='text' name='task' value='" . $row['title'] . "' required>";

echo "<label style='color: gray; font-weight: bold;'>Description:</label>";  
echo "<textarea style='width: 400px; background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 8px; margin-bottom: 15px;' name='description'>" . $row['description'] . "</textarea>";

echo "<label style='color: gray; font-weight: bold;'>Due Date:</label>";
echo "<input style='width: 400px; background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 8px; margin-bottom: 15px;' type='date' name='due_date' value='" . $row['due_date'] . "'>";

echo "<label style='color: gray; font-weight: bold;'>Priority:</label>";
echo "<select style='width: 400px; background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 8px; margin-bottom: 15px;' name='priority'>";
echo "<option value='High'" . ($row['priority'] == 'High' ? " selected" : "") . ">High</option>";
echo "<option value='Medium'" . ($row['priority'] == 'Medium' ? " selected" : "") . ">Medium</option>";  
echo "<option value='Low'" . ($row['priority'] == 'Low' ? " selected" : "") . ">Low</option>";
echo "</select>";

echo "<label style='color: gray; font-weight: bold;'>Status:</label>";
echo "<select style='width: 400px; background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 8px; margin-bottom: 15px;' name='status'>";
echo "<option value='To Do'" . ($row['status'] == 'To Do' ? " selected" : "") . ">To Do</option>";
echo "<option value='In Progress'" . ($row['status'] == 'In Progress' ? " selected" : "") . ">In Progress</option>";
echo "<option value='Completed'" . ($row['status'] == 'Completed' ? " selected" : "") . ">Completed</option>";
echo "</select>";

echo "<input style='background-color: #6c757d; color: white; border: 1px solid #007bff; border-radius: 4px; padding: 8px; cursor: pointer;' type='submit' name='update' value='Update Task'>";
echo "<a href='index.php' style='background-color: tomato; color: white; border: 1px solid #007bff; border-radius: 4px; padding: 8px; cursor: pointer;text-decoration:none;'>Cancel</a>";


echo "</form>";


        
        if (isset($_POST['update'])) {
          // Update task in database
          
          $task = $_POST['task'];
          $description = $_POST['description'];
          $due_date = $_POST['due_date'];
          $priority = $_POST['priority'];
          $status = $_POST['status'];
          
          $sql = "UPDATE tasks SET title='$task', description='$description', due_date='$due_date', priority='$priority', status='$status' WHERE id='$id'";
          
          if ($conn->query($sql) === TRUE) {
            echo "Task updated successfully!";
          } else {
            echo "Error updating task: " . $conn->error;
          }
          
          header("Location: index.php");
          exit();
        
        }


    } else {
        echo "Task not found.";
    }

}

if (isset($_POST['update'])) {
  // Update task in database
  
  echo "Task updated successfully!";
  
  header("Location: index.php");
  exit();

}

// Close database connection
$conn->close();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT | PAGE</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
</head>
<body>
    
</body>
</html>
