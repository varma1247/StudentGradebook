<?php
session_start();
include "conn.php";
if (isset($_SESSION['user'])){
$id=substr($_SESSION['user'],0,10);
try{
$sql="SELECT id,firstname,lastname,approved,email from student WHERE approved='0' ORDER BY approved ASC";
$sql2="SELECT id,firstname,lastname,approved,email from professor WHERE approved='0' ORDER BY approved ASC";
$result=mysqli_query($conn,$sql);
$result1=mysqli_query($conn,$sql2);
}
catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
if(isset($_POST['aid'])&& isset($_POST['ausertype'])){
    $aid=$_POST['aid'];
    $ausertype=$_POST['ausertype'];
    try{
    if($ausertype=="student"){
        $sql="UPDATE student SET approved='1' WHERE id='$aid'";
    }
    else if($ausertype=='professor'){
    $sql="UPDATE professor SET approved='1' WHERE id='$aid'";
    }
    $result=mysqli_query($conn,$sql);
}
catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
}
if(isset($_POST['did'])&& isset($_POST['dusertype'])){
    $did=$_POST['did'];
    $dusertype=$_POST['dusertype'];
    echo $did;
    try{
    if($dusertype=="student"){
        $sql="DELETE FROM student WHERE id='$did'";
    }
    else if($dusertype=='professor'){
    $sql="DELETE FROM professor WHERE id='$did'";
    }
    $result=mysqli_query($conn,$sql);
}
catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
        }
}
}
else{
    header("Location: login.html");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Homepage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
         th{
            text-align:center
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top:30px">
        <button class="btn btn-primary" style="position: relative; left: 1000px;" id='logout'>Logout</button>
    </div>
    <div class="container card"  style="height:65vh; margin-top: 60px; box-shadow: darkslategrey 10px 5px; width: 65%">
            <h3 class="text-center" style="margin-top:30px">Users</h3>
            <div style="height:350px; overflow-y:scroll">
          <table class="table table-bordered table-hover table-striped text-center" style="margin-top:30px;">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>UserType</th>
                      <th>Name</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              <?php
                    if(mysqli_num_rows($result)==0&&mysqli_num_rows($result1)==0){
                        echo "<h4 class='text-center' style='color:red'>No new requests</h4>";
                    }
                    else{
                   while ($row=mysqli_fetch_assoc($result)) {
                    $row['usertype']="student";
                    $name=$row['firstname']." ".$row['lastname'];
                    $aid=$row['id']." ".$row['usertype'];
                    // if ($row['approved']=="0"){
                    echo "<tr id='".$aid."'><td>".$row['id']."</td><td>".$row['usertype']."</td><td>".$name."</td><td><button class='btn btn-info approve'>Approve</button></td><tr>";
                    // }
                    // else if($row['approved']=="1"){
                    // echo "<tr id='".$aid."'><td>".$row['id']."</td><td>".$row['usertype']."</td><td>".$name."</td><td><button class='btn btn-danger delete'>Delete</button></td><tr>";
                    // }
                  }
                  while ($row1=mysqli_fetch_assoc($result1)) {
                    $row1['usertype']="professor";
                    $name=$row1['firstname']." ".$row1['lastname'];
                    $aid=$row1['id']." ".$row1['usertype'];
                    // if($row1['approved']=="0"){
                    echo "<tr id='".$aid."'><td>".$row1['id']."</td><td>".$row1['usertype']."</td><td>".$name."</td><td><button class='btn btn-info approve'>Approve</button></td><tr>";
                    // }
                    // else if($row1['approved']=="1"){
                    //     echo "<tr id='".$aid."'><td>".$row1['id']."</td><td>".$row1['usertype']."</td><td>".$name."</td><td><button class='btn btn-danger delete'>Delete</button></td><tr>";
                    // }
                  }
                }
                ?>
    
              </tbody>
          </table>
          </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script>
     $(document).ready(function(){
            $(".approve").on('click',function(e){   
                var aid=$(this).closest('tr').attr('id').split(' ')[0];
                var ausertype=$(this).closest('tr').attr('id').split(' ')[1];
                  $.ajax({
                    url:"admin.php",
                    type:"POST",
                    data:{aid:aid,ausertype:ausertype},
                    success:function(data){
                       location.reload();
                    }
        })           
            });
        //     $(".delete").on('click',function(e){   
        //         var did=$(this).closest('tr').attr('id').split(' ')[0];
        //         var dusertype=$(this).closest('tr').attr('id').split(' ')[1];
        //         console.log(did);
                
        //           $.ajax({
        //             url:"admin.php",
        //             type:"POST",
        //             data:{did:did,dusertype:dusertype},
        //             success:function(data){
        //             //    location.reload();
        //             }
        // })           
        //     });
        });
    </script>
    <script src='logout.js'></script>
</body>
</html>