<?php 
        
    require("db_credentials.php")
    
    if(isset($_POST["editCategory"])) {
        $conn = new mysqli($servername, $username, $password, $database);
        
        $id = $_POST["categoryNo"];
        $newName = $_POST["newName"];
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "UPDATE taskCategory SET category_name='".$newName."' WHERE category_name='$id';" ;

        
        if ($conn->query($sql) === TRUE) {
          echo "Category updated successfully";
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
        <h1 style="text-align:center;"> Edit Category </h1>
        <hr>
        <p style="text-align:center;"> A web application to store a to-do list.</p>
         <nav style="text-align:center;">  
             <a href="createTasks.php"> Create Tasks or Categories </a>  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="editTasks.php"> Edit Tasks </a>   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="viewTasks.php"> View Tasks </a>  
        </nav>  
        <br>
        <br>
        <br>
       <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for = "num">Current Name: </label>
        <input type="text" id = "num" name="categoryNo" required><br>
        <label for = "changedName">Change name to :</label>
        <input type="text" name="newName" id = "changedName" required><br>
        <input type="submit" name="editCategory" value="Edit Category"> </form>
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
                    echo "<table><tr><th>Category Name</th></tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["category_name"]. "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                
                $conn->close();
        ?>
    </body> 
</html>