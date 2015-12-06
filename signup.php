<?php
  $username = $firstname = $lastname = $password = $cpassword = $email = " ";
  $usernameErr = $firstnameErr = $lastnameErr = $passwordErr = $cpasswordErr = $emailErr =" ";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["uName"])) {                        //check the username
      $usernameErr = "Username is required";
    } else if (!preg_match("/^[a-zA-Z0-9]*$/",$_POST["uName"])){
      $usernameErr = "Only letters and numbers are allowed";
    } else {
      $username = test_input($_POST["uName"]);
    }

    if (empty($_POST["fName"])) {                      //check the firstname
      $firstnameErr = "Username is required";
    } else {
      $firstname = test_input($_POST["fName"]);
    }

    if (empty($_POST["lName"])) {                       //check the lastname
      $lastnameErr = "Username is required";
    } else {
      $lastname = test_input($_POST["lName"]);
    }

    if (empty($_POST["pWord"])){                      //check the password
      $passwordErr = "Password is required";
    } else if (!preg_match('/[A-Z]+[a-z]+[0-9]+/', $_POST["pWord"])){
      $passwordErr = "Password should contains Uppercases, lowercases and numbers.";
    } else {
      $password = test_input($_POST["pWord"]);
    }

    if(empty($_POST["cpWord"])) {                       //check if the passwords match
      $cpasswordErr = "You should enter password twice.";
    } else if ($_POST["pWord"] != $_POST["cpWord"]) {
      $cpasswordErr = "The passwords don't match.";
    } else {
      $cpassword = test_input($_POST["cpWord"]);
    }

    if (empty($_POST["email"])) {                      //check the email
      $emailErr = "Email is required";
    } else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $emailErr = "Invalid email format";
    } else {
      $email = test_input($_POST["email"]);
    }
  }
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


  if(($_SERVER['REQUEST_METHOD'] == 'POST')&&($usernameErr ==" ")&&($firstnameErr ==" ")&&($lastnameErr ==" ")&&($passwordErr ==" ")&&($cpasswordErr ==" ")&&($emailErr==" ")) {
    $user = 'root';
    $pswd = 'root';
    $db = 'umdatabase';
    $host = 'localhost';
    $port = 3306;
    try{
      $conn = new PDO("mysql:host=$host;dbname=$db",$user, $pswd);
      $sql = "INSERT INTO User
                (userName,firstName,lastName,email,password)
                VALUES ('$username','$firstname','$lastname','$email','$password')";
      $conn->exec($sql);
      header('Location:index.html');
    }
    catch(PDOException $e){
      echo $sql."<br>".$e->getMessage();
    }

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>UMRestaurants</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>






  <div class="container">
    <form role="form" class="form-default" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <div class="form-group">
        <label for="uName" class="">Username:</label>
        <input type="text"  id="uName" name="uName" placeholder="Enter your username" >
        <span class="error">* <?php echo $usernameErr;?></span>
      </div>

      <div class="form-group">
        <label for="fName" class="">First Name:</label>
        <input type="text"  id="fName" name="fName" placeholder="Enter your first name" >
        <span class="error">* <?php echo $firstnameErr;?></span>
      </div>

      <div class="form-group">
        <label for="lName" class="">Last Name:</label>
        <input type="text"  id="lName" name="lName" placeholder="Enter your last name" >
        <span class="error">* <?php echo $lastnameErr;?></span>
      </div>
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password"  id="pwd" name="pWord" placeholder="Enter password" >
        <span class="error">* <?php echo $passwordErr;?></span>
      </div>
      <div class="form-group">
        <label for="cPwd">Confirm Password:</label>
        <input type="password"  id="cPwd"  name="cpWord" placeholder="Enter password again">
        <span class="error">* <?php echo $cpasswordErr;?></span>
      </div>

      <div class="form-group">
        <label for="uName" class="">Email:</label>
        <input type="email"  id="email"  name="email" placeholder="Enter your email" >
        <span class="error">* <?php echo $emailErr;?></span>
      </div>

      <button type="submit"  name="submit" class="btn btn-default">Submit</button>
    </form>
  </div>
</body>
</html>
