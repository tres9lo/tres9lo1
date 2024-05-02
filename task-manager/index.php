<!-- index.php -->
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

// Fetch tasks from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = $user_id ORDER BY due_date";
$result = $conn->query($sql);
// Update task
if (isset($_POST['edit'])) {
    $taskId = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $dueDate = $_POST['due_date'];
    $status = $_POST['status'];

    $updateSql = "UPDATE tasks SET title = '$title', description = '$description', priority = '$priority', due_date = '$dueDate', status = '$status' WHERE id = $taskId";

    if ($conn->query($updateSql) === true) {
        $updatedTask = "<div class='task' data-id='" . $taskId . "'>";
        $updatedTask .= "<h3 style='color:rgb(4, 4, 49);'>" . $title . "</h3>";
        $updatedTask .= "<p style='color:cadetblue;'>Description: " . $description . "</p>";
        $updatedTask .= "<p style='color:cadetblue;'>Priority: " . $priority . "</p>";
        $updatedTask .= "<p style='color:cadetblue;'>Due Date: " . $dueDate . "</p>";
        $updatedTask .= "<p style='color:cadetblue;'>Status: " . $status . "</p>";
        $updatedTask .= "<button class='complete-btn'>Mark as Complete</button>";
        $updatedTask .= "<button class='edit-btn' href='update_task.php'>Edit</button>";
        $updatedTask .= "<button class='delete-btn'>Delete</button>";
        $updatedTask .= "</div>";

        echo $updatedTask;
    } else {
        echo "Error updating task: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
        }
        
        header h1 {
            margin: 0;
        }
        
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        
        nav li {
            margin-right: 1rem;
        }
        
        nav a {
            color: #fff;
            text-decoration: none;
        }
        
        main {
            max-width: 800px;
            margin: 1rem auto;
            padding: 1rem;
        }
        
        .task {
            background-color: #666;

            padding: 1rem;
            margin-bottom: 1rem;
            border-radius:10px;
            box-shadow:0 0.1rem 0.5rem #24292e;
        }
        
        button {
            background-color: #24292e;
            border: none;
            color: white;
            margin-right:10px;
            padding: 0.5rem 1rem;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            box-shadow:0 0.1rem 0.5rem #24292e;
            cursor: pointer;
            transition: 0.5s ease;
        }
        button:hover{
            transform:scale(1.1);
        }
        .edit{
            background-color: #24292e;
            border: none;
            color: white;
            margin-right:10px;
            padding: 0.4rem 1rem;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            box-shadow:0 0.1rem 0.5rem #24292e;
            cursor: pointer;
            transition: 0.5s ease;
        }
        .edit:hover{
            transform:scale(1.1);
        }

    </style>
</head>
<body  style="background:#fff3;">
    <header>
                                    <div class="logo">
                                      <img src="comment.png" alt="Logo">
                                    </div>
                                    
                                    <style>
                                      .logo {
                                        text-align: left;
                                        margin-top:-10px;
                                        margin: 20px 0;
                                        padding-bottom: 12px;
                                      }
                                      
                                      .logo img {
                                        width: 50px;
                                        height: auto;
                                      }
                                    </style>
                                    
        <h1 style="color:#000000;margin-left:60px;margin-top:-80px;">TASK | MANAGER</h1>
        <nav>
            <ul>
                <nav>
    <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;margin-left:900px;margin-top:-40px;">
        <li style="float: right;"><a href="index.php" style="display: block; color: white;font-weight:bolder; text-align: center; padding: 14px 16px; text-decoration: none;color:#000000;">Home</a></li>
        <li style="float: right;"><a href="logout.php" style="display: block; color: white;font-weight:bolder; text-align: center; padding: 14px 16px; text-decoration: none;color:#000000;">Logout</a></li>

    <li style="float: right;">
    <div style="border-radius: 50%; width: 30px; height: 30px; background-color: #333; color: #fff; text-align: center; line-height: 30px; display: inline-block; margin-right: 10px;margin-top:1px;color: #D9D9D9;background:#696969;padding:10px;">
      <i class="fa fa-user"></i>
      
    </div>
  </a>
</li>


    </ul>

</nav>

            </ul>
        </nav>
    </header>
    <main>
    <h2 style="color:#000000;">Tasks Dashboard</h2>

<?php


$priorities = array('Low', 'Medium', 'High');

foreach ($priorities as $priority) {
  echo "<div class='priority-$priority' style='border: 1px solid #ccc; padding: 10px; margin-bottom: 20px'>";
  echo "<h3 style='color: #333; font-size: 18px; margin-bottom: 10px'>$priority Priority Tasks</h3>";
  
  $sql = "SELECT * FROM tasks WHERE priority='$priority' AND user_id='" . $_SESSION['user_id'] . "'";
  $result = mysqli_query($conn, $sql);
  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<div class='task' data-id='" . $row['id'] . "' style='border: 1px solid #ddd; padding: 10px; margin-bottom: 10px'>";
      echo "<h3 style='color:#333; font-size: 16px; margin-bottom: 5px'>" . $row['title'] . "</h3>";
      echo "<p style='color:#fff; font-size: 14px; margin-bottom: 5px'>Description: " . $row['description'] . "</p>";
      echo "<p style='color:#fff; font-size: 14px; margin-bottom: 5px'>Priority: " . $row['priority'] . "</p>";
      echo "<p style='color:#fff; font-size: 14px; margin-bottom: 5px'>Due Date: " . $row['due_date'] . "</p>";
      echo "<p style='color:#fff; font-size: 14px; margin-bottom: 5px'>Status: " . $row['status'] . "</p>";
      echo "<a class='edit' href='update.php?id={$row['id']}' name='update' style='color: #fff;background-color: #24292e; text-decoration: none'>Edit</a>";
      echo "<button class='delete-btn' style='background-color: #f44336; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer'>";
echo "<a href='delete_task.php?id=" . $row['id'] . "' style='text-decoration:none;color:#fff;'>Delete</a>";
echo "</button>";

      echo "</div>";
    }
  } else {
    echo "<p style='color:red;'>No $priority priority tasks found!</p>";
  }
  
  echo "</div>";
}

