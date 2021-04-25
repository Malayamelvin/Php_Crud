<?php
require_once "databaseconnection.php";
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$message="";
$cname ="";
$code="";
$user_id ="";
$course_id="";

if(isset($_POST['editcourse'])){
 
$cname = $conn->real_escape_string($_POST['cname']);
$code = $conn->real_escape_string($_POST['ccode']);
$user_id = $_SESSION["user_id"];
$course_id=$_SESSION["course_id"];;

if(checkcourse($cname, $code, $conn)===TRUE){
  
    $message ="Failed to add course, course already exists";

} else{
    
    editCourse($cname, $code , $user_id,$course_id,$conn);
    $message ="course editted successfully.";

}

 }

//Add user course
function editCourse( $cname, $code , $user_id,$course_id,$conn){

    $sql = "update course  set course_name='$cname', course_code='$code' where course_id='$course_id' and user_id='$user_id'";
    if($conn->query($sql)===TRUE){

        $message= "course added successful";

    }else{
        $message= "failed to register.";
        
    }
}

//checking if user already added course
function checkcourse($cname,$code,$conn){

$sql = "select * from course where course_name= '$cname' and course_code='$$code' ";
$result = $conn->query($sql);

if($result->num_rows>0){
    return TRUE;
}else{
  return FALSE; 
}


}





$conn->close();





?>
<!DOCTYPE html>
<html>
<head>
    <title>edit course</title>
<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;

}


input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;

}
ul div{
    float: right;
}


.form {
    border-radius: 5px;
    background-color: ;
    padding: 10px;
    width:30%;
    margin: 0px 0 0 400px;
    border-radius: 15px;
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
</style>
</head>
<body>
<ul>
  <li><a href="addcourse.php">Add Course</a></li>
  <li><a href="welcome.php">View Courses</a></li>
  <li><a class="active " href="editcourse.php">Edit Course</a></li>
  <li><a href="Resetpassword.php">Reset password</a></li>
  <li><a href="logout.php">log out</a></li>

</ul>

<div style="margin-left:25%;padding:1px 16px;">
  <h2 style="text-align:center;">welcome <?php echo $_SESSION["username"]; ?></h2>
  
</div>
<div class="form">
<form action="editcourse.php" name="editcourse_form" method="post" >
            <h3 style="text-align:center;">Edit course form</h3>
            <label for="cname">course name </label>
            <input type ="text" name="cname" placeholder="Course Name" required>
            <label for="ccode">course code</label>
            <input type ="text" name="ccode" placeholder="Course Code" required>
            <input type="submit" name="editcourse" value="Edit">
            <?php
                
                echo $message;
            ?>
        </form>
</div>
</body>

</html>