<?php
    require_once "databaseconnection.php";

            $message ="";
            $fname ="";
            $lname="";
            $email="";
            $password="";

        if(isset($_POST['register'])){

            $fname = $conn->real_escape_string($_POST['fname']);
            $lname = $conn->real_escape_string($_POST['lname']);
            $email = $conn->real_escape_string($_POST['email']);
            $password=$conn->real_escape_string($_POST['password']);
            
            echo $fname;

           
            if(checkUser($email,$conn)===TRUE){
                $message ="Failed to register, email address exists";
            } else{
                
              register($fname, $lname , $email, $password, $conn);
              //header( "location :index.html ");
              $message ="Registration successful.";

            
            }

             }
        

        function register( $fname, $lname , $email,$password,$conn){
            
            $sql = "insert into user (first_name, last_name ,email, password) values('$fname','$lname','$email','$password')";
            if($conn->query($sql)===TRUE){
                $message= "registration successful";
            
            }else{
                $message= "failed to register.";
                
            }
        }

        //checking if email already exists in the database
        function checkUser($email,$conn){

            $sql = "select * from user where email= '$email'";
            $result = $conn->query($sql);

            if($result->num_rows>0){
                return TRUE;
            }else{
              return FALSE; 
            }


        }

        
        

?>

<!Doctype html>
<html>
    <head>
        <title>registration page</title>
        <link rel="stylesheet" href="mystyle.css">
  
    </head>
    <body>
    <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <div>
                <li><a href="login.php">Login</a></li>
                <li><a href="#">Register</a></li>
                <li><a href="#">About</a></li>
                </div>
            </ul>
        </nav>
        <div class="form">
        <form action="register.php" name="registration_form" method="post" >
            <h3 style="text-align:center;">Registration form</h3>
            <label for="fname">first name </label>
            <input type ="text" name="fname" placeholder="First Name" required>
            <label for="lname">Last name </label>
            <input type ="text" name="lname" placeholder="Last Name" required>
            <label for="email">Email </label>
            <input type ="email" name="email" placeholder="Email" required>
            <label for="password">Password </label>
            <input type ="password" name="password" placeholder="Password" required>
            <input type="submit" name="register" value="Register">

            <?php
                
                echo $message;
            ?>
        </form>
            
        </div>

    </body>




</html>
