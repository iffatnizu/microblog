<div class="mbCoverPhoto">
    
    <form class="searchForm" method="GET" action="<?php echo site_url(SiteConfig::CONTROLLER_USER.SiteConfig::METHOD_USER_SEARCH); ?>">
        <input type="text" name="u" placeholder="Type your text here" value="<?php echo isset($_GET['u'])?$_GET['u']:"" ?>"/>&nbsp; 
        <input type="submit" class="btn btn-signup" name="doSearch" value="Search"/>
    </form>
<!--    <img src="<?php echo base_url() ?>assets/images/demo-cover-img.png" alt="feed"/>-->
    <?php if ($userInfo[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE] != '') { ?>
        <img src="<?php echo base_url() . SiteConfig::DIR_USER_COVER_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE]; ?>" alt="Cover Image"/>
    <?php } ?>
</div>
<div class="mbUserPhoto">
    <?php if ($userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
        <img src="<?php echo base_url() . SiteConfig::DIR_USER_PROFILE_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
    <?php } else { ?>
        <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
    <?php } ?>
</div>
<div class="displayInfo">
    <?php 
    echo (isset($userInfo[DbConfig::TABLE_USER_ATT_NAME])) ? $userInfo[DbConfig::TABLE_USER_ATT_NAME] : ''; 
    
    $unread = getNumOfUnreadMsgByUser($this->session->userdata('userId'));
    ?>
</div>
<div class="userMenu">
    <ul>
        <li><a class="btn" href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FEED); ?>"><i class="icon-home"></i> Home</a></li>
        <li><a class="btn" href="<?php echo site_url(SiteConfig::CONTROLLER_MESSAGE.SiteConfig::METHOD_MESSAGE_INBOX); ?>"><i class="icon-envelope"></i> Inbox (<?php echo $unread; ?>) </a></li>
        <li>
<!--            <a class="btn" href="#"><i class="icon-cogs"></i> Setting</a>-->
            <div class="btn-group">
                <a href="javascript:;" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-cogs"></i> Setting <span class="caret" style="float: none;"></span>
                </a>
                <ul class="dropdown-menu">
<!--                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_USER); ?>"><i class="icon-link"></i> Statistics </a></li>-->
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_EDIT_PROFILE); ?>"><i class="icon-user"></i> Edit Profile </a></li>
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CHANGE_PASSWORD); ?>"><i class="icon-user"></i> Change Passwrod </a></li>
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CHANGE_PROFILE_PHOTO); ?>"><i class="icon-user"></i> Change Profile Photo </a></li>
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CHANGE_COVER_IMAGE); ?>"><i class="icon-user"></i> Change Cover Image </a></li>
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_DEACTIVATE); ?>"><i class="icon-remove"></i> Deactivate Account </a></li>
                </ul>
            </div>
        </li>
        <li>
            <!-- Single button -->
            <div class="btn-group">
                <a href="javascript:;" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-list"></i> List <span class="caret" style="float: none;"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_CONNECTION); ?>"><i class="icon-link"></i> Connection </a></li>
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_FOLLOWER); ?>"><i class="icon-user"></i> Followers </a></li>
                    <li><a class="" href="<?php echo site_url(SiteConfig::CONTROLLER_FOLLOWING); ?>"><i class="icon-user"></i> Followings </a></li><br clear="all"/>
                    
                </ul>
            </div>
        </li>


        <li><a class="btn btn-danger logout" href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGOUT); ?>"><i class="icon-lock"></i>  Logout </a></li>
    </ul>
</div>
<br class="clearfix"/>