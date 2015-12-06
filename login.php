<?php

  session_start();
  if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $errmsg_arr = array();

    if($username == ''){
      $errmsg_arr[] = 'You must enter your username.';
    }
    if($username && $password){
      $user = 'root';
      $pswd = 'root';
      $db = 'umdatabase';
      $host = 'localhost';
      $port = 3306;

      $conn = new PDO("mysql:host=$host;dbname=$db",$user, $pswd);
        $stmt = $conn->prepare("SELECT * FROM User WHERE userName = '$username'");
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
          $_SESSION['userID']=$row[0];
          $_SESSION['userName']=$row[1];
          header("location:index.php");
        }else{
          echo "Wrong";
        }
        $conn= null;



    }else {
      header("location:index.php?notify=All fields are required.");
    }
  }

?>
