<div class="mbFeedLeft">
    <script type="text/javascript">
        var likeUrl = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LIKE_FEED); ?>';
        var disLikeUrl = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_DISLIKE_FEED); ?>';
        var commentUrl = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_COMMENT_ON_FEED); ?>';
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/userFeed.js"></script>
    <!--status-->
    <div class="statusUpdate">
        <p><i class="icon-pencil"></i> Update Status</p>
        <?php if ($this->session->userdata('insertPost')) { ?>
            <p>You status Successfully inserted.</p>
            <?php
            $data['insertPost'] = FALSE;
            $this->session->unset_userdata($data);
        } if ($this->session->userdata('fileError') || $this->session->userdata('insertError')) {
            echo $this->session->userdata('fileError');
            echo '<p> OR Maybe not post any status</p>';

            $data['fileError'] = FALSE;
            $data['insertError'] = FALSE;
            $this->session->unset_userdata($data);
        }
        ?>
        <span class="arrow"></span>
        <div class="status" contenteditable="true" onclick="userfeed.changeDisplayArea()">What's on your mind?</div>

        <div class="doMore">
            <form method="post" action="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FEED); ?>" enctype="multipart/form-data">
                <textarea name="<?php echo DbConfig::TABLE_FEED_ATT_FEED_TEXT; ?>" style="width: 706px; padding: 2px; min-height: 60px;"></textarea>
                <ul>
                    <li><input type="file" name="userfile"/></li>
                </ul>
                <input type="submit" style="float: right;" name="share" class="btn btn-info" value="POST"/>
            </form>
        </div>
    </div>

    <div id="loadarea">
        <?php
        //debugPrint($allFeeds);
        if (!empty($allFeeds)) {
            foreach ($allFeeds as $feed) {
                ?>

                <div class="mbBtmFix">
                    <div class="propic">
                        <?php if ($feed['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                            <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $feed['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                        <?php } else { ?> 
                            <img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/>
                        <?php } ?>
                    </div>
                    <div class="feedarea">
                        <div class="fTitle">
                            <h3>
                                <a href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_USERS_FEED . '/' . $feed[DbConfig::TABLE_USER_ATT_USER_ID]); ?>"><i class="icon-user"></i> <?php echo $feed['userDetail'][DbConfig::TABLE_USER_ATT_NAME]; ?></a>

                                <?php
                                if ($this->session->userdata('userId') != $feed[DbConfig::TABLE_FEED_ATT_USER_ID]) {
                                    ?>
                                    <span class="option">
                                        <a onclick="userfeed.showOption('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID] ?>')" href="javascript:;"><i class="icon-cog"></i></a>
                                        <ul id="feedOption_<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID] ?>">
                                            <li><a onclick="userfeed.reportUser('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID] ?>','<?php echo $feed[DbConfig::TABLE_FEED_ATT_USER_ID] ?>')" href="javascript:;">Report</a></li>
                                        </ul>
                                    </span>

                                    <?php
                                }
                                ?>
                            </h3>
                            <!--                        <h5>                                     
                                                        <a href="#"><i class="icon-arrow-right"></i>The next free PSD download is available in Fotolia’s TEN </a>
                                                    </h5>-->
                        </div>
                        <br clear="all"/>
                        <?php if ($feed[DbConfig::TABLE_FEED_ATT_IMAGE_NAME] != '') { ?>
                            <div class="fImg">
                                <img src="<?php echo base_url() ?>assets/public/feedImage/<?php echo $feed[DbConfig::TABLE_FEED_ATT_IMAGE_NAME]; ?>" alt="feed"/>
                            </div>
                        <?php } else if ($feed[DbConfig::TABLE_FEED_ATT_FEED_TEXT] != '') { ?>
                            <div class="fDescription">
                                <p>
                                    <?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_TEXT]; ?>
                                </p>
                            </div>
                        <?php } ?>
                        <div class="commentArea">
                            <a id="like" href="javascript:;" onclick="userfeed.likeFeed('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>')"><i class="icon-heart"></i> Like</a>
                            <a id="dislike" href="javascript:;" onclick="userfeed.dislikeFeed('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>')"><i class="icon-remove"></i> Dislike</a>

                            <hr/>
                            <a class="uName" href="javascript:;">
                                <?php
                                if (!empty($feed['allLikes'])) {
                                    $flag = '0';
                                    foreach ($feed['allLikes'] as $like) {
                                        if (!empty($like['likeUser'])) {
                                            if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] == $this->session->userdata('userId')) {
                                                echo 'You ';
                                                $flag = '1';
                                            }
                                        }
                                    }
                                }
                                ?>
                                <?php
//                        debugPrint($feed['allLikes']);
                                if (!empty($feed['allLikes'])) {
                                    $i = 1;
                                    foreach ($feed['allLikes'] as $like) {
                                        $i++;
                                        if (!empty($like['likeUser'])) {
                                            if ($flag == '1' && $like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] != $this->session->userdata('userId')) {
                                                echo ', ';
                                            }
                                            if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] != $this->session->userdata('userId')) {
                                                echo $like['likeUser'][DbConfig::TABLE_USER_ATT_NAME];
                                            }

                                            if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] != $this->session->userdata('userId') && (sizeof($feed['allLikes']) == $i) && isset($like['others']) && $like['others'] != '0') {
                                                echo ' and ';
                                            }
                                        } else if ($like['others'] != '0') {
                                            echo ' ' . $like['others'] . ' others';
                                        }
                                    }
