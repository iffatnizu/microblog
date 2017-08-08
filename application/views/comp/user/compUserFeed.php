<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?> | Micro Blog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="Your Local Catering"/>
        <meta name="keyword" content="directory, services, restaurent"/>
        <meta name="author" content=""/>
        <!-- Le styles -->

        <link href="<?php echo base_url() ?>assets/css/site.css" rel="stylesheet"/>
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/core/jquery-1.9.1.js"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                  <script src="<?php echo base_url() ?>scripts/plugins/bootstrap/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->

        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/ico/favicon.ico"/>
        <script type="text/javascript">
            var base_url = '<?php echo base_url() ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/site.js"></script>
    </head>
    <body id="microblog">
        <div class="wrapper mainWrapper">
            <div class="mbUserFeed">
                <div class="mbCoverPhoto">
                    <img src="<?php echo base_url() ?>assets/images/demo-cover-img.png" alt="feed"/>
                </div>
                <div class="mbUserPhoto">
                    <?php if ($userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                        <img src="<?php echo base_url(); ?>assets/public/userProfileImage/<?php echo $userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                    <?php } ?>
                </div>
                <div class="displayInfo">
                    <?php echo (isset($userInfo[DbConfig::TABLE_USER_ATT_NAME])) ? $userInfo[DbConfig::TABLE_USER_ATT_NAME] : ''; ?>
                </div>
                <div class="userMenu">
                    <ul>
                        <li><a class="btn" href="<?php echo base_url(); ?>"><i class="icon-home"></i> Home</a></li>
                        <li><a class="btn" href="#"><i class="icon-cogs"></i> Setting</a></li>
                        <li><a class="btn" href="<?php echo site_url(SiteConfig::CONTROLLER_CONNECTION); ?>"><i class="icon-link"></i> Connection </a></li>
                        <li><a class="btn" href="#"><i class="icon-user"></i> Followers </a></li>
                        <li><a class="btn" href="#"><i class="icon-user"></i> Followings </a></li>
                        <li><a class="btn" href="<?php echo site_url(SiteConfig::CONTROLLER_USER.SiteConfig::METHOD_USER_LOGOUT); ?>"><i class="icon-lock"></i>  Logout </a></li>
                    </ul>
                </div>
                <br class="clearfix"/>

                <!--feed---->
                <div class="mbFeedLeft">

                    <!--status-->
                    <div class="statusUpdate">
                        <p><i class="icon-pencil"></i> Update Status</p>
                        <span class="arrow"></span>
                        <div class="status" contenteditable="true" onclick="microblog.changeDisplayArea()">What's on your mind?</div>
                        
                        <div class="doMore">
                            <ul>
                                <li><input type="file" name="userfile"/></li>
                            </ul>
                            <input type="button" name="share" class="btn btn-info" value="POST"/>
                        </div>
                    </div>

                    <?php
//                    debugPrint($allFeeds);
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
                                            <a href="#"><i class="icon-user"></i> <?php echo $feed['userDetail'][DbConfig::TABLE_USER_ATT_NAME]; ?></a>
                                        </h3>
                                        <h5>                                     
                                            <a href="#"><i class="icon-arrow-right"></i>The next free PSD download is available in Fotolia’s TEN </a>
                                        </h5>
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
                                        <a id="like" href="javascript:;" onclick="microblog.likeFeed('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>')"><i class="icon-heart"></i> Like</a>
                                        <a id="dislike" href="javascript:;" onclick="microblog.dislikeFeed('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>')"><i class="icon-remove"></i> Dislike</a>

                                        <hr/>
                                        <a class="uName" href="javascript:;">
                                            <?php
                                            if (!empty($feed['allLikes'])) {
                                                foreach ($feed['allLikes'] as $like) {
                                                    if (!empty($like['likeUser'])) {
                                                        if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] == $this->session->userdata('userId')) {
                                                            echo 'You and ';
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php
                                            if (!empty($feed['allLikes'])) {
                                                $i = 1;
                                                foreach ($feed['allLikes'] as $like) {
                                                    $i++;
                                                    if (!empty($like['likeUser'])) {
                                                        if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] != $this->session->userdata('userId')) {
                                                            echo $like['likeUser'][DbConfig::TABLE_USER_ATT_NAME];
                                                        }

                                                        if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] != $this->session->userdata('userId') && (sizeof($feed['allLikes']) != $i)) {
                                                            echo ', ';
                                                        } else if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] != $this->session->userdata('userId') && (sizeof($feed['allLikes']) == $i) && isset($like['others']) && $like['others'] != '0') {
                                                            echo ' and ';
                                                        }
                                                    }
                                                    if (!empty($feed['allLikes']['others']) && $feed['allLikes']['others'] != '0') {
                                                        echo $feed['allLikes']['others'] . ' others';
                                                    }
                                                }
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
                                            <input class="btn btn-small btn-signup" onclick="microblog.commentOnFeed('<?php echo $feed[DbConfig::TABLE_FEED_ATT_FEED_ID]; ?>');" type="button" name="comment" value="Comment"/>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <!--                    <div class="mbBtmFix">
                                            <div class="propic">
                                                <img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/>
                                            </div>
                                            <div class="feedarea">
                                                <div class="fTitle">
                                                    <h3>
                                                        <a href="#"><i class="icon-user"></i> Peterson</a>
                                                    </h3>
                                                    <h5>                                     
                                                        <a href="#"><i class="icon-arrow-right"></i>The info panel uncovers lesser-known information about your </a>
                                                    </h5>
                                                </div>
                                                <div class="fDescription">
                                                    <p>
                                                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                    </p>
                                                    <p>
                                                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                    </p>
                                                </div>
                    
                                                <div class="commentArea">
                                                    <a id="like" href="#"><i class="icon-heart"></i> Like</a>
                                                    <a id="dislike" href="#"><i class="icon-remove"></i> Dislike</a>
                    
                                                    <hr/>
                                                    <a class="uName" href="#">Mick, Nizu, jobayer, sadeq and 200 thers like this</a>
                                                    <hr/>
                    
                                                    <div class="writeComment">
                                                        <div class="rcImg">
                                                            <img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/>
                                                        </div>
                                                        <div class="rcWritePanle" contenteditable="true">
                    
                                                        </div>
                                                        <input class="btn btn-small btn-signup" type="button" name="comment" value="Comment"/>
                                                    </div>
                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mbBtmFix">
                                            <div class="propic">
                                                <img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/>
                                            </div>
                                            <div class="feedarea">
                                                <div class="fTitle">
                                                    <h3>
                                                        <a href="#"><i class="icon-user"></i> Michael</a>
                                                    </h3>
                                                    <h5>                                     
                                                        <a href="#"><i class="icon-arrow-right"></i>The next free PSD download is available in Fotolia’s TEN </a>
                                                    </h5>
                                                </div>
                                                <div class="fImg">
                                                    <img src="<?php echo base_url() ?>assets/images/demo-post-pic-2.png" alt="feed"/>
                                                </div>
                    
                                                <div class="commentArea">
                                                    <a id="like" href="#"><i class="icon-heart"></i> Like</a>
                                                    <a id="dislike" href="#"><i class="icon-remove"></i> Dislike</a>
                    
                                                    <hr/>
                                                    <a class="uName" href="#">Mick, Nizu, jobayer, sadeq and 200 thers like this</a>
                                                    <hr/>
                    
                                                    <div class="writeComment">
                                                        <div class="rcImg">
                                                            <img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/>
                                                        </div>
                                                        <div class="rcWritePanle" contenteditable="true">
                    
                                                        </div>
                                                        <input class="btn btn-small btn-signup" type="button" name="comment" value="Comment"/>
                                                    </div>
                    
                                                </div>
                                            </div>
                                        </div>-->

                    <a href="#" class="loading"><i class="icon-spinner icon-spin icon-2x pull-left"></i> Loading... </a>
                </div>
                <!-------------->
                <div class="mbFeedRight">
                    <div class="follower">
                        <h3><i class="icon-group"></i> FOLLOWER</h3>
                        <ul>
                            <?php
                            if (!empty($followerList)) {
                                foreach ($followerList as $follower) {
                                    ?>
                                    <li>
                                        <a href="javascript:;">
                                            <?php if ($follower['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                                                <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $follower['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
                                            <?php } ?>

                                            <?php echo $follower['userDetail'][DbConfig::TABLE_USER_ATT_NAME]; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            <!--                            <li>
                                                            <a href="#">
                                                                <img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/>
                            
                                                                Michael 
                                                            </a>
                                                        </li>-->

                        </ul>
                    </div>

                    <div class="connection">
                        <h3><i class="icon-group"></i> CONNECTION</h3>
                        <ul>
                            <?php
                            if (!empty($connectionList)) {
                                foreach ($connectionList as $connection) {
                                    ?>
                                    <li>
                                        <a href="#">
                                            <?php if ($connection['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                                                <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $connection['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
                                            <?php } ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
<!--                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/></a></li>                     
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
