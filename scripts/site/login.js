
var userlogin = {
    
    doLogin: function(form){
        $(".loginstatus").html("Verifying user Info....");
        $.ajax({
            type:"POST",
            url:base_url+'user/checkLogin',
            data:form.serialize()+"&signin=1",
            success:function(res){
                //                alert(res);
                if(res=='0') {
                    $("input[type=password]").val("");
                    $(".loginstatus").html("Incorrect usernname and password");
                } 
                else if(res=='2') {
                    $(".loginstatus").html("Your account is blocked");
                } 
                else{
                    $(".loginstatus").html("Logged in success redirecting....");
                    
                    setTimeout(function(){
                        location.href=base_url+'user/feed.php';
                    },2000)
                }
            }
        })
        return false;
    },
    doRegistration: function(form){
        var name = form.find("input[name=txtName]").val();
        var email = form.find("input[name=txtEmail]").val();
        var password = form.find("input[name=txtPassword]").val();
        var confpassword = form.find("input[name=txtConPassword]").val();
        var error = 0;
        if(name=="") {
            $("span[class=nameerror]").html("Enter your name"); 
            error = 1;
        } else {
            $("span[class=nameerror]").html(""); 
        }
        
        var emailpat=/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        var matcharray= email.match(emailpat);
        
        if(matcharray==null) {
            $("span[class=emailerror]").html("Enter your valid email"); 
            error=1;
        } else {
            $("span[class=emailerror]").html("");
        }
        
        if(password=="") {
            $("span[class=passerror]").html("Please Enter passowrd"); 
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
            $(".registrationstatus").html("Verifying user registration info....");
           
            $.ajax({
                type:"POST",
                url:base_url+"user/signup",
                data:{
                    "name":name,
                    "email":email,
                    "password":password,
                    "confpassword":confpassword,
                    "signup":'1'
                },
                success:function(res){
                    $("input[type=password]").val("");
                    if(res=='1'){
                        $(".registrationstatus").html("User registration successful. Please Login.");    
                        $("input[type=text]").val("");
                    } else{
                        $("span[class=emailerror]").html("This email is already in use");
                    }
                    setTimeout(function(){
                        $(".registrationstatus").html("");
                    },3000)
                }
            })
        }
        return false;
    }
}

$(document).ready(function(){
    $("form[class=form-signin]").submit(function(){
        return userlogin.doLogin($(this));
    })
    $("form[class=form-registration]").submit(function(){
        return userlogin.doRegistration($(this));
    })
})