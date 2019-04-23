<?php
session_start();
include "conn.php";
if (isset($_SESSION['user'])){
// echo $_SESSION['user'];
$id=substr($_SESSION['user'],0,10);
// echo $id;
try{
$sql="SELECT * FROM grades WHERE studentid='$id'";
$result=mysqli_query($conn,$sql);
$result1=mysqli_query($conn,$sql);
}
catch( mysqli_sql_exception $e )
        {
            echo $e->getMessage();
            die;
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
    <title>Student Homepage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        label{
            width:100px;
        
        }
        select{
            width: 100px;
        }
        th{
            text-align:center
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top:30px">
        <button class="btn btn-primary" style="position: relative; left: 1000px;" id="logout">Logout</button>
    </div>

    <div class="container card"  style="height:50vh; margin-top: 60px; box-shadow: darkslategrey 10px 5px; width: 50%" id="main">
            <h3 class="text-center" style="margin-top:30px">Student Portal</h3>
        <div class="text-center" style="width:60%; margin: auto; margin-top: 60px">
     <form action="grades.php" style="width:60%; margin: auto; margin-top: 0px" method="POST" id="grades">
        <div>
            <label for="">Year:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
            <select name="year" id="year">
                <!-- <option value="">2018</option> -->
                <?php
                   while ($row=mysqli_fetch_assoc($result)) {
                    ?>
                    <option value="<?=$row['year']?>"><?=$row['year']?></option>
                    <?php
                  }
                ?>
            </select>
        </div>
    <div style="margin-top:30px">
            <label for="">Semester:&nbsp&nbsp</label>
            <select name="semester" id="semester">
            <?php
                   while ($row=mysqli_fetch_assoc($result1)) {
                    ?>
                    <option value="<?=$row['semester']?>"><?=$row['semester']?></option>
                    <?php
                  }
                ?>
            </select>
        </div>
        <div style="margin-top:30px"></div>
            <button class="btn btn-primary" type="submit">Grades</button>
        </form>
    </div>
    </div>
    <div class="container card"  style="height:70vh; margin-top: 60px; box-shadow: darkslategrey 10px 5px; width: 65%" id="second">
            <h3 class="text-center" style="margin-top:30px">Your Grades</h3>
            <div class="row text-center" style="margin-top:10px">
                <h5 class="col-sm-6" id="nyear">Year: 2018</h5>
                <h5 class="col-sm-6" id="nsem">Semester: Spring</h5>
            </div>
            <div style="height:350px; overflow-y:scroll">
          <table class="table table-bordered table-hover table-striped text-center" style="margin-top:30px;">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Course</th>
                      <th>Professor</th>
                      <th>Grade</th>
                  </tr>
              </thead>
              <tbody id='allgrades'>
              </tbody>
          </table>
          </div>
          <div class="text-center"><button class="btn btn-primary" id="back">Back</button></div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script>
        $(document).ready(function(){
            $("#second").hide();
            $("#grades").on('submit',function(e){   
                e.preventDefault();
                  var year=$("#year").val();
                  var semester=$("#semester").val();
                  $.ajax({
                    url:"grades.php",
                    type:"POST",
                    data:{year:year,semester:semester},
                    success:function(data){
                        data=$.parseJSON(data);
                        $.each(data,function(key,value){
					var id=value.courseid;
					var course=value.name;
					var professor=value.firstname+" "+value.lastname;
					var grade=value.grade;
                    var tablerow= '<tr><td>'+id+'</td><td>'+course+'</td><td>'+professor+'</td><td>'+grade+'</td></tr>';
                    $("#nyear").text('Year: '+ year);
                    $("#nsem").text('Semester: '+ semester);
                    $("#allgrades").html('');
                    $("#allgrades").append(tablerow);
                    $("#main").hide();
                    $("#second").show();
				});
                    }
        })           
            });
            $("#back").on('click',function () {
                location.reload();
            });
        });
    </script>
    <script src='logout.js'></script>
</body>
</html>