?>

        
       
        <button id="add-task-btn">Add Task</button>
<div id="task-form" style="display: none;">
  <h2>Add Task</h2>
  
  <form id="task-form-element">
    
    <input type="text" id="title" placeholder="Title" name="title" required>
    
    <textarea id="description" placeholder="Description" name="description" required></textarea>
    
    <input type="date" id="due-date" name="due_date" required>

    <select id="priority" name="priority" Placeholder='Priority' required>
      <option value="Low">Low</option>
      <option value="Medium">Medium</option>
      <option value="High">High</option>
    </select>

    
    <select id="status" name="status" required Placeholder='Status'>
      <option value="To Do">To Do</option>
      <option value="In Progress">In Progress</option>
      <option value="Completed">Completed</option>
    </select>
    
    <button type="submit">Save</button>
    
    <button type="button" id="cancel-btn">Cancel</button>
    
  </form>
  
</div>

<div id="comment-form" style="margin-top: 20px; border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
          <h3>Add Comment</h3>
          
          <form method="POST">
            <?php


// Connect to the database
$db = new mysqli('localhost', 'root', '', 'task_manager'); 

// Check connection
if($db->connect_error){
  die("Connection failed: " . $db->connect_error);
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Query to get user's tasks from database
$sql = "SELECT id, title FROM tasks WHERE user_id = $user_id";
$result = $db->query($sql);
?>

<select name="comment_name" style="width: 98%; padding: 10px; border-radius:8px;margin-bottom: 10px;">
  <option value="">Select Task</option>
<?php while($row = $result->fetch_assoc()): ?>
  <option value="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></option>  
<?php endwhile; ?>
</select>



            <textarea name="comment" placeholder="Comment" required></textarea>
            <button type="submit">Add</button>
          </form>
        
        </div>
        
        <?php
        // Insert comment data into database
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          
          $name = $_POST['comment_name'];
          $comment = $_POST['comment'];
          
          // Connect to the database
          $db = new mysqli('localhost', 'root', '', 'task_manager');
          
          // Check connection
          if($db->connect_error){
            die("Connection failed: " . $db->connect_error);  
          }
          
          // When inserting new comments, add the session userid
       $sql = "INSERT INTO comments (user_id, name, comment) VALUES ('{$_SESSION['userid']}', '$name', '$comment')";
          
          if($db->query($sql) === TRUE){
            echo '<div style="text-align: center;">
            <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;">
              Comment Added  successfully!
            </div>  
          </div>';
          } else {
            echo "Error inserting comment: " . $db->error;
          }
          
        }
        ?>
        
        <style>
        #comment-form {
          box-shadow: 0 0.1rem 0.5rem #24292e; 
        }
        
        #comment-form input, 
        #comment-form textarea {
          width: 95%;
          padding: 10px;
          margin-bottom: 20px;
          border-radius: 5px;
          border: 1px solid #ccc;
        }
        
        #comment-form button[type="submit"] {
          background: #24292e;

          color: #fff;
          padding: 10px 20px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
        }
        </style>
