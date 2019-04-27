$(document).ready(function () {
    var sessionexpired="no";
    function checksession() {
    $.ajax({
        url: "to.php",
        type: "POST",
        data: { timeout: "timeout" },
        success: function (data) {
            if (data == "sto"){
            $('body').html("<h3 class='text-center'>SESSION TIMED OUT!!<a href='login.html' style='margin-left:30px;'>click here to login again</a></h3>")
            sessionexpired="yes";
            }
        }
    })
}
var timeout=setInterval(function () {
    checksession();
    if(sessionexpired=="yes"){
        clearInterval(timeout);
    }
},35000);
});