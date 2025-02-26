<?php
include('connection.php');
if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password) ;
    
    $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
     session_start();
     $row=$result->fetch_assoc();
     $_SESSION['email']=$row['email'];
     header("Location: indexx.html");
     exit();
    }
    else{
     echo '<script>
     alert("Incorrect Email or Password");
     window.location.href="index.html";
     </script>';
    }
 
 }
 ?>
