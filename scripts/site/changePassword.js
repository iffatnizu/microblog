
var changepassword = {
    
    updatePassword: function(form){
        var oldPassword = form.find("input[name=oldPassword]").val();
        var password = form.find("input[name=newPassword]").val();
        var confpassword = form.find("input[name=confNewPassword]").val();
        var error = 0;
        if(oldPassword=="") {
            $("span[class=oldpasserror]").html("Enter your old password"); 
            error = 1;
        } else {
            $("span[class=oldpasserror]").html(""); 
        }
        
        if(password=="") {
            $("span[class=passerror]").html("Please enter your new passowrd"); 
            $("input[type=password]").val("");
            error = 1;
        } else if(password.length < 6) {
            $("span[class=passerror]").html("Passowrd should be minimum (6) character"); 
            $("input[type=password]").val("");
            error = 1;
        } else {
            $("span[class=passerror]").html(""); 
        }
        
        if(confpassword !=password) {
            $("span[class=confpasserror]").html("Confirm passowrd does not match"); 
            $("input[type=password]").val("");
            error = 1;
        } else {
            $("span[class=confpasserror]").html(""); 
        }

        if(error==0) {
            $(".updateStatus").html("Verifying user password....");
           
            $.ajax({
                type:"POST",
                url:base_url+"user/updatePassword",
                data:{
                    "oldPassword":oldPassword,
                    "password":password,
                    "updatePass":'1'
                },
                success:function(res){
                    if(res=='1'){
                        $(".updateStatus").html("Password successfully updated.");
                        $("input[type=password]").val("");
                        setTimeout(function(){
                            location.href=base_url+'user/changePassword.php';
                        },3000)
                    } else{
                        $(".updateStatus").html("");
                        $("input[type=password]").val("");
                        $("span[class=oldpasserror]").html("Old Password does not match");
                    }
                }
            })
        }
        return false;
    }
}

$(document).ready(function(){
    $("form[class=custom-form]").submit(function(){
        return changepassword.updatePassword($(this));
    })
})