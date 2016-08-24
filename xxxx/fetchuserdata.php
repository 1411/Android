<?php
    $Con=mysqli_connect("localhost","my_user","my_password","my_db");

    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $statement = mysqli_prepare($con, "SELECT * FROM user WHERE Email=? AND Password=?");
    mysqli_stmt_bind_param($statement,"ss", $Email, $Password);
    mysqli_stmt_execute($statement);


    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,$Name, $Email, $Username, $Password);

    $user= array();

    while(mysqli_stmt_fetch($statement)){
        $user[Name] = $Name;
        $user[Email] = $Email;
        $user[Username] = $Username;
        $user[Password] = $Password;
    }
    echo json_encode($user);
    mysqli_stmt_close($statement);

    mysqli_smt_close($con);

?>