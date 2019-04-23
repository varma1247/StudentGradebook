<?php
session_start();
include "conn.php";
if (isset($_POST['email'])&& isset($_POST['password'])){

    $email=$conn->real_escape_string($_POST['email']);
    $password=md5($conn->real_escape_string($_POST['password']));
    $usertype=$conn->real_escape_string($_POST['userType']);
    $emailregex="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
    $passwordregex="/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/";
    if(preg_match($emailregex, $email)&&preg_match($passwordregex, $password)){
    if($usertype=='student'){
        try{
    $stmt1=$conn->prepare("SELECT * FROM student WHERE email=? AND password=?");
        $stmt1->bind_param("ss",$email,$password);
        $stmt1->execute();
        $result=$stmt1->get_result();
    }
    catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
        if($result->num_rows>0){
            $result=$result->fetch_assoc();
           if($result['approved']=='1'){
            $_SESSION['user']=$result['id'].rand(101,999);
            echo "1";
            }
            else {
                echo "notapproved";
            }
        }
        else{
            echo "nouser";
        }
        
    }
    elseif ($usertype=="professor") {
        try{
            $stmt1=$conn->prepare("SELECT * FROM professor WHERE email=? AND password=?");
            $stmt1->bind_param("ss",$email,$password);
            $stmt1->execute();
            $result=$stmt1->get_result();
        }
        catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
        if($result->num_rows>0){
            $result=$result->fetch_assoc();
            if($result['approved']=='1'){
            $_SESSION['user']=$result['id'].rand(101,999);
            echo "2";
            }
            else {
                echo "notapproved";
            }
        }
        else{
            echo "nouser";
        }
    }
    else if($usertype=='admin'){
        try{
        $stmt1=$conn->prepare("SELECT * FROM admin WHERE email=? AND password=?");
        $stmt1->bind_param("ss",$email,$password);
        $stmt1->execute();
        $result=$stmt1->get_result();
        }
        catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
        if($result->num_rows>0){
                $_SESSION['user']=rand(101,999);
                echo "3";    
        }
    }
    else{
        echo "nouser";
    }
}
}
?>