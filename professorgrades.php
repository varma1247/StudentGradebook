<?php
session_start();
include "conn.php";
if (isset($_SESSION['user'])){
    $id=substr($_SESSION['user'],0,10);
        if(isset($_POST['pyear'])&& isset($_POST['psemester'])){
            $year=$_POST['pyear'];
            $semester=$_POST['psemester'];
            try{
            $sql="SELECT g.courseid,s.firstname,s.lastname,g.grade,c.name,g.professorid FROM grades g JOIN student s ON g.studentid=s.id JOIN course c ON g.courseid=c.courseid WHERE g.professorid='$id' AND g.year='$year' AND g.semester='$semester'";
            $result=mysqli_query($conn,$sql);
            while ($row=mysqli_fetch_assoc($result)) {
                $grades[]=$row;
              }
              echo json_encode($grades);
            // echo $result2;
            }
            catch (mysqli_sql_exception $e) { 
                throw $e; 
             } 
        }
    }
    else{
        header("Location: login.html");
    }
?>