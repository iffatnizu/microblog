<div class="mbFeedLeft">
    <script type="text/javascript">
        var sendPrivateMsgUrl = '<?php echo base_url().SiteConfig::CONTROLLER_MESSAGE.SiteConfig::METHOD_MESSAGE_SEND_MSG_TO_USER ?>';
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/userFeed.js"></script>
    <!--status-->
    <div class="statusUpdate">
        <p>
            <i class="icon-user"></i> <?php echo $userName; ?> All Status 
            <?php
            if ($this->session->userdata('userId') != $usrId) {
                ?>
            <a style="float: right;margin-left: 10px;" onclick="userfeed.reportUser2('<?php echo cxpencode($usrId) ?>')" href="javascript:;"><i class="icon-flag"></i> Report</a>
                <a style="float: right;" onclick="userfeed.sendMsgToUser('<?php echo cxpencode($usrId) ?>')" href="javascript:;"><i class="icon-mail-forward"></i> Send Message</a>
                <?php
            }
            ?>
        </p>
    </div>

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
                            if ($this->session->userdata('userId') != $usrId) {
                                ?>
                                <span class="option">
                                    <a onclick="userfeed.showOption('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID] ?>')" href="javascript:;"><i class="icon-cog"></i></a>
                                    <ul id="feedOption_<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID] ?>">
                                        <li><a onclick="userfeed.reportUser('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID] ?>')" href="javascript:;">Report</a></li>
                                    </ul>
                                </span>
                                <?php
                            }
                            ?>
                        </h3>
                        <!--                    <h5>                                     
                                                <a href="#"><i class="icon-arrow-right"></i>The next free PSD download is available in Fotolia’s TEN </a>
                                            </h5>-->
                    </div>
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
                            }
                            ?>
                            like this
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
                            <div id="commentMsg<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>" class="rcWritePanel" contenteditable="true"></div>
                            <input class="btn btn-small btn-signup" onclick="userfeed.commentOnFeed('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>');" type="button" name="comment" value="Comment"/>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="statusUpdate">
            <p><i class="icon-remove"></i> No Post Found... </p>
        </div>
    <?php } ?>
</div>
