<?php
   $servername = "localhost";
   $username = "id20154394_test1";
   $password = "Malja#159257";
   $database = "id20154394_test";
   
   // Create connection
   $conn = mysqli_connect($servername, $username, $password, $database);
   
   // Check connection
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   
   if (isset($_POST['submit']))
   {
       $desc = $_POST['taskDesc'];
       $date = $_POST['dueDate'];
       $category = $_POST['Category'];
       $priority = $_POST['Priority'];
       $status = $_POST['Status'];
       $result = mysqli_query($conn, "INSERT INTO task (task_desp,due_date,task_category,priority_level,task_status) VALUES ('$desc','$date','$category','$priority','$status')");
   
   if (!$result) {
       die('Error executing SQL statement: ' . mysqli_error($conn));
   }
   }
   
       if(isset($_GET['upd_task'])){
           $id = $_GET['upd_task'];
           mysqli_query($conn,"UPDATE task SET task_status='completed' WHERE task_desp='$id'");
       }
   
       $tasks = mysqli_query($conn,"SELECT * FROM task");
       $tasks_array = mysqli_fetch_all($tasks, MYSQLI_ASSOC);
       $tasks_json = json_encode($tasks_array);
       $tasks = mysqli_query($conn,"SELECT * FROM task");
   ?>
