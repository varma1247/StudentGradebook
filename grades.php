<?php
// session_start();
include "conn.php";
include "to.php";
if (isset($_SESSION['user'])){
    $id=substr($_SESSION['user'],0,10);
    
        if(isset($_POST['year'])&& isset($_POST['semester'])){
            $year=$_POST['year'];
            $semester=$_POST['semester'];
            try{
            $sql="SELECT g.courseid,p.firstname,p.lastname,g.grade,c.name FROM grades g JOIN professor p ON g.professorid=p.id JOIN course c ON g.courseid=c.courseid WHERE g.studentid='$id' AND g.year='$year' AND g.semester='$semester'";
            $result=mysqli_query($conn,$sql);
            while ($row=mysqli_fetch_assoc($result)) {
                $grades[]=$row;
              }
              echo json_encode($grades);
            // echo $result2;
            }
            catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
        }
        if(isset($_POST['pyear'])&& isset($_POST['psemester'])){
            $year=$_POST['pyear'];
            $semester=$_POST['psemester'];
            $subject=$_POST['psubject'];
            try{
            $sql="SELECT g.courseid,s.firstname,s.lastname,s.id,g.grade,c.name,c.professorid FROM grades g JOIN student s ON g.studentid=s.id JOIN course c ON g.courseid=c.courseid WHERE g.professorid='$id' AND g.year='$year' AND g.semester='$semester' AND c.name='$subject'";
            $result=mysqli_query($conn,$sql);
            while ($row=mysqli_fetch_assoc($result)) {
                $grades[]=$row;
              }
              echo json_encode($grades);
            // echo $result2;
            }
            catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
        }
       if(isset($_POST['newgrade'])&& isset($_POST['gradeid'])){
           $newgrade=$conn->real_escape_string($_POST['newgrade']);
        //    $newgrade=$_POST['newgrade'];
           $graderegex="/^[A-F]{1}$/";
           $g=explode(" ",$_POST['gradeid']);
           $studentid= $g[0];
           $courseid=$g[1];
           $professorid=$g[2];
        //    $sql="UPDATE grades SET grade='$newgrade' WHERE studentid='$studentid' AND courseid='$courseid' AND professorid='$professorid'";
        //    $result=mysqli_query($conn,$sql);
            if(preg_match($graderegex, $newgrade)){
            try{
            $stmt1=$conn->prepare("UPDATE grades SET grade=? WHERE studentid='$studentid' AND courseid='$courseid' AND professorid='$professorid'");
            $stmt1->bind_param("s",$newgrade);
            $stmt1->execute();
            // echo "success";
           $rows=mysqli_affected_rows($conn);
           if($rows==0){
               echo "4";
           }
           else{
               echo "5";
           }
        }
        catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
        //    Header("Location:professor.php");
        // echo $result2;
        }
       }
    }
    else{
        header("Location: login.html");
    }
?>