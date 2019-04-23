<?php
session_start();
include "conn.php";
if (isset($_SESSION['user'])){
// echo $_SESSION['user'];
$id=substr($_SESSION['user'],0,10);
// echo $id;
try{
$sql="SELECT g.year,g.semester,c.name FROM grades g JOIN course c ON g.courseid=c.courseid WHERE g.professorid='$id'";
$result=mysqli_query($conn,$sql);
$result1=mysqli_query($conn,$sql);
$result2=mysqli_query($conn,$sql);
}
catch (mysqli_sql_exception $e) { 
    throw $e; 
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
    <title>Professor Homepage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">    
    <style>
        label{
            width:100px;
        
        }
        select{
            width: 180px;
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

    <div class="container card"  style="height:60vh; margin-top: 60px; box-shadow: darkslategrey 10px 5px; width: 65%" id="main">
            <h3 class="text-center" style="margin-top:30px">Faculty Portal</h3>
        <div class="text-center" style="width:60%; margin: auto; margin-top: 60px">
       <form action="grades.php" method="POST" id="grades">
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
        <div style="margin-top:30px">
                <label for="">Subject:&nbsp&nbsp</label>
                <select name="subject" id="subject">
                <!-- <option value="">2018</option> -->
                <?php
                   while ($row=mysqli_fetch_assoc($result2)) {
                    ?>
                    <option value="<?=$row['name']?>"><?=$row['name']?></option>
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
    <div class="container card"  style="height:75vh; margin-top: 60px; box-shadow: darkslategrey 10px 5px; width: 65%" id="second">
            <h3 class="text-center" style="margin-top:30px">Student Grades</h3>
           <div class="row text-center" style="margin-top:10px">
            <h5 class="col-sm-2" id="nyear">Year: 2018</h5>
            <h5 class="col-sm-3" id="nsemester">Semester: Spring</h5>
            <h5 class="col-sm-3" id="ncourseid">Course ID: CSE 5360</h5>
            <h5 class="col-sm-4"id="ncourse">Course: Artificial Intelligence</h5>
        </div>
        <div style="height:350px; overflow-y:scroll">
          <table class="table table-bordered table-hover table-striped text-center" style="margin-top:30px;">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Grade</th>
                  </tr>
              </thead>
              <tbody id="allgrades">
              </tbody>
          </table>
                </div>
        <div class="text-center"><button class="btn btn-primary" style="margin-right:10px" id="save">Save</button><button class="btn btn-primary" id="back">Back</button></div>
    </div>
    <div class="text-center"><h3 id="msg" style="color:green"></h3></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script>
        $(document).ready(function(){
            $("#second").hide();
            $("#grades").on('submit',function(e){   
                e.preventDefault();
                  var year=$("#year").val();
                  var semester=$("#semester").val();
                  var subject=$("#subject").val();
                  $.ajax({
                    url:"grades.php",
                    type:"POST",
                    data:{pyear:year,psemester:semester,psubject:subject},
                    success:function(data){
                        data=$.parseJSON(data);
                        $.each(data,function(key,value){
					var courseid=value.courseid;
					var studentid=value.id;
					var student=value.firstname+" "+value.lastname;
					var grade=value.grade;
                    var professorid=value.professorid;
                    var editid=studentid+" "+courseid+" "+professorid;
                    var tablerow= '<tr><td>'+studentid+'</td><td>'+student+'</td><td><input style="width:40px; text-align:center" value="'+grade+'" id="'+editid+'"></input></td></tr>';
                    $("#nyear").text('Year: '+ year);
                    $("#nsemester").text('Semester: '+ semester);
                    $("#ncourseid").text('Course ID: '+ courseid);
                    $("#ncourse").text('Course ID: '+ subject);
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
            $("#allgrades").on('change','input',function () {
                
                var grade=$(this).val();
                var graderegex=/^[A-F]{1}$/;
                var id=$(this).attr("id");
                if(graderegex.test(grade)){
                $("#save").on("click",function () {
                    $.ajax({
                    url:"grades.php",
                    type:"POST",
                    data:{newgrade:grade,gradeid:id},
                    success:function(data){
                        if(data=="5"){
                            // location.reload();
                            $("#msg").html('');
                            $("#msg").text("Grade Updated Successfully");
                            $("#main").hide();
                            $("#second").show();
                                    function myFunction() {
                                setTimeout(function(){ $("#msg").html(''); }, 2000);
                                }
                            myFunction();
                        }
                        
                    }
        })      
                })
            }
            if(!graderegex.test(grade)){
                $("#msg").html('');
                $("#msg").text("Grade can only be A-F");
            }
                
            })
        });
    </script>
    <script src='logout.js'></script>
</body>
</html>