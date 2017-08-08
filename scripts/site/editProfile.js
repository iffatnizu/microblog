
var userprofile = {
    
    updateProfile: function(form){
        var name = form.find("input[name=name]").val();
        var error = 0;
        if(name=="") {
            $("span[class=nameerror]").html("Enter your name"); 
            error = 1;
        } else {
            $("span[class=nameerror]").html(""); 
        }

        if(error==0) {
            $(".updateStatus").html("Updating user profile info....");
           
            $.ajax({
                type:"POST",
                url:base_url+"user/updateProfile",
                data:{
                    "name":name,
                    "update":'1'
                },
                success:function(res){
                    if(res=='1'){
                        $(".updateStatus").html("User profile successfully updated.");                    
                        setTimeout(function(){
                            location.href=base_url+'user/editProfile.php';
                        },3000)
                    }
                }
            })
        }
        return false;
    }
}

$(document).ready(function(){
    $("form[class=custom-form]").submit(function(){
        return userprofile.updateProfile($(this));
    })
})