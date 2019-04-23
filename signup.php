<?php
include "conn.php";

if (isset($_POST['email'])&& isset($_POST['password'])){
$email=$conn->real_escape_string($_POST['email']);
$firstname=$conn->real_escape_string($_POST['firstname']);
$lastname=$conn->real_escape_string($_POST['lastname']);
$id=$conn->real_escape_string($_POST['id']);
$password=md5($conn->real_escape_string($_POST['password']));
$confirmPassword=md5($conn->real_escape_string($_POST['confirmPassword']));
$usertype=$conn->real_escape_string($_POST['userType']);
$approved="0";
$emailregex="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
$passwordregex="/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/";
$idregex="/^[1][0]{2}[0-9]{7}$/";
$nameregex="/^[a-zA-Z]{1,20}$/";
if($email=="" || $firstname=="" || $lastname=='' || $password==""||$confirmPassword==""){
    echo "emptyerror";
}
else{
if(preg_match($emailregex, $email)&&preg_match($passwordregex, $password)&&preg_match($passwordregex, $confirmPassword)&&preg_match($nameregex, $firstname)&&preg_match($nameregex, $lastname)&&preg_match($idregex, $id)){
    if ($usertype=="student"){
    try{
        $stmt1=$conn->prepare("SELECT * FROM student WHERE id=? OR email=?");
        $stmt1->bind_param("ss",$id,$email);
        $stmt1->execute();
        $stmt1->store_result();
    }
    catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
    if($stmt1->num_rows>0){
        echo "idexisterror";
    }
    else{
        try{
        $stmt=$conn->prepare("INSERT INTO student (email,firstname,lastname,password,id,approved) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $email,$firstname,$lastname,$password,$id,$approved);
        $stmt->execute();
            $stmt->close();
            $conn->close();
            echo "success";
    }
    catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
    }
}
elseif ($usertype=="professor") {
    try{
    $stmt1=$conn->prepare("SELECT * FROM professor WHERE id=?");
    $stmt1->bind_param("s",$id);
    $stmt1->execute();
    $stmt1->store_result();
    }
    catch( mysqli_sql_exception $e )
    {
        echo $e->getMessage();
        die;
    }
    if($stmt1->num_rows>0){
        echo "idexisterror";
    }
    else{
        try{
    $stmt=$conn->prepare("INSERT INTO professor (email,firstname,lastname,password,id,approved) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $email,$firstname,$lastname,$password,$id,$approved);
    $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "success";
        }
        catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
    }
}
}
}
}
?>