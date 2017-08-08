
var usersearch = {
    
    userFollow:function(userId)
    {
        $.ajax({
            type:"POST",
            url:userFollowUrl,
            data:{
                "userId":userId
            },
            success:function(res)
            {
                if(res == '1') {
                    alert('Now you follow this user.');
                    location.reload();
                } else {
                    alert('You already follow this user.')
                }
            }
        })
    },
    userConnection:function(userId)
    {
        $.ajax({
            type:"POST",
            url:userConnectionUrl,
            data:{
                "userId":userId
            },
            success:function(res)
            {
                if(res == '1') {
                    alert('You connection request send.');
                    location.reload();
                } else {
                    alert('You already connected with this user.')
                }
            }
        })
    },
    userUnfollow:function(usrId)
    {
        $.ajax({
            type:"POST",
            url:userUnfollow,
            data:{
                "userId":usrId
            },
            success:function(res)
            {
                if(res == '1') {
                    alert('You connection ended with this user');
                    location.reload();
                } else {
                    alert('something went wrong try again')
                }
            }
        })
    },
    userDisconnect:function(usrId)
    {
        $.ajax({
            type:"POST",
            url:userDisconected,
            data:{
               "userId":usrId,
               "submit":"1"
            },
            success:function(res)
            {
                if(res == '1') {
                    alert('You successfully disconnected from this user');
                    location.reload();
                } else {
                    alert('something went wrong try again')
                }
            }
        })
    }
}

$(document).ready(function(){
    
})