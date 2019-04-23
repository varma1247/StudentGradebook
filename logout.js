$(document).ready(function(){
   
    $("#logout").on('click',function(e){
        $.ajax({
            url:"logout.php",
            type:"POST",
            data:{logout:"logout"},
            success:function(data){
                if(data=="logout");
                window.location.replace("login.html");

            }
        })
    });
});