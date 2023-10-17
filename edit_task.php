
<html>
<head>
    <title>To-Do List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color:#ADD8E6;">
    <br>
    <nav style="text-align:right;">  
        <a href="index.php"> Home </a>  
        <br>
        <br>
        <a href="author.html"> Authors </a>  
    </nav>  
    <h1 style="text-align:center;"> To-Do List </h1>
    <hr>
    <p style="text-align:center;"> A web application to store a to-do list.</p>
    <br>
    
    <?php 
    
        require("db_credentials.php")
        
        $conn = new mysqli($servername, $username, $password, $database);
        
        $id= $_POST["id"];
        
       $sql = "SELECT task_id, task_desp, due_date, category_name, priority_level, task_status
        FROM task
        LEFT JOIN taskCategory ON task.task_category = taskCategory.category_id
        WHERE task_id= $id";
        
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $task_id= $row["task_id"]; 
            $task_desp = $row["task_desp"]; 
            $due_date = $row["due_date"];
            $task_category = $row["category_name"];
            $priority_level= $row["priority_level"];
        }
        
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" id="id" name="id" value="<?php echo $task_id; ?>">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $task_desp; ?>" required>
        <br>
        <br>
        <label for="due_date">Due date:</label>
        <input type="date" id="due_date" name="due_date" value="<?php echo $due_date; ?>" required>
        <br>
        <br>
        <label for="category">Category:</label>
        <select id="category" name="category">
        <option value='NULL'> -- select an option -- </option>
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
                    if($row["category_name"] == $task_category){
                        echo "<option selected value=" . $row["category_id"]. ">" . $row["category_name"]. "</option>";
                    } else {
                         echo "<option value=" . $row["category_id"]. ">" . $row["category_name"]. "</option>";
                    }
                  
                }
            } else {
                echo "0 results";
            }
            
            $conn->close();
        ?>
        </select>
        <br>
        <br>
        <label for="Priority">Priority:</label>
         <select id="Priority" name="Priority" required>
            <option value="NULL" <?php if($priority_level=="NULL") echo "selected=\"selected\""; ?>> -- select an option -- </option>
            <option value="1" <?php if($priority_level=="1") echo "selected=\"selected\""; ?>>1 - Highest Priority</option>
            <option value="2" <?php if($priority_level=="2") echo "selected=\"selected\""; ?>>2 - High Priority</option>
            <option value="3" <?php if($priority_level=="3") echo "selected=\"selected\""; ?>>3 - Medium Priority</option>
            <option value="4" <?php if($priority_level=="4") echo "selected=\"selected\""; ?>>4 - Low Priority</option>
         </select>
        <br>
        <br>
        <input type="submit" name="updateTask" value="Update">
        
    </form>
<?php 
    
    require("db_credentials.php")
    
    if(isset($_POST["updateTask"])) {
        $conn = new mysqli($servername, $username, $password, $database);
        
        $id = $_POST['id']; 
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];
        $category = $_POST['category'];
        $priority = $_POST['Priority'];
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //echo "'$id', '$description', '$due_date', '$category', '$priority'";
        
        // $sql = "UPDATE task LEFT JOIN taskCategory ON task.task_category = taskCategory.category_id SET task_desp = '$description', due_date = '$due_date', category_name = '$category', priority_level = $priority WHERE task_id = $id";
        
         $sql = "UPDATE task SET task_desp = '$description', due_date = '$due_date', task_category = '$category', priority_level = $priority WHERE task_id = $id";
        
        $result= mysqli_query($conn, $sql);
        
        if ($result) {
          ?> <script type="text/javascript">
            window.location.href = 'https://csc4710sql.000webhostapp.com/editTasks.php';
            </script> <?php
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
        
    }

?>
</body>
</html>
