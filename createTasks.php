<?php 
        
    require("db_credentials.php")

    if(isset($_POST["createCategory"])) {
        $conn = new mysqli($servername, $username, $password, $database);
        
        $categoryName = $_POST["categoryName"];
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "INSERT INTO taskCategory(category_name) VALUES ('$categoryName');";

        
        if ($conn->query($sql) === TRUE) {
          echo "New category created successfully" ;
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
        
    }else if(isset($_POST["createTask"])) {
        $conn = new mysqli($servername, $username, $password, $database);
        
       $desc = $_POST['taskDesc'];
       $date = $_POST['dueDate'];
       $category = $_POST['Category'];
       $priority = $_POST['Priority'];
       $status = $_POST['Status'];
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "INSERT INTO task (task_desp,due_date,task_category,priority_level,task_status,date_created) VALUES ('$desc','$date',$category,$priority,'$status', DATE(now()));";

        
        if ($conn->query($sql) === TRUE) {
          echo "New task created successfully" ;
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
        
    }


?>

<html>
<head>
    <title> To-do List Project 2 Main Page </title>
</head>
    <body style = "background-color:#ADD8E6;">
        <br>
        <nav style="text-align:right;">  
            <a href="index.php"> Home </a>  
            <br>
            <a href="author.html"> Authors </a>  
        </nav>  
        <h1 style="text-align:center;"> Create Tasks or Categories </h1>
        <hr>
        <p style="text-align:center;"> A web application to store a to-do list.</p>
         <nav style="text-align:center;">  
            <a href="editCategory.php"> Edit Category </a>   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="editTasks.php"> Edit Tasks </a>   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="viewTasks.php"> View Tasks </a> 
        </nav>  
        <br>
        <br>
        <br>
       
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
        <input type="text"  name="categoryName" required><br><br>
        <input type="submit" name="createCategory" value="Create Category"> </form>
        
        <br> <br> <br> <br>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
         <label for="task description" >Description: &nbsp;</label>
         <textarea id="taskDesc" name="taskDesc" required></textarea> <br><br> 
         <label for="due-date">Due Date:</label>
         <input type="date" id="dueDate" name="dueDate" required> <br><br>
         <label for="category">Category:</label> 
         <select id="Category" name="Category">
         <?php 
            require("db_credentials.php")
            
            $conn = new mysqli($servername, $username, $password, $database);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $sql = "SELECT * FROM taskCategory;";
            $result = $conn->query($sql);
            echo "<option selected value='NULL'> -- select an option -- </option>";
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value=" . $row["category_id"]. ">" . $row["category_name"]. "</option>";
                }
            } else {
                echo "0 results";
            }
            
            $conn->close();
        ?>
         </select> <br><br>
         <label for="priority">Priority:</label>
         <select id="Priority" name="Priority">
            <option selected value="NULL"> -- select an option -- </option>
            <option value="1">1 - Highest Priority</option>
            <option value="2">2 - High Priority</option>
            <option value="3">3 - Medium Priority</option>
            <option value="4">4 - Low Priority</option>
         </select> <br><br>
         <label for="status">Status:</label>
         <select id="Status" name="Status" required>
            <option value="active" selected>Active</option>
            <option value="completed">Completed</option>
         </select><br><br>
         <input type="submit" name="createTask" value="Create Task">
      </form>
    </body> 
</html>