//                                if (!empty($feed['allLikes']['others']) && $feed['allLikes']['others'] != '0') {
//                                    echo $feed['allLikes']['others'] . ' others';
//                                }
                                    echo ' like this';
                                }
                                ?>
                                <!--Mick, Nizu, jobayer, sadeq and 200 thers like this-->
                            </a>
                            <hr/>

                            <div class="writeComment">
                                <div class="showcomment">
                                    <?php
                                    if (!empty($feed['allComments'])) {
                                        foreach ($feed['allComments'] as $comments) {
                                            ?>

                                            <div class="rcImg">
                                                <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $comments['commentUser'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                                            </div>
                                            <div class="rcWritePanel">
                                                <?php echo $comments[DbConfig::TABLE_COMMENT_ATT_COMMENT]; ?>
                                            </div>


                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="rcImg">
                                    <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                                </div>
<!--                            <div id="commentMsg<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>" class="rcWritePanel" contenteditable="true"></div>-->
                                <textarea id="commentMsg<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>" class="rcWritePanel" style="width: 595px; height: 39px;"></textarea>
                                <input class="btn btn-small btn-signup" onclick="userfeed.commentOnFeed('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>');" type="button" name="comment" value="Comment"/>
                            </div>

                        </div>
                    </div>
                </div>

                <?php
            }
        }
        ?>
    </div>


    <script type="text/javascript">
        var loadkey;
        
        $(window).scroll(function() {
            if($(window).scrollTop() == $(document).height() - $(window).height()) {
                $("a[class=loading]").trigger("click");
            }
        })
      
        function loadMore()
        {
            
            var id = $("a[class=loading]").attr('id');
            //alert(id);
            $.ajax({
                type:"GET",
                url:"<?php echo base_url() . SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOAD_MORE ?>",
                data:{
                    "id":id
                },
                success:function(res)
                {
                    var obj = $.parseJSON(res);

                    $.each(obj,function(index,value){
                                                
                        var postimg = value.imageName;
                        
                        if(postimg!="")
                        {
                            postimg = '<img alt="img" src="'+base_url+"assets/public/feedImage/"+value.imageName+'"/>'; 
                        }
                        
                        var numoflikes = value.allLikes;
                        
                        if(numoflikes!=0)
                        {
                            numoflikes = value.allLikes;
                        }
                        
                        //console.log(numoflikes);
                        
                        var html = '<div class="mbBtmFix">\n\
<div class="propic">\n\
<img alt="userImg" src="'+base_url+"assets/public/userProfileImage/"+value.userDetail.profileImage+'">\n\
</div>\n\
<div class="feedarea">\n\
<div class="fTitle"><h3><a href="javascript:;"><i class="icon-user"></i> '+value.userDetail.name+' </a>'+value.feedOpt+'</h3></div><br clear="all"/>\n\
<div class="fDescription">\n\
<div class="fImg">'+postimg+'</div>\n\
<p>'+value.feedText+'</p>\n\
</div>\n\
<div class="commentArea">\n\
<a id="like" href="javascript:;" onclick="userfeed.likeFeed('+value.feedId+')"><i class="icon-heart"></i> Like</a>\n\
<a id="dislike" href="javascript:;" onclick="userfeed.dislikeFeed('+value.feedId+')"><i class="icon-remove"></i> Dislike</a>\n\
<hr/><a href="javascript:;" class="uName">'+numoflikes+'</a><hr/>\n\
<div class="writeComment">\n\
<div id="show_comment_'+value.feedId+'" class="showcomment"></div>\n\
<div class="rcImg"><img src="'+base_url+'assets/public/userProfileImage/'+value.userDetail.profileImage+'" alt="userImg"/></div>\n\
\n\
<textarea id="commentMsg'+value.feedId+'" class="rcWritePanel" style="width: 595px; height: 39px;"></textarea><input class="btn btn-small btn-signup" onclick="userfeed.commentOnFeed(\''+value.feedId+'\');" type="button" name="comment" value="Comment"/>\n\
</div>\n\
</div>\n\
</div>\n\
</div>';

                    
                        
                    $("div[id=loadarea]").append(html);
                    
                    $.each(value.allComments,function(i,v){
                        
                        //console.log(v.feedId+"-"+v.comment);
                        var schtml = '<div class="rcImg"><img src="'+base_url+'assets/public/userProfileImage/'+v.commentUser.profileImage+'" alt="userImg"/></div><div class="rcWritePanel">'+v.comment+'</div>';
                        
                        $('div[id=show_comment_'+v.feedId+']').append(schtml);
                    });
                })
                
                if(obj.length=="")
                {
                    $("a[class=loading]").html('No more post found');
                }
                else{
                    $("a[class=loading]").attr('id',obj[0].loadKey);
                }
               
                
            }
        })
    }
    $(window).scroll(function() {
        if($(window).scrollTop() > 250) {
            $("a[id=top]").fadeIn();
        }
        else{
            $("a[id=top]").fadeOut();
        }
    })
    </script>
    <a id="<?php echo $this->encrypt->encode($this->session->userdata('loadKey')); ?>" onclick="loadMore()" href="javascript:;" class="loading"><i class="icon-spinner icon-spin icon-2x pull-left"></i> Loading... </a>
    <a id="top" href="#top"><img style="float: right;background: #FFF;padding: 10px;border-radius:4px;position: fixed;margin-left: 280px;bottom: 0" width="32" src="<?php echo base_url() ?>assets/images/back-to-top.png" alt="back-to-top"/></a>
</div>
