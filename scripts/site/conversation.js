var isClick = false;
var loadId ;


var microblog = {
    
    getAllMessageById:function(id)
    {
        $(".msgTitleBox ul li").css({
            "background":"#F7F7F7"
        })
        $("li[id=pmid_"+id+"]").css({
            "background":"#DBEAF9"
        });
        $("ul[id=msgList]").html("");
        $.ajax({
            type:"GET",
            url:base_url+"message/getMessages",
            data:{
                "fid":id,
                "submit":"1"
            },
            success:function(res)
            {
                if(res!=""){
                    $("div[id=reportArea]").html('<a onclick="directory.vendorReportViolation(\''+id+'\',\'user\')" href="javascript:;"><i class="icon-minus-sign"></i><br/>Report</a>');
                    $("div[class=sendarea]").show();
                    var obj = $.parseJSON(res);
                    $.each(obj,function(index,value){
                        var tag = '<li id="" class="'+value.cssclass+'"><h6><i class="icon-user"></i> '+value.username+' Says :</h6><p>'+value.chatMessage+'</p></li><br clear="all"/>';
                        $("ul[id=msgList]").append(tag);
                    })
                
                    var sendarea = '<div contenteditable="true" id="pageContent" class="sendReply_'+id+'"></div><br clear="all"/><input onclick="microblog.sendReply(\''+id+'\')" type="button" class="btn btn-info" name="sendMsg" value="Send"/> <img onclick="microblog.openImo()" id="openImo" src="'+base_url+'assets/public/imo/emot-blink.gif" alt="icon"/>';
                
                    $("div[class=sendMsgWriteArea]").html(sendarea);
                    
                    isClick = true; 
                    loadId = id;
                }
            }
        })

    },
    intervalForLoadMessage:function()
    {
        $.ajax({
            type:"GET",
            url:base_url+"message/getMessages",
            data:{
                "fid":loadId,
                "submit":"1"
            },
            success:function(res)
            {               
                if(res!=""){
                    $("ul[id=msgList]").html("");
                    var obj = $.parseJSON(res);
                    $.each(obj,function(index,value){
                        var tag = '<li id="" class="'+value.cssclass+'"><h6><i class="icon-user"></i> '+value.username+' Says :</h6><p>'+value.chatMessage+'</p></li><br clear="all"/>';
                        $("ul[id=msgList]").append(tag);
                    })

                }
            }
        })

    },
    
    forceLoadMessage:function()
    {
        $("a[class=pm_1]").trigger("click");
    },
    sendReply:function(fid)
    {
        var replyMsg = $("div[class=sendReply_"+fid+"]").html();
        if(replyMsg=="")
        {
            $("div[class=sendReply_"+fid+"]").css({
                "border-color":"red"
            })      
        }
        else{
            $.ajax({
                type:"POST",
                url:base_url+'message/sendReply',
                data:{
                    "replyMsg":replyMsg,
                    "fid":fid,
                    "submit":"1"
                },
                success:function(res){
                    var obj = $.parseJSON(res);
                    var tag = '<li id="" class="'+obj.cssclass+'"><h6><i class="icon-user"></i> '+obj.username+' Says :</h6><p>'+obj.chatMessage+'</p></li><br clear="all"/>';
                    $("ul[id=msgList]").append(tag);
                    $("div[class=sendReply_"+fid+"]").html("");
                }
            })
        }
    },
    openImo:function()
    {
        $("ul[id=imoticons]").toggle();
    },
    insertImo:function(i_string)
    {
        var htm = '<img src="'+base_url+'assets/public/imo/'+i_string+'" alt="imo"/>';
        $("div[id=pageContent]").append(htm);
    }
    
}
$(document).ready(function(){   
    microblog.forceLoadMessage();
    
    setInterval(function(){
        if(isClick==true)
        {
            microblog.intervalForLoadMessage();    
        }
    },7000)
})

