<?php
    $host="localhost";
    $username= "root";
    $password="";
    $database="grad_advisor";

    $conn=mysqli_connect($host, $username, $password, $database);
    mysqli_set_charset($conn,'utf8');
    //check database
    if(!$conn)
    {
        die("Connection Faild ". mysqli_connect_errno());
    }
    else{
        
    }
?>