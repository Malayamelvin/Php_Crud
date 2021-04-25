<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_crud";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create tables
$usertable =" create table user(
    user_id int(6) auto_increment not null,
    first_name varchar(55) not null,
    last_name varchar(55) not null,
    email varchar(100) not null unique,
    password varchar(100) not null,
    primary key(user_id)
)";

$coursetable =" create table course(
    course_id int(6) auto_increment,
    user_id int(6) not null,
    course_name varchar(100) not null,
    course_code varchar(100) not null,
    foreign key(user_id) references user(user_id),
    primary key(course_id)
)";

if ($conn->query($usertable)&&$conn->query($coursetable) === TRUE) {
  echo "Tables created successfully";
} else {
  echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>