<p style="text-align:center;font-size:20px;font-weight:bolder;"><b>COMMENTS</b></p> 
       <?php

       
       // Set a session variable to identify the user
       $_SESSION['userid'] = uniqid();
       
       // Modify the SQL queries to filter by the session userid
       $sql = "SELECT * FROM comments WHERE userid = '{$_SESSION['userid']}'";
       
       
       
       
       // Fetch comments from database
       $sql = "SELECT * FROM comments";
       $result = $conn->query($sql);
       
       // Output comments in a table
echo '<div align="center">';
echo '<table class="table table-striped">';
echo '<thead><tr><th>Name</th><th>Comment</th><th>Actions</th></tr></thead>';
while($row = $result->fetch_assoc()) {
  echo '<tr>';
  echo '<td align="center">' . $row['name'] . '</td>';
  echo '<td align="center">' . $row['comment'] . '</td>';
  echo '<td align="center"><button style="margin: 0 auto;border-radius: 5px;"><a href="edit_comment.php?id=' . $row['id'] . '" style="text-decoration:none;color:#fff;">Edit</a></button> | <button style="margin: 0 auto;border-radius: 5px;"><a href="delete_comment.php?id=' . $row['id'] . '" style="text-decoration:none;color:#fff;">Delete</a></button></td>';

  echo '</tr>';

}
echo '</table>';

echo '</div>';

       
       ?>
       
       <style>
       .table {
         width: 100%;
         max-width: 100%;
         margin-bottom: 1rem;
         background-color: transparent; 
       }
       
       .table th,
       .table td {
         padding: 0.75rem;
         vertical-align: top;
         border-top: 1px solid #dee2e6;
       }
       
       .table thead th {
         vertical-align: bottom;
         border-bottom: 2px solid #dee2e6;
       }
       
       .table-striped tbody tr:nth-of-type(odd) {
         background-color: rgba(0, 0, 0, 0.05);
       }
       </style>
       
       


</main>

<footer>
    <p align="center" style="background:grey;color:#ffffff;font-weight:bolder;margin-top:150px;padding:15px;"> &copy;  99 DEVELOPER.Inc</p>
</footer>

<style>

#task-form {
  border: 1px solid #ccc;
  padding: 20px;
  margin-top:20px;
  border-radius: 5px;
  box-shadow:0 0.1rem 0.5rem #24292e;
}

#title, 
#description,
#priority,
#due-date,
#status {
  display: block;
  width: 95%;
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
} 

#add-task-btn,
#editbtn,
button[type="submit"],
#cancel-btn {
  background: #24292e;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

</style>


    </main>
    <script src="script.js"></script>
</body>
</html>
