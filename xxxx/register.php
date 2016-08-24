<?php 
    $con=mysqli_connect("localhost","my_user","my_password","my_db");
    
    $Name = $_POST['Name'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $statement = mysqli_prepare($con, "INSERT INTO user(Name, Username, Email, Password) VALUES(?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement, "ssss", $Name, $Username, $Email, $Password);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement)
        
    mysqli_close($con);
        
?>