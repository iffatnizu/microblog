
statusAreaClear = false;

var userfeed = {
    
    likeFeed:function(feedId)
    {
        $.ajax({
            type:"POST",
            url:likeUrl,
            data:{
                "feedId":feedId,
                "isLike":'1'
            },
            success:function(res)
            {
                if(res == '1') {
                    window.location.reload();
                } else {
                    alert('You already like this feed.')
                }
            }
        })
    },
    dislikeFeed:function(feedId)
    {
        $.ajax({
            type:"POST",
            url:disLikeUrl,
            data:{
                "feedId":feedId,
                "isDislike":'1'
            },
            success:function(res)
            {
                if(res == '1') {
                    window.location.reload();
                } else {
                    alert('You already dislike this feed.')
                }
            }
        })
    },
    commentOnFeed:function(feedId)
    {
        var message = $('#commentMsg'+feedId+'').val();
        //alert(message);
        if($.trim(message) == '') {
            alert('Please enter your comment');
        } else {
            $.ajax({
                type:"POST",
                url:commentUrl,
                data:{
                    "feedId":feedId,
                    "message":message,
                    "isSubmit":'1'
                },
                success:function(res) {
                    //                    alert(res);
                    if(res == '1') {
                        $('#commentMsg'+feedId+'').val("");
                        window.location.reload();
                    } else if (res == '-1') {
                        alert('Please enter your comment');
                    }
                }
            })
        }
    },
    changeDisplayArea:function()
    {
        if(statusAreaClear==false)
        {
            $("div[class=status]").hide();     
        }
        $("div[class=doMore]").show();
        statusAreaClear = true;
    },
    showOption:function(value)
    {
        $("ul[id=feedOption_"+value+"]").toggle(); 
    },
    reportUser:function(id,uid)
    {
        var htm = '<h5>Why you want to report this post ? write a short description</h5>\n\
<textarea name="blockReason_'+id+'" style="width: 564px; height: 242px;"></textarea>\n\
<input type="button" value="Report" class="btn btn-danger" onclick="userfeed.sendBlockedReport(\''+id+'\',\''+uid+'\')"/>';
        $("span[class=lbtTitle]").html("Report post");
        $("div[id=lightBox]").fadeIn();
        $("div[class=lbtBody]").html(htm);
    },
    reportUser2:function(id)
    {
        var htm = '<h5>Why you want to report this user ? write a short description</h5>\n\
<textarea name="reportReason_'+id+'" style="width: 564px; height: 242px;"></textarea>\n\
<input type="button" value="Report" class="btn btn-danger" onclick="userfeed.sendReportUser(\''+id+'\')"/>';
        $("span[class=lbtTitle]").html("Report user");
        $("div[id=lightBox]").fadeIn();
        $("div[class=lbtBody]").html(htm);
    },
    sendReportUser:function(id)
    {
        var reportTxt = $("textarea[name=reportReason_"+id+"]").val();
        if(reportTxt!="")
        {
            $.ajax({
                type:"GET",
                url:base_url+"user/sendReportUser",
                data:{
                    "id":id,
                    "report":reportTxt,
                    "submit":"1"
                },
                success:function(response)
                {
                    //alert(response);
                    if(response=='1')
                    {
                        $("textarea[name=reportReason_"+id+"]").val("");
                        $("span[class=lbtStatus]").html("Report successfully sent");
                    }
                    else if(response=='2')
                    {
                        $("span[class=lbtStatus]").html("You already report once");  
                    }
                    else
                    {
                        $("span[class=lbtStatus]").html("Access Denied"); 
                    }
                }
            })     
        }
    },
    sendBlockedReport:function(id,uid)
    {
        var reportTxt = $("textarea[name=blockReason_"+id+"]").val();
        if(reportTxt!="")
        {
            $.ajax({
                type:"GET",
                url:base_url+"user/sendBlockedReport",
                data:{
                    "id":id,
                    "report":reportTxt,
                    "uid":uid,
                    "submit":"1"
                },
                success:function(response)
                {
                    //alert(response);
                    if(response=='1')
                    {
                        $("textarea[name=blockReason_"+id+"]").val("");
                        $("span[class=lbtStatus]").html("Report successfully sent");
                    }
                    else if(response=='2')
                    {
                        $("span[class=lbtStatus]").html("You already report once");  
                    }
                    else
                    {
                        $("span[class=lbtStatus]").html("Access Denied"); 
                    }
                }
            })     
        }
    },
    sendMsgToUser:function(id)
    {
        var htm = '<h5>Write your message here</h5>\n\
<textarea name="message_'+id+'" style="width: 564px; height: 242px;"></textarea>\n\
<input type="button" value="Send" class="btn btn-info" onclick="userfeed.sendMsgUser(\''+id+'\')"/>';
        $("span[class=lbtTitle]").html("Send private message to user");
        $("div[id=lightBox]").fadeIn();
        $("div[class=lbtBody]").html(htm);
    },
    sendMsgUser:function(id)
    {
        //alert(id);
        var privateMsgTxt = $("textarea[name=message_"+id+"]");
        if(privateMsgTxt.val()=="")
        {
            privateMsgTxt.css({
                "background":"#f5f5f5"
            })
        }
        else
        {
           $.ajax({
               type:"GET",
               url:sendPrivateMsgUrl,
               data:{
                   "id":id,
                   "msg":privateMsgTxt.val()
               },
               success:function(response)
               {
                   //alert(response);
                   if(response=='1')
                    {
                        $("textarea[name=message_"+id+"]").val("");
                        $("span[class=lbtStatus]").html("Message successfully sent");
                    }
                    else
                    {
                        $("span[class=lbtStatus]").html("Access Denied"); 
                    }
               }
           })         
        }
    }
}

$(document).ready(function(){
    
    })