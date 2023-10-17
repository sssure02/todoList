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
        <h1 style="text-align:center;"> View Tasks </h1>
        <hr>
        <p style="text-align:center;"> A web application to store a to-do list.</p>
         <nav style="text-align:center;">  
             <a href="createTasks.php"> Create Tasks or Categories </a>  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="editCategory.php"> Edit Category </a>   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="editTasks.php"> Edit Tasks </a>   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
        </nav>  
        <br>
        <br>
        <br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label> To view overdue tasks and due-today tasks (sorted by priority). Press this button: </label>
        <input type="submit" name="view1" value="View 1">   </form>
        <?php 
        
            require("db_credentials.php")
            
            if(isset($_POST["view1"])){
                $conn = new mysqli($servername, $username, $password, $database);
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT task_desp, due_date, category_name, priority_level, task_status FROM task LEFT JOIN taskCategory ON task_category = category_id WHERE due_date <= DATE(now()) ORDER BY priority_level;";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    echo "<table><tr><th>Task Description</th><th>Due Date</th><th>Task Category</th><th>Priority level</th><th>Status</th></tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["task_desp"]. "</td><td>" . $row["due_date"]. "</td><td>" . $row["category_name"]. "</td><td>" . $row["priority_level"]. "</td><td>" . $row["task_status"]. "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                
                $conn->close();
                
            } 
        ?>
        <br> <br> <br>
        <form method="post">
        <label> To view tasks by category (ordered by priority and due date). Press this button: </label>
        <select name="categoryName" required>
            <option value="">Select a category</option>
            <?php 
            require("db_credentials.php")
    
            $conn = new mysqli($servername, $username, $password, $database);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $sql = "SELECT * FROM taskCategory;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value=" . $row["category_id"]. ">" . $row["category_name"]. "</option>";
                }
            } else {
                echo "0 results";
            }
            
            $conn->close();
        ?>
        </select>
        <input type="submit" name="view2" value="View 2">
    </form>
    <?php 
        
            require("db_credentials.php")
            
            if(isset($_POST["view2"])) {
                $conn = new mysqli($servername, $username, $password, $database);
                
                $categoryName = $_POST["categoryName"];
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT task_desp, due_date, category_name, priority_level, task_status
                            FROM task
                            LEFT JOIN taskCategory ON task.task_category = taskCategory.category_id
                            WHERE task.task_category = $categoryName
                            ORDER BY priority_level, due_date";
                
                    $result = mysqli_query($conn, $sql);
        
                    echo '<table>';
                    echo '<tr>';
                    //echo '<th>Task</th>';
                    echo '<th>Task Description</th>';
                    echo '<th>Due Date</th>';
                    echo '<th>Task Category</th>';
                    echo '<th>Priority Level</th>';
                    echo '<th>Status</th>';
                    //echo '<th>Action</th>';
                    echo '</tr>';
        
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        //echo '<td>' . $row['task_id'] . '</td>';
                        echo '<td>' . $row['task_desp'] . '</td>';
                        echo '<td>' . $row['due_date'] . '</td>';
                        echo '<td>' . $row['category_name'] . '</td>';
                        echo '<td>' . $row['priority_level'] . '</td>';
                        echo '<td>' . $row['task_status'] . '</td>';
                        // echo '<td><a href="edit_task.php?id=' . $row['task_id'] . '">Edit</a></td>';
                        echo '</tr>';
                    }
        
                    echo '</table>';
                
                $conn->close();
                
            }
        ?>
        <br> <br> <br>
        <form method="post">
         <label>To view only completed tasks on a specific day (ordered by due date). Press this button:</label>
         <input type="submit" name="view3" value="View 3">
         <input type="date" id="dueDate" name="dueDate" required> <br><br>
        </form>
        <?php 
        
            require("db_credentials.php")
            
            if(isset($_POST["view3"])) {
                $conn = new mysqli($servername, $username, $password, $database);
                
                $dueDate = $_POST["dueDate"];
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT task_desp, due_date, category_name, priority_level, task_status
                            FROM task
                            LEFT JOIN taskCategory ON task.task_category = taskCategory.category_id
                            WHERE task_status='completed' AND date_created = '$dueDate'
                            ORDER BY due_date";
                
                    $result = mysqli_query($conn, $sql);
        
                    echo '<table>';
                    echo '<tr>';
                    //echo '<th>Task</th>';
                    echo '<th>Task Description</th>';
                    echo '<th>Due Date</th>';
                    echo '<th>Task Category</th>';
                    echo '<th>Priority Level</th>';
                    echo '<th>Status</th>';
                    //echo '<th>Action</th>';
                    echo '</tr>';
        
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        //echo '<td>' . $row['task_id'] . '</td>';
                        echo '<td>' . $row['task_desp'] . '</td>';
                        echo '<td>' . $row['due_date'] . '</td>';
                        echo '<td>' . $row['category_name'] . '</td>';
                        echo '<td>' . $row['priority_level'] . '</td>';
                        echo '<td>' . $row['task_status'] . '</td>';
                        // echo '<td><a href="edit_task.php?id=' . $row['task_id'] . '">Edit</a></td>';
                        echo '</tr>';
                    }
        
                    echo '</table>';
                
                $conn->close();
                
            }
        ?>
        
    </body> 
</html>