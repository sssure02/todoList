<?php 
    
    require("db_credentials.php")
   
    if(isset($_POST["SubmitButton"])) {
       
        $conn = new mysqli($servername, $username, $password, $database);
        $id = $_POST["id"];
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "UPDATE task SET task_status='completed', date_created = DATE(now()) WHERE task_id=$id;" ;

        
        if ($conn->query($sql) === TRUE) {
          echo "Status updated successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
                
    }

?>

<html>
<head>
    <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    td, th {
      border: 3px solid #000000;
      text-align: center;
      padding: 8px;
    }
    
    </style>
    <title> To-do List Project 2 Main Page </title>
</head>
    <body style = "background-color:#ADD8E6;">
        <br>
        <nav style="text-align:right;">  
            <a href="index.php"> Home </a>  
            <br>
            <a href="author.html"> Authors </a>  
        </nav>  
        <h1 style="text-align:center;"> Edit Tasks </h1>
        <hr>
        <p style="text-align:center;"> A web application to store a to-do list.</p>
         <nav style="text-align:center;">  
            <a href="createTasks.php"> Create Tasks </a>   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="editCategory.php"> Edit Category </a>   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="viewTasks.php"> View Tasks </a>  
        </nav>  
        <br>
        <br>
        <br>
        <?php
                require("db_credentials.php")
    
                $conn = new mysqli($servername, $username, $password, $database);
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT task_id, task_desp, due_date, category_name, priority_level, task_status FROM task LEFT JOIN taskCategory ON task.task_category = taskCategory.category_id;";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Description</th>';
                    echo '<th>Due Date</th>';
                    echo '<th>Category</th>';
                    echo '<th>Priority</th>';
                    echo '<th>Status</th>';
                    echo '<th>Edit Action</th>';
                    echo '<th>Completed</th>';
                    echo '</tr>';
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['task_desp'] . '</td>';
                        echo '<td>' . $row['due_date'] . '</td>';
                        echo '<td>' . $row['category_name'] . '</td>';
                        echo '<td>' . $row['priority_level'] . '</td>';
                        echo '<td>' . $row['task_status'] . '</td>';
                        //echo '<td><a href="edit_task.php?id=' . $row['task_id'] . '">Edit</a></td>';
                        echo '<td><form action="edit_task.php" method="POST"><input type="hidden" value=' . $row['task_id'] . ' name="id"/><input type="submit" value="Edit" name="EditButton"/></form></td>';
                        if($row['task_status'] == "active"){
                            echo '<td><form action="#" method="POST"><input type="hidden" value=' . $row['task_id'] . ' name="id"/><input type="submit" name="SubmitButton"/></form></td>';
                        } else {
                            echo '<td><form></form></td>';
                        }
                        echo '</tr>';
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                
                $conn->close();
        ?>
    </body> 
</html>