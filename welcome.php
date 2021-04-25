<?php
require_once "databaseconnection.php";
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}




?>
<!DOCTYPE html>
<html>
<head>
  <title>user dashboard</title>
<style>

#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}


#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}



body {
  margin: 0;
}

ul {
  list-style-type: none;
  margin: 5px 0 0 0;
  padding: 0;
  width: 20%;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
}

li a {
  display: block;
  color: #000;
  padding: 8px 16px;
  text-decoration: none;
}

li a.active {
  background-color: #4CAF50;
  color: white;
}

li a:hover:not(.active) {
  background-color: #555;
  color: white;
}
a{
  display: block;
  color: #000;
  padding: 5px 10px;
  text-decoration: none;
  
  
}
button{
  margin-right:5px;
  border-radius:3px;
  border:none;
}
</style>
</head>
<body>
<ul>
  <li><a class="active" href="#home">Home</a></li>
  <li><a href="addcourse.php">Add Course</a></li>
  <li><a href="Resetpassword.php">Reset password</a></li>
  
  <li><a href="logout.php">log out</a></li>

</ul>

<div style="margin-left:25%;padding:1px 16px;">
  <h2 style="text-align:center;">welcome <?php echo $_SESSION["username"]; ?></h2>
  
  <table id="customers">
    <thead>
      <tr>
      <th>#</th>
        <th>Course Name</th>
        <th>Course Code</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
  <?php 
    $user_id = $_SESSION["user_id"];
    $sql="select * from course where user_id ='$user_id'";
    $result = $conn->query($sql);

    if($result->num_rows>0){
      $count =1;
      while($row=$result->fetch_assoc()){
        
        $course_id = $row['course_id'];
        $course_name =$row['course_name'];
        $course_code = $row['course_code'];
        $_SESSION["course_id"]=$row['course_id'];

       
        ?>
        <tr>
        <td><?php echo $count; ?></td>
          <td><?php echo  $course_name; ?></td>
          <td><?php echo $course_code; ?></td>
          <td><button style="background-color:green;"><a href="editcourse.php?>">Edit</a></button><button  style="background-color:red;"><a href="deletecourse.php">Delete</a></button></td>
          </tr>
          <?php
         
        $count++;
          }
        }
         
         $conn->close();
         ?>
          </tbody>
        </table>

   

</div>
</body>

</html>