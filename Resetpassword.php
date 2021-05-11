<?php
require_once "databaseconnection.php";
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$message="";
$user_id="";
$oldpassword="";
$newpassword="";

if(isset($_POST["reset"])){
    $user_id=$_SESSION["user_id"];
    $oldpassword=$conn->real_escape_string($_POST["oldpassword"]);
    $newpassword=$conn->real_escape_string($_POST["newpassword"]);


    if(checkoldpassword($oldpassword,$user_id,$conn)===TRUE){

        resetpassword($newpassword,  $user_id, $conn);
        $message = "password successfully changed";

    }else
    {
        $message = "password reset failed";

    }

}


function resetpassword($newpassword,  $user_id, $conn){

    $newpass  = password_hash($newpassword, PASSWORD_DEFAULT);
    $sql="update user set password='$newpass' where user_id='$user_id' ";
    
    if($conn->query($sql)===TRUE){
      
        $message = "password successfully changed";
    }else{
        $message = "password reset failed";
    }

}

//checks if password and user id exist in the database
function checkoldpassword($oldpassword,$user_id,$conn){

    $sql = "select * from user where user_id= '$user_id'";
    $result = $conn->query($sql);

    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            if(password_verify($oldpassword, $row["password"])){

                return TRUE;
            }


        }      
        
        
    }else{
      
      return FALSE;  
    }
    
}



$conn->close();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset password</title>
<style>

input[type=password], select {
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
  <li><a class="active" href="Resetpassword.php">Reset password</a></li>
  <li><a href="logout.php">log out</a></li>

</ul>

<div style="margin-left:25%;padding:1px 16px;">
  <h2 style="text-align:center;">welcome <?php echo $_SESSION["username"]; ?></h2>
  
</div>
<div class="form">
<form action="Resetpassword.php" name="reset_form" method="post" >
            <h3 style="text-align:center;">Edit course form</h3>
            <label for="oldpassword">Old Password </label>
            <input type ="password" name="oldpassword" placeholder="Enter Old Password" required>
            <label for="newpssword">New Password</label>
            <input type ="password" name="newpassword" placeholder="Enter New Password" required>
            <input type="submit" name="reset" value="Reset">
            <?php
                
                echo $message;
            ?>
        </form>
</div>
</body>

</html>