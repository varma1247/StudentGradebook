$(document).ready(function () {
    $("#signup").on('submit', function (e) {
        e.preventDefault();
        var signupDetails = $("#signup").serialize();
        console.log($('#email').val());
        var email = $('#email').val();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var id = $('#id').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();
        var emailregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var passwordregex = /^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{8,15}$/;
        var idregex = /^[1][0]{2}[0-9]{7}$/;
        var nameregex = /^[a-zA-Z]{1,20}$/;
        if (!emailregex.test(email) && email.length < 30) {
            $("#msg").html('');
            $("#msg").text("Invalid email");

        }
        if (!passwordregex.test(password)) {
            $("#msg").html('');
            $("#msg").text("Password should contain atleast one uppercase,one lowercase and a digit");

        }
        if (!passwordregex.test(confirmPassword)) {
            $("#msg").html('');
            $("#msg").text("Password should contain atleast one uppercase,one lowercase and a digit");
        }
        if (!idregex.test(id)) {
            $("#msg").html('');
            $("#msg").text("Invalid ID");

        }
        if (!nameregex.test(firstname)) {
            $("#msg").html('');
            $("#msg").text("Invalid Firstname");

        }
        if (!nameregex.test(lastname)) {
            $("#msg").html('');
            $("#msg").text("Invalid Lastname");

        }
        if (emailregex.test(email) && passwordregex.test(password) && passwordregex.test(confirmPassword) && idregex.test(id) && nameregex.test(lastname) && nameregex.test(firstname)) {
            $.ajax({
                url: "signup.php",
                type: "POST",
                data: signupDetails,
                success: function (data) {
                    // console.log(data);

                    if (data == "emptyerror") {
                        $("#msg").html('');
                        $("#msg").text("Enter all the details");
                    }
                    else if (data == "passworderror") {
                        $("#msg").html('');
                        $("#msg").text("Passwords are not matching");
                    }
                    else if (data == "iderror") {
                        $("#msg").html('');
                        $("#msg").text("Enter Valid ID");
                    }
                    else if (data == 'success') {
                        $("#msg").html('');
                        $("#msg").text("Registration successful");
                        setTimeout(function () {
                            window.location.replace("login.html");
                        }, 2000);
                    }
                    else if (data == "idexisterror") {
                        $("#msg").html('');
                        $("#msg").text("ID or Email already exist");

                    }
                }
            })
        }
    });
    $("#login").on('click', function () {
        window.location.replace("login.html");
        // console.log("clicked");

    });
});