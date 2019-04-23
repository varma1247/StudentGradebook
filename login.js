$(document).ready(function(){
   
    $("#login").on('submit',function(e){
        e.preventDefault();
        var loginDetails=$("#login").serialize();
        // console.log(loginDetails);
        var email=$('#email').val();
        var password=$('#password').val();
        var emailregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var passwordregex=/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/;
        if(!emailregex.test(email)&&email.length<30){
            $("#msg").html('');
            $("#msg").text("Invalid email");
            
        }
        if(!passwordregex.test(password)){
            $("#msg").html('');
            $("#msg").text("Incorrect Password");
            
        }
        if(emailregex.test(email)&&passwordregex.test(password)){
        $.ajax({
            url:"login.php",
            type:"POST",
            data:loginDetails,
            success:function(data){
                // console.log(data);
                if(data=="1")
                {
                    window.location.replace("student.php");
                }
                else if(data=="2")
                {
                    window.location.replace("professor.php");
                }
                else if(data=="3")
                {
                    window.location.replace("admin.php");
                }
                else if(data=="nouser")
                {
                    $("#msg").html('');
                    $("#msg").text("Incorrect Details");
                }
                else if(data=='notapproved'){
                    $("#msg").html('');
                    $("#msg").text("Waiting for approval");
                }
                
                
            }
        })
    }
    });
    $("#register").on('click',function () {
        window.location.replace("signup.html");
        // console.log("clicked");
         
    });
});