<html>
   <head>
      <style>
         form {
         display: flex;
         flex-direction: column;
         justify-content: flex-start;
         align-items: flex-start;
         position: fixed;
         top: 50%;
         left: 10%;
         transform: translate(-50%, -50%);
         }
         /* Increase the size of the text box and button */
         input[type="text"], select, button {
         font-size: 24px;
         padding: 10px;
         margin-bottom: 10px;
         }
         /* Display select elements vertically */
         .select-container {
         display: flex;
         flex-direction: column;
         }
         select {
         width: 100%;
         }
         #task-list {
         position: fixed;
         top: 200;
         right: 0;
         height: 100%;
         width: 30%;
         overflow: auto;
         padding: 10px;
         box-sizing: border-box;
         }
         /* Style the task list box */
         .task-list {
         position: fixed;
         top: 0%;
         right: 10%;
         transform: translate(0, -50%);
         width: 20%;
         height: 80%;
         border: 1px solid black;
         overflow-y: scroll;
         padding: 10px;
         }
         #sort {
         position: fixed;
         top: 20%;
         right: 15%;
         width: 7%;
         transform: translate(0, -50%);
         }
         #view {
         position: fixed;
         top: 20%;
         right: 7%;
         width: 7%;
         transform: translate(0, -50%);
         }
         /* Style the individual task items */
         .task-item {
         width: 500px;
         display: inline-block;
         vertical-align: top;
         border-top: 1px solid black;
         border-right: 1px solid black;
         border-bottom: 1px solid black;
         border-left: 1px solid black;
         padding: 5px;
         }
         table{
         width: 50%;
         margin: 30px auto;
         border-collapse: collapse;
         }
         tr{
         border-bottom: 1px solid #cbcbcb;
         }
         th{
         font-size: 19px;
         color: #6b8E23;
         }
         th,td{
         bordeR: none;
         height: 30px;
         padding: 2px;
         }
         tr:hover{
         background:#E9E9E9;
         }
         }
      </style>
      <title> To-do List Project 2 Main Page </title>
   </head>
   <body style = "background-color:#ADD8E6;">
      <br>
      <div id="task-list">
         <!-- Task list goes here -->
      </div>
      <nav style="text-align:right;">  
         <a href="index.php"> Home </a>  
         <br>
         <br>
         <a href="author.html"> Authors </a>  
      </nav>
      <h1 style="text-align:center;"> To-Do List </h1>
      <form method="post" action="index.php">
         <label for="task description">Description:</label>
         <textarea id="taskDesc" name="taskDesc"></textarea>
         <label for="due-date">Due Date:</label>
         <input type="date" id="dueDate" name="dueDate">
         <label for="category">Category:</label>
         <select id="Category" name="Category">
            <option value="0">N/A</option>
            <option value="1">1 - Worksheet</option>
            <option value="2">2 - HW</option>
            <option value="3">3 - Assignment</option>
            <option value="4">4 - Quiz</option>
         </select>
         <label for="priority">Priority:</label>
         <select id="Priority" name="Priority">
            <option value="0">N/A</option>
            <option value="1">1 - Low Priority</option>
            <option value="2">2 - Medium Priority</option>
            <option value="3">3 - High Priority</option>
            <option value="4">4 - Urgent Priority</option>
         </select>
         <label for="status">Status:</label>
         <select id="Status" name="Status">
            <option value="active">Active</option>
            <option value="completed">Completed</option>
         </select>
         <div id="task-list">
            <!-- Task list goes here -->
         </div>
         <button input type="submit" name="submit" value="Add Task">Create</button>
      </form>
      <div id="view">
         <label for="View">View by:</label>
         <select id="view-by">
            <option value="option1">Overdue/Due-Today</option>
            <option value="option2">All</option>
         </select>
      </div>
      <div id="sort">
         <label for="Sort">Sort by:</label>
         <select id="sort-by">
            <option value="Priority">Priority</option>
         </select>
      </div>
      <div id="footer">
         <p>A web application to store a to-do list.</p>
         <hr>
      </div>
      <br>
      <table id = "my-table">
         <thead>
            <tr>
               <th>#</th>
               <th>Task</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody id="tbody">
            <?php $ord = 1; while ($row = mysqli_fetch_array($tasks)){ ?>
            <tr>
               <td><?php echo $ord; ?></td>
               <td class="task"><?php echo $row['task_desp']; $ord+=1; ?></td>
               <td class="delete">
                  <a href="index.php?upd_task=<?php echo $row['task_desp']; ?>">x</a>
               </td>
            </tr>
            <?php }?>
         </tbody>
      </table>
      <script>
            
            sortBySelect = document.getElementById("sort-by");
            viewSelect = document.getElementById("view-by");
            
            
            sortBySelect.addEventListener("change", viewList);
            viewSelect.addEventListener("change", viewList);
            viewList();
            
            function sortList(list) {
            tbody = document.getElementById("tbody");
            if (sortBySelect.value != null){
            sortBy = sortBySelect.value;}
            else
                sortBy = "priority";
            
            sortedListItems = sortItemsBy(list, sortBy);
            if (tbody) {
            while ( tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
            }
            }
            
            let ord = 1;
            
            for (const item of sortedListItems) {
                const newRow = tbody.insertRow();
                let td1 = document.createElement("td");
            let td1Text = document.createTextNode(ord);
            td1.appendChild(td1Text);
            newRow.appendChild(td1);
            
            let td2 = document.createElement("td");
            let td2Text = document.createTextNode(item['task_desp']);
            td2.appendChild(td2Text);
            newRow.appendChild(td2);
            
            let td3 = document.createElement("td");
            let a = document.createElement("a");
            a.href = "index.php?upd_task="+item['task_desp'];
            let aText = document.createTextNode("x");
            a.appendChild(aText);
            td3.appendChild(a);
            newRow.appendChild(td3);
            
            ord += 1;
            tbody.appendChild(newRow);
            }
            }
            
            function sortItemsBy(items, sortBy) {
               let arr = items;
               let len = arr.length;
               if (sortBy=="Priority"){
                   for (let i = 0; i < len - 1; i++) {

                    for (let j = i + 1; j < len; j++) {

                        if (arr[i].priority_level < arr[j].priority_level) {

                            let temp = arr[i];
                            arr[i] = arr[j];
                            arr[j] = temp;
                        }
                    }
                }
                   
               }
                return arr;
            }
            
            function viewList() {
                tasksobj = JSON.parse('<?php echo $tasks_json; ?>');
            tasks = Object.values(tasksobj);
            tbody = document.getElementById("tbody");
            
            if (viewSelect.value != null && viewSelect.value!="" && viewSelect.value != undefined){
            sortList(viewItemsBy(tasks,viewSelect.value));}
            else{
                sortList(viewItemsBy(tasks,"option1"));}
            }
            
            function viewItemsBy(items, viewBy) {
               let arr = items;
               let len = arr.length;
               if (viewBy=="option1"){
                   const currentDate = new Date();
                    const startOfDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

                    arr = arr.filter(item => {
                    const dueDate = new Date(item.due_date);
                    return dueDate >= startOfDay;
                    });
               }
                return arr;
            }
         </script>
   </body>
</html>