<?php
    require_once "databaseconnection.php";

            $email="";
            $password="";
            $message="";

        if(isset($_POST['login'])){

            $email = $conn->real_escape_string($_POST['email']);
            $password=$conn->real_escape_string($_POST['password']);

              if(login($email, $password, $conn)===TRUE){
                    $message ="login successful";
                    header("location: welcome.php");

              }else{

                $message ="login failed. wrong email or password";
                header("location: login.php");
              }
                        

             }
        
        function login($email, $password, $conn){
            
            $sql = "select * from user where email= '$email'";
            $result = $conn->query($sql);

            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                session_start();
                if(password_verify($password,$row["password"])){
                
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $row["first_name"]." ".$row["last_name"];
                $_SESSION["user_id"] = $row["user_id"];
                return TRUE;
                }

                }
                
               
            }else{
              
              return FALSE;  
            }
        }

        $conn->close();

?>

<!Doctype html>
<html>
    <head>
        <title>Login page</title>
        <link rel="stylesheet" href="mystyle.css">
  
    </head>
    <body>
    <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <div>
                <li><a href="#">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="#">About</a></li>
                </div>
            </ul>
        </nav>
        <div class="form" style="width:20%;">
        <form action="login.php" name="login_form" method="post" >
            <h3 style="text-align:center;">Login form</h3>
            <label for="email">Email </label>
            <input type ="email" name="email" placeholder="Email" required>
            <label for="password">Password </label>
            <input type ="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">

            <?php
                
                echo $message;
            ?>
        </form>
            
        </div>

    </body>




</html>
