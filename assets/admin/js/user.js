var microblog = {
    
    blockedUser:function(email)
    {
        var ans = confirm('Are you sure want to block?');
        if(ans) {
            $.ajax({
                type:"POST",
                data:{
                    "userEmail":email,
                    "submit":"1"
                },
                url:base_url+"administrator/blockedUser/",
                success:function(res)
                {
                    if(res == '1') {
                        alert('Successfully Blocked');
                        location.reload();
                    }
                    else{
                        alert('Something went wrong.try again');
                    }
                }
            })
        }
    },
    unblockedUser:function(email)
    {
        var ans = confirm('Are you sure want to block?');
        if(ans) {
            $.ajax({
                type:"POST",
                data:{
                    "userEmail":email,
                    "submit":"1"
                },
                url:base_url+"administrator/unblockedUser/",
                success:function(res)
                {
                    if(res == '1') {
                        alert('Successfully Unblocked');
                        location.reload();
                    }
                    else{
                        alert('Something went wrong.try again');
                    }
                }
            })
        }
    },
    deleteReport:function(rId)
    {
        var ans = confirm('Are you sure want to delete this report?');
        if(ans) {
            $.ajax({
                type:"POST",
                data:{
                    "reportId":rId,
                    "submit":"1"
                },
                url:base_url+"administrator/deleteReport/",
                success:function(res)
                {
                    if(res == '1') {
                        alert('Report Successfully Deleted');
                        location.reload();
                    }
                    else{
                        alert('Something went wrong.try again');
                    }
                }
            })
        }
    },
    deleteReportePost:function(rId)
    {
        var ans = confirm('Are you sure want to delete this report?');
        if(ans) {
            $.ajax({
                type:"POST",
                data:{
                    "reportId":rId,
                    "submit":"1"
                },
                url:base_url+"administrator/deleteReportePost/",
                success:function(res)
                {
                    if(res == '1') {
                        alert('Report Successfully Deleted');
                        location.reload();
                    }
                    else{
                        alert('Something went wrong.try again');
                    }
                }
            })
        }
    },
    deleteFeed:function(feedId)
    {
        var ans = confirm('Are you sure want to delete this report?');
        if(ans) {
            $.ajax({
                type:"POST",
                data:{
                    "feedId":feedId,
                    "submit":"1"
                },
                url:base_url+"administrator/deleteFeed/",
                success:function(res)
                {
                    if(res == '1') {
                        alert('Posts Successfully Deleted');
                        location.reload();
                    }
                    else{
                        alert('Something went wrong.try again');
                    }
                }
            })
        }
